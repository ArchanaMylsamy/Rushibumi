<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Constants\Status;

class AuthController extends Controller
{
    /**
     * Register API - Creates a new user account
     */
    public function register(Request $request)
    {
        // Check if registration is enabled
        if (!gs('registration')) {
            return responseError('registration_disabled', ['Registration is currently disabled']);
        }

        $countryData  = json_decode(file_get_contents(resource_path('views/partials/country.json')), true) ?? [];
        $countryNames = array_values(array_map(fn($countryInfo) => $countryInfo['country'], $countryData));

        $passwordValidation = \Illuminate\Validation\Rules\Password::min(6);
        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols();
        }

        // Make agree field optional for API - accept any value if provided, but don't require it
        // This matches web behavior where agree might not be strictly enforced
        $agree = 'nullable';

        $validator = Validator::make($request->all(), [
            // Name fields - at least one is required
            'firstname' => 'nullable|string|max:40',
            'lastname' => 'nullable|string|max:40',
            'display_name' => 'required|string|max:100|unique:users',
            
            // Contact information
            'email' => 'required|string|email:rfc,dns|max:191|unique:users,email',
            'phone_number' => ['required', 'string', 'max:20', 'unique:users', 'regex:/^\+?[1-9]\d{6,14}$/'],
            'country_name' => ['required', 'string', 'max:255', Rule::in($countryNames)],
            'address' => 'required|string',
            
            // Government ID
            'government_id' => 'required|string|max:50|unique:users',
            'government_id_type' => 'required|string|max:50|in:Passport,Driver License,National ID,Aadhar Card,SSN,Voter ID,PAN Card,Other',
            
            // Password and agreement
            'password' => ['required', 'confirmed', $passwordValidation],
            'captcha' => 'required',
            'agree' => $agree
        ], [
            // Custom error messages for password validation
            'password.mixed' => 'The password must contain both uppercase and lowercase letters.',
            'password.numbers' => 'The password must contain at least one number.',
            'password.symbols' => 'The password must contain at least one symbol.',
            'captcha.required' => 'Captcha is required.',
            'phone_number.regex' => 'Please enter a valid phone number.',
            'country_name.in' => 'Please select a valid country.',
        ]);

        // Custom validation: At least one of firstname or lastname must be provided
        $validator->after(function ($validator) use ($request) {
            $firstname = trim($request->firstname ?? '');
            $lastname  = trim($request->lastname ?? '');

            if ($firstname === '' && $lastname === '') {
                $validator->errors()->add('firstname', 'Either first name or last name is required.');
                $validator->errors()->add('lastname', 'Either first name or last name is required.');
            }

            if ($request->filled('government_id') && $request->filled('government_id_type') && !$this->isValidGovernmentId($request->government_id_type, $request->government_id)) {
                $validator->errors()->add('government_id', 'Please enter a valid government ID number for the selected ID type.');
            }
        });

        if ($validator->fails()) {
            return responseError('validation_error', $validator->errors()->all());
        }

        if (!verifyCaptcha()) {
            return responseError('invalid_captcha', ['Invalid captcha provided']);
        }

        // Create user
        $user = new User();
        
        // Basic information
        $user->email = strtolower($request->email);
        $user->password = Hash::make($request->password);
        
        // Name fields - at least one is required (validated above)
        $user->firstname = $request->firstname ?? '';
        $user->lastname = $request->lastname ?? '';
        $user->display_name = $request->display_name;
        
        // Contact information
        $user->phone_number = $request->phone_number;
        $user->country_name = $request->country_name;
        $user->address = $request->address;
        
        // Set mobile and dial_code for phone verification
        $countryData = json_decode(file_get_contents(resource_path('views/partials/country.json')), true);
        $dialCode = null;
        $countryCode = null;
        
        foreach ($countryData as $code => $countryInfo) {
            if (strtolower($countryInfo['country']) === strtolower($request->country_name)) {
                $countryCode = $code;
                $dialCode = $countryInfo['dial_code'];
                break;
            }
        }
        
        if ($dialCode) {
            $user->dial_code = $dialCode;
            $user->country_code = $countryCode;
            $user->mobile = preg_replace('/^\+?' . preg_quote($dialCode, '/') . '/', '', $request->phone_number);
            $user->mobile = preg_replace('/[^0-9]/', '', $user->mobile);
        }
        
        // Government ID
        $user->government_id = $request->government_id;
        $user->government_id_type = $request->government_id_type;
        
        // Verification status
        $user->kv = gs('kv') ? Status::NO : Status::YES;
        $user->ev = gs('ev') ? Status::NO : Status::YES;
        $user->sv = gs('sv') ? Status::NO : Status::YES;
        $user->phone_verified = Status::NO;
        $user->government_id_verified = Status::NO;
        $user->ts = Status::DISABLE;
        $user->tv = Status::ENABLE;
        
        $user->save();

        // Create admin notification
        $adminNotification = new \App\Models\AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New member registered';
        $adminNotification->click_url = urlPath('admin.users.detail', $user->id);
        $adminNotification->save();

        // Log user registration
        $this->logUserLogin($user);

        // Create token
        $token = $user->createToken('auth_token')->plainTextToken;

        return responseSuccess('registration_success', 'Registration successful', [
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'display_name' => $user->display_name,
            ],
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    /**
     * Login API - Returns JSON with token
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
            'captcha' => 'required',
        ]);

        if ($validator->fails()) {
            return responseError('validation_error', $validator->errors()->all());
        }

        if (!verifyCaptcha()) {
            return responseError('invalid_captcha', ['Invalid captcha provided']);
        }

        // Find username or email
        $login = $request->input('username');
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        $user = User::where($fieldType, $login)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return responseError('invalid_credentials', ['Invalid username or password']);
        }

        // Check if user is active
        if ($user->status != Status::USER_ACTIVE) {
            return responseError('account_inactive', ['Your account is not active']);
        }

        // Create token using Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        // Log login
        $this->logUserLogin($user);

        return responseSuccess('login_success', 'Login successful', [
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'image' => getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile')),
            ],
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    /**
     * Logout API - Deletes the token
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return responseSuccess('logout_success', 'Logged out successfully');
    }

    /**
     * Get current authenticated user
     */
    public function me(Request $request)
    {
        $user = $request->user();
        
        return responseSuccess('user_fetched', 'User fetched successfully', [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'image' => getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile')),
            'balance' => $user->balance,
            'status' => $user->status,
        ]);
    }

    /**
     * Log user login for API
     */
    private function logUserLogin($user)
    {
        $ip = getRealIP();
        $exist = UserLogin::where('user_ip', $ip)->first();
        $userLogin = new UserLogin();
        
        if ($exist) {
            $userLogin->longitude = $exist->longitude;
            $userLogin->latitude = $exist->latitude;
            $userLogin->city = $exist->city;
            $userLogin->country_code = $exist->country_code;
            $userLogin->country = $exist->country;
        } else {
            $info = json_decode(json_encode(getIpInfo()), true);
            $userLogin->longitude = @implode(',', $info['long']);
            $userLogin->latitude = @implode(',', $info['lat']);
            $userLogin->city = @implode(',', $info['city']);
            $userLogin->country_code = @implode(',', $info['code']);
            $userLogin->country = @implode(',', $info['country']);
        }

        $userAgent = osBrowser();
        $userLogin->user_id = $user->id;
        $userLogin->user_ip = $ip;
        $userLogin->browser = @$userAgent['browser'];
        $userLogin->os = @$userAgent['os_platform'];
        $userLogin->save();
    }

    private function isValidGovernmentId(string $governmentIdType, string $governmentId): bool
    {
        $governmentId = trim($governmentId);

        return match ($governmentIdType) {
            'Passport'       => preg_match('/^[A-Z0-9]{6,20}$/i', $governmentId) === 1,
            'Driver License' => preg_match('/^[A-Z0-9-]{5,30}$/i', $governmentId) === 1,
            'National ID'    => preg_match('/^[A-Z0-9-]{5,30}$/i', $governmentId) === 1,
            'Aadhar Card'    => preg_match('/^\d{12}$/', $governmentId) === 1,
            'SSN'            => preg_match('/^\d{3}-\d{2}-\d{4}$/', $governmentId) === 1,
            'Voter ID'       => preg_match('/^[A-Z0-9-]{5,30}$/i', $governmentId) === 1,
            'PAN Card'       => preg_match('/^[A-Z]{5}\d{4}[A-Z]$/', $governmentId) === 1,
            'Other'          => mb_strlen($governmentId) >= 5 && mb_strlen($governmentId) <= 50,
            default          => false,
        };
    }
}

