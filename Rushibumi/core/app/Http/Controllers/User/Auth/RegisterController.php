<?php

namespace App\Http\Controllers\User\Auth;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\Intended;
use App\Models\AdminNotification;
use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{

    use RegistersUsers;

    public function __construct()
    {
        parent::__construct();
    }

    public function showRegistrationForm()
    {
        $pageTitle = "Register";
        Intended::identifyRoute();
        return view('Template::user.auth.register', compact('pageTitle'));
    }


    protected function validator(array $data)
    {

        $passwordValidation = Password::min(6);

        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols();
        }

        $agree = 'nullable';
        if (gs('agree')) {
            $agree = 'required';
        }

        $validate = Validator::make($data, [
            // Name fields
            'surname' => 'required|string|max:40',
            'firstname' => 'required|string|max:40',
            'middle_name' => 'nullable|string|max:40',
            'family_name' => 'nullable|string|max:40',
            'lastname' => 'required|string|max:40',
            'display_name' => 'required|string|max:100|unique:users',
            
            // Contact information
            'email' => 'required|string|email|max:40|unique:users',
            'phone_number' => 'required|string|max:20|unique:users',
            'country_name' => 'required|string|max:255',
            'address' => 'required|string',
            
            // Government ID
            'government_id' => 'required|string|max:50|unique:users',
            'government_id_type' => 'required|string|max:50|in:Passport,Driver License,National ID,Aadhar Card,SSN,Voter ID,PAN Card,Other',
            
            // Password and agreement
            'password' => ['required', 'confirmed', $passwordValidation],
            'captcha' => 'sometimes|required',
            'agree' => $agree
        ], [
            'surname.required' => 'The surname field is required',
            'firstname.required' => 'The first name field is required',
            'lastname.required' => 'The last name field is required',
            'display_name.required' => 'The display name field is required',
            'display_name.unique' => 'This display name is already taken',
            'phone_number.required' => 'The phone number field is required',
            'phone_number.unique' => 'This phone number is already registered',
            'country_name.required' => 'The country field is required',
            'address.required' => 'The address field is required',
            'government_id.required' => 'The government ID field is required',
            'government_id.unique' => 'This government ID is already registered',
            'government_id_type.required' => 'The government ID type field is required',
            'government_id_type.in' => 'Please select a valid government ID type'
        ]);

        return $validate;
    }

    public function register(Request $request)
    {
        if (!gs('registration')) {
            $notify[] = ['error', 'Registration not allowed'];
            return back()->withNotify($notify);
        }
        $this->validator($request->all())->validate();

        $request->session()->regenerateToken();

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }



    protected function create(array $data)
    {
    
        //User Create
        $user = new User();
        
        // Basic information
        $user->email = strtolower($data['email']);
        $user->password = Hash::make($data['password']);
        
        // Name fields
        $user->surname = $data['surname'];
        $user->firstname = $data['firstname'];
        $user->middle_name = $data['middle_name'] ?? null;
        $user->family_name = $data['family_name'] ?? null;
        $user->lastname = $data['lastname'];
        $user->display_name = $data['display_name'];
        
        // Contact information
        $user->phone_number = $data['phone_number'];
        $user->country_name = $data['country_name'];
        $user->address = $data['address'];
        
        // Government ID
        $user->government_id = $data['government_id'];
        $user->government_id_type = $data['government_id_type'];
        
        // Verification status
        $user->kv = gs('kv') ? Status::NO : Status::YES;
        $user->ev = gs('ev') ? Status::NO : Status::YES;
        $user->sv = gs('sv') ? Status::NO : Status::YES;
        $user->phone_verified = Status::NO;
        $user->government_id_verified = Status::NO;
        $user->ts = Status::DISABLE;
        $user->tv = Status::ENABLE;
        
        $user->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $user->id;
        $adminNotification->title     = 'New member registered';
        $adminNotification->click_url = urlPath('admin.users.detail', $user->id);
        $adminNotification->save();


        //Login Log Create
        $ip        = getRealIP();
        $exist     = UserLogin::where('user_ip', $ip)->first();
        $userLogin = new UserLogin();

        if ($exist) {
            $userLogin->longitude    = $exist->longitude;
            $userLogin->latitude     = $exist->latitude;
            $userLogin->city         = $exist->city;
            $userLogin->country_code = $exist->country_code;
            $userLogin->country      = $exist->country;
        } else {
            $info                    = json_decode(json_encode(getIpInfo()), true);
            $userLogin->longitude    = @implode(',', $info['long']);
            $userLogin->latitude     = @implode(',', $info['lat']);
            $userLogin->city         = @implode(',', $info['city']);
            $userLogin->country_code = @implode(',', $info['code']);
            $userLogin->country      = @implode(',', $info['country']);
        }

        $userAgent          = osBrowser();
        $userLogin->user_id = $user->id;
        $userLogin->user_ip = $ip;

        $userLogin->browser = @$userAgent['browser'];
        $userLogin->os      = @$userAgent['os_platform'];
        $userLogin->save();


        return $user;
    }

    public function checkUser(Request $request){
        $exist['data'] = false;
        $exist['type'] = null;
        if ($request->email) {
            $exist['data'] = User::where('email',$request->email)->exists();
            $exist['type'] = 'email';
            $exist['field'] = 'Email';
        }
        if ($request->mobile) {
            $exist['data'] = User::where('mobile',$request->mobile)->where('dial_code',$request->mobile_code)->exists();
            $exist['type'] = 'mobile';
            $exist['field'] = 'Mobile';
        }
        if ($request->phone_number) {
            $exist['data'] = User::where('phone_number',$request->phone_number)->exists();
            $exist['type'] = 'phone_number';
            $exist['field'] = 'Phone Number';
        }
        if ($request->government_id) {
            $exist['data'] = User::where('government_id',$request->government_id)->exists();
            $exist['type'] = 'government_id';
            $exist['field'] = 'Government ID';
        }
        if ($request->display_name) {
            $exist['data'] = User::where('display_name',$request->display_name)->exists();
            $exist['type'] = 'display_name';
            $exist['field'] = 'Display Name';
        }
        if ($request->username) {
            $exist['data'] = User::where('username',$request->username)->exists();
            $exist['type'] = 'username';
            $exist['field'] = 'Username';
        }
        return response($exist);
    }

    public function registered()
    {
        return to_route('home');
    }

}
