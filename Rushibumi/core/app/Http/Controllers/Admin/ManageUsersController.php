<?php
namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\UserNotificationSender;
use App\Models\Deposit;
use App\Models\NotificationLog;
use App\Models\Subscriber;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Rules\FileTypeValidate;
use App\Traits\GetDateMonths;
use Carbon\Carbon;

class ManageUsersController extends Controller
{

    use GetDateMonths;

    public function allUsers()
    {
        $pageTitle = 'All Users';
        $users = $this->userData();
        return view('admin.users.list', compact('pageTitle', 'users'));
    }

    public function activeUsers()
    {
        $pageTitle = 'Active Users';
        $users = $this->userData('active');
        return view('admin.users.list', compact('pageTitle', 'users'));
    }

    public function bannedUsers()
    {
        $pageTitle = 'Banned Users';
        $users = $this->userData('banned');
        return view('admin.users.list', compact('pageTitle', 'users'));
    }

    public function emailUnverifiedUsers()
    {
        $pageTitle = 'Email Unverified Users';
        $users = $this->userData('emailUnverified');
        return view('admin.users.list', compact('pageTitle', 'users'));
    }

    public function kycUnverifiedUsers()
    {
        $pageTitle = 'KYC Unverified Users';
        $users = $this->userData('kycUnverified');
        return view('admin.users.list', compact('pageTitle', 'users'));
    }

    public function kycPendingUsers()
    {
        $pageTitle = 'KYC Pending Users';
        $users = $this->userData('kycPending');
        return view('admin.users.list', compact('pageTitle', 'users'));
    }

    public function emailVerifiedUsers()
    {
        $pageTitle = 'Email Verified Users';
        $users = $this->userData('emailVerified');
        return view('admin.users.list', compact('pageTitle', 'users'));
    }


    public function mobileUnverifiedUsers()
    {
        $pageTitle = 'Mobile Unverified Users';
        $users = $this->userData('mobileUnverified');
        return view('admin.users.list', compact('pageTitle', 'users'));
    }


    public function mobileVerifiedUsers()
    {
        $pageTitle = 'Mobile Verified Users';
        $users = $this->userData('mobileVerified');
        return view('admin.users.list', compact('pageTitle', 'users'));
    }


    public function usersWithBalance()
    {
        $pageTitle = 'Users with Balance';
        $users = $this->userData('withBalance');
        return view('admin.users.list', compact('pageTitle', 'users'));
    }




    public function monetizationRequest()
    {
        $pageTitle = 'Applying for Monetization';
        $users = $this->userData('monetizationRequest');
        return view('admin.users.list', compact('pageTitle', 'users'));
    }


    protected function userData($scope = null){
        if ($scope) {
            $users = User::$scope();
        }else{
            $users = User::query();
        }
        return $users->searchable(['username','email'])->orderBy('id','desc')->paginate(getPaginate());
    }


    public function detail($id)
    {
        $user = User::findOrFail($id);
        $pageTitle = 'User Detail - '.$user->username;

        $totalDeposit       = Deposit::where('user_id',$user->id)->successful()->sum('amount');
        $totalWithdrawals   = Withdrawal::where('user_id',$user->id)->approved()->sum('amount');
        $totalTransaction   = Transaction::where('user_id',$user->id)->count();
        $widget['totalSubscriber']    = $user->subscribers->count();
        $widget['totalVideos']        = $user->videos->count();
        $widget['totalRegularVideos'] = $user->videos()->regular()->count();
        $widget['totalShortsVideos'] = $user->videos()->shorts()->count();
        $widget['totalPublicVideos']  = $user->videos()->public()->count();
        $widget['totalPrivateVideos'] = $user->videos()->private()->count();
        $widget['totalStockVideos']   = $user->videos()->stock()->count();
        $widget['totalFreeVideos']    = $user->videos()->free()->count();
        $countries          = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        return view('admin.users.detail', compact('pageTitle', 'user','totalDeposit','totalWithdrawals','totalTransaction','countries', 'widget'));
    }


    public function kycDetails($id)
    {
        $pageTitle = 'KYC Details';
        $user = User::findOrFail($id);
        return view('admin.users.kyc_detail', compact('pageTitle','user'));
    }

    public function monetizationDetail($id){
        $pageTitle = 'Monetization Details';
        $user = User::where('monetization_status', '!=', Status::MONETIZATION_INITIATE)->findOrFail($id);
        $totalViews = $user->videos()->sum('views');
        $totalSubscriber = $user->subscribers()->count();

        return view('admin.users.monetization_detail', compact('pageTitle', 'user', 'totalViews', 'totalSubscriber'));

    }



    public function kycApprove($id)
    {
        $user = User::findOrFail($id);
        $user->kv = Status::KYC_VERIFIED;
        $user->save();

        notify($user,'KYC_APPROVE',[]);

        $notify[] = ['success','KYC approved successfully'];
        return to_route('admin.users.kyc.pending')->withNotify($notify);
    }

    public function kycReject(Request $request,$id)
    {
        $request->validate([
            'reason'=>'required'
        ]);

        $user = User::findOrFail($id);
        $user->kv = Status::KYC_UNVERIFIED;
        $user->kyc_rejection_reason = $request->reason;
        $user->save();

        notify($user,'KYC_REJECT',[
            'reason'=>$request->reason
        ]);

        $notify[] = ['success','KYC rejected successfully'];
        return to_route('admin.users.kyc.pending')->withNotify($notify);
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $countryData = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryArray   = (array)$countryData;
        $countries      = implode(',', array_keys($countryArray));

        $countryCode    = $request->country;
        $country        = $countryData->$countryCode->country;
        $dialCode       = $countryData->$countryCode->dial_code;

        $request->validate([
            'surname' => 'nullable|string|max:40',
            'firstname' => 'required|string|max:40',
            'middle_name' => 'nullable|string|max:40',
            'family_name' => 'nullable|string|max:40',
            'lastname' => 'required|string|max:40',
            'display_name' => 'required|string|max:100|unique:users,display_name,' . $user->id,
            'email' => 'required|email|string|max:40|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'country' => 'required|in:'.$countries,
            'government_id_type' => 'nullable|string|max:50|in:Passport,Driver License,National ID,Aadhar Card,SSN,Voter ID,PAN Card,Other',
            'government_id' => 'nullable|string|max:50',
        ]);

        // Check phone_number uniqueness if provided
        if ($request->phone_number) {
            $exists = User::where('phone_number',$request->phone_number)->where('id','!=',$user->id)->exists();
            if ($exists) {
                $notify[] = ['error', 'The phone number already exists.'];
                return back()->withNotify($notify);
            }
        }
        
        // Check government_id uniqueness if provided
        if ($request->government_id) {
            $exists = User::where('government_id',$request->government_id)->where('id','!=',$user->id)->exists();
            if ($exists) {
                $notify[] = ['error', 'The government ID already exists.'];
                return back()->withNotify($notify);
            }
        }

        // Name fields
        $user->surname = $request->surname ?? null;
        $user->firstname = $request->firstname;
        $user->middle_name = $request->middle_name ?? null;
        $user->family_name = $request->family_name ?? null;
        $user->lastname = $request->lastname;
        $user->display_name = $request->display_name;
        
        // Contact information
        $user->email = $request->email;
        $user->phone_number = $request->phone_number ?? null;
        $user->address = $request->address;
        $user->country_name = @$country;
        $user->dial_code = $dialCode;
        $user->country_code = $countryCode;
        
        // Extract mobile and dial_code from phone_number (for verification purposes)
        if ($request->phone_number && $dialCode) {
            // Extract mobile number (remove country code if present)
            $user->mobile = preg_replace('/^\+?' . preg_quote($dialCode, '/') . '/', '', $request->phone_number);
            $user->mobile = preg_replace('/[^0-9]/', '', $user->mobile); // Remove any non-numeric characters
        }
        
        // Government ID
        $user->government_id_type = $request->government_id_type ?? null;
        $user->government_id = $request->government_id ?? null;

        $user->ev = $request->ev ? Status::VERIFIED : Status::UNVERIFIED;
        $user->sv = $request->sv ? Status::VERIFIED : Status::UNVERIFIED;
        $user->ts = $request->ts ? Status::ENABLE : Status::DISABLE;
        if (!$request->kv) {
            $user->kv = Status::KYC_UNVERIFIED;
            if ($user->kyc_data) {
                foreach ($user->kyc_data as $kycData) {
                    if ($kycData->type == 'file') {
                        fileManager()->removeFile(getFilePath('verify').'/'.$kycData->value);
                    }
                }
            }
            $user->kyc_data = null;
        }else{
            $user->kv = Status::KYC_VERIFIED;
        }
        $user->save();

        $notify[] = ['success', 'User details updated successfully'];
        return back()->withNotify($notify);
    }



    public function login($id){
        Auth::loginUsingId($id);
        return to_route('user.home');
    }

    public function status(Request $request,$id)
    {
        $user = User::findOrFail($id);
        if ($user->status == Status::USER_ACTIVE) {
            $request->validate([
                'reason'=>'required|string|max:255'
            ]);
            $user->status = Status::USER_BAN;
            $user->ban_reason = $request->reason;
            $notify[] = ['success','User banned successfully'];
        }else{
            $user->status = Status::USER_ACTIVE;
            $user->ban_reason = null;
            $notify[] = ['success','User unbanned successfully'];
        }
        $user->save();
        return back()->withNotify($notify);

    }


    public function showNotificationSingleForm($id)
    {
        $user = User::findOrFail($id);
        if (!gs('en') && !gs('sn') && !gs('pn')) {
            $notify[] = ['warning','Notification options are disabled currently'];
            return to_route('admin.users.detail',$user->id)->withNotify($notify);
        }
        $pageTitle = 'Send Notification to ' . $user->username;
        return view('admin.users.notification_single', compact('pageTitle', 'user'));
    }

    public function sendNotificationSingle(Request $request, $id)
    {
        $request->validate([
            'message' => 'required',
            'via'     => 'required|in:email,sms,push',
            'subject' => 'required_if:via,email,push',
            'image'   => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        if (!gs('en') && !gs('sn') && !gs('pn')) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.dashboard')->withNotify($notify);
        }

        return (new UserNotificationSender())->notificationToSingle($request, $id);
    }

    public function showNotificationAllForm()
    {
        if (!gs('en') && !gs('sn') && !gs('pn')) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.dashboard')->withNotify($notify);
        }

        $notifyToUser = User::notifyToUser();
        $users        = User::active()->count();
        $pageTitle    = 'Notification to Verified Users';

        if (session()->has('SEND_NOTIFICATION') && !request()->email_sent) {
            session()->forget('SEND_NOTIFICATION');
        }

        return view('admin.users.notification_all', compact('pageTitle', 'users', 'notifyToUser'));
    }

    public function sendNotificationAll(Request $request)
    {
        $request->validate([
            'via'                          => 'required|in:email,sms,push',
            'message'                      => 'required',
            'subject'                      => 'required_if:via,email,push',
            'start'                        => 'required|integer|gte:1',
            'batch'                        => 'required|integer|gte:1',
            'being_sent_to'                => 'required',
            'cooling_time'                 => 'required|integer|gte:1',
            'number_of_top_deposited_user' => 'required_if:being_sent_to,topDepositedUsers|integer|gte:0',
            'number_of_days'               => 'required_if:being_sent_to,notLoginUsers|integer|gte:0',
            'image'                        => ["nullable", 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ], [
            'number_of_days.required_if'               => "Number of days field is required",
            'number_of_top_deposited_user.required_if' => "Number of top deposited user field is required",
        ]);

        if (!gs('en') && !gs('sn') && !gs('pn')) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.dashboard')->withNotify($notify);
        }

        return (new UserNotificationSender())->notificationToAll($request);
    }


    public function countBySegment($methodName){
        return User::active()->$methodName()->count();
    }

    public function list()
    {
        $query = User::active();

        if (request()->search) {
            $query->where(function ($q) {
                $q->where('email', 'like', '%' . request()->search . '%')->orWhere('username', 'like', '%' . request()->search . '%');
            });
        }
        $users = $query->orderBy('id', 'desc')->paginate(getPaginate());
        return response()->json([
            'success' => true,
            'users'   => $users,
            'more'    => $users->hasMorePages()
        ]);
    }

    public function notificationLog($id){
        $user = User::findOrFail($id);
        $pageTitle = 'Notifications Sent to '.$user->username;
        $logs = NotificationLog::where('user_id',$id)->with('user')->orderBy('id','desc')->paginate(getPaginate());
        return view('admin.reports.notification_history', compact('pageTitle','logs','user'));
    }



    public function monetizationChart(Request $request, $id) {

        $user = User::findOrFail($id);

        $diffInDays = Carbon::parse($request->start_date)->diffInDays(Carbon::parse($request->end_date));

        $groupBy = $diffInDays > 30 ? 'months' : 'days';
        $format  = $diffInDays > 30 ? '%M-%Y'  : '%d-%M-%Y';

        if ($groupBy == 'days') {
            $dates = $this->getAllDates($request->start_date, $request->end_date);
        } else {
            $dates = $this->getAllMonths($request->start_date, $request->end_date);
        }



        $totalViews = $user->videoImpression()->
            whereDate('created_at', '>=', $request->start_date)
            ->whereDate('created_at', '<=', $request->end_date)
            ->selectRaw('SUM(views) AS views')
            ->selectRaw("DATE_FORMAT(created_at, '{$format}') as created_on")
            ->latest()
            ->groupBy('created_on')
            ->get();


        $totalSubscribers = Subscriber::
            whereDate('created_at', '>=', $request->start_date)
            ->whereDate('created_at', '<=', $request->end_date)
            ->where('user_id', $user->id)
            ->selectRaw('Count(user_id) AS user_id')
            ->selectRaw("DATE_FORMAT(created_at, '{$format}') as created_on")
            ->latest()
            ->groupBy('created_on')
            ->get();

        $data = [];

        foreach ($dates as $date) {
            $data[] = [
                'created_on' =>  showDateTime($date, 'd-M-y'),
                'total_subscribers' =>$totalSubscribers->where('created_on', $date)->first()?->user_id ?? 0,
                'total_views' => $totalViews->where('created_on', $date)->first()?->views ?? 0,

            ];

        }


        $data = collect($data);

        $subscribers = $data->pluck('total_subscribers')->sum();
        $views = $data->pluck('total_views')->sum();
        $created_on = $data->pluck('created_on');


        return response()->json([
            'targetSubscribers' => gs('minimum_subscribe'),
            'actualSubscribers' => $subscribers,
            'targetViews' => gs('minimum_views'),
            'actualViews' => $views,
            'created_on'=> $created_on

        ]);
    }

    public function monetizationApprove($id){
        $user = User::findOrFail($id);
        $user->monetization_status = Status::MONETIZATION_APPROVED;
        $user->save();
        $notify[] =['success', 'Monetization status updated successfully.'];
        return back()->withNotify($notify);
    }

    public function monetizationReject($id){
        $user = User::findOrFail($id);
        $user->monetization_status = Status::MONETIZATION_CANCEL;
        $user->save();
        $notify[] =['success', 'Monetization status updated successfully.'];
        return back()->withNotify($notify);
    }

}
