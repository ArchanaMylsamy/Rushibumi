<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Constants\Status;

class AuthController extends Controller
{
    /**
     * Login API - Returns JSON with token
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return responseError('validation_error', $validator->errors()->all());
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
}

