<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Validator;
use Notification;
use Session;
use App\Notifications\SignupEmailVerification;
use App\Notifications\ForgotPasswordNotification;
use App\Notifications\ChangeEmailNotification;
use App\User;
use App\UserDetails;
use App\Provider;
use App\Consumer;
use App\ServiceCategory;
use App\Jobs;
use DB;
use Helper;
use Auth;
use Hash;
use Exception;

class UserController extends Controller
{
    //
    /**
     * --------------------------------------------------------
     * CONSUMER SIGNUP API
     * --------------------------------------------------------
     */
    public function ConsumerSignup(Request $request)
    {
        # code...
        $val = Validator::make($request->all(), [
            # rules for validation
            'first_name' => 'required|string|regex:/^[\pL\s\-]+$/u',
            'last_name' => 'required|string|regex:/^[\pL\s\-]+$/u',
            'phone_no' => 'required|numeric|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password|min:6',

        ], [
            'first_name.regex' => 'The first name may only contains letters',
            'last_name.regex' => 'The last name may only contains letters'
        ]);
        if ($val->fails()) {
            return response()->json(['status' => false, 'message' => $val->errors()->first(), 'response' => []]);
        }
        // if(User::where('email',$request->email)->count() >= 2){
        //     return response()->json(['status'=>false,'message'=>' please signup with different email','response'=>[]]);
        // }
        else {
            $user_id = User::insertGetId([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_no' => $request->phone_no,
                'device_token' => $request->device_token,
                'device_type' => $request->device_type,
                'role' => 'consumer',
                'email' => $request->email,
                'password'  => bcrypt($request->password),
                'address' => $request->address,
                'lat' => $request->lat,
                'long' => $request->long,
                // 'email_verified_at'=>'1'
            ]);
            UserDetails::insert([
                'user_id' => $user_id,
                'user_role' => 'consumer'
            ]);
            Consumer::insert([
                'user_id' => $user_id,
                'user_role' => 'consumer'
            ]);
            ServiceCategory::insert([
                'user_id' => $user_id,
                'user_role' => 'consumer',
                'current_location' => $request->address
            ]);
            if ($request->hasFile('image')) {
                $name = 'user_image_' . mt_rand(10, 1000) . '.' . $request->image->extension();
                $request->image->move(public_path() . '/images/user_images/consumer/id-' . $user_id, $name);
                // $complete_path = url('/') . '/images/user_images/consumer/id-'.$request->user_id.'/'.UserDetails::where('user_id',$request->user_id)->first()->image;
                UserDetails::where('user_id', $user_id)->update(['image' => $name]);
            }
            $verificationLink = url('/') . '/user/email-verification/' . Crypt::encryptString($user_id);
            try {
                Notification::send(User::find($user_id), new SignupEmailVerification($request->email, $verificationLink));
            } catch (\Exception $e) {
                return response()->json(['status' => true, 'message' => 'Signup successfull ! A verification link is successfully sent to your registered email id please complete the email verification process', 'response' => User::find($user_id)]);
            }
            return response()->json(['status' => true, 'message' => 'Signup successfull ! A verification link is successfully sent to your registered email id please complete the email verification process', 'response' => User::find($user_id)]);
        }
    }
    /**
     * --------------------------------------------------------
     * Provider SIGNUP API
     * --------------------------------------------------------
     */
    public function ProviderSignup(Request $request)
    {
        # code...
        $val = Validator::make($request->all(), [
            # rules for validation
            'first_name' => 'required|string|regex:/^[\pL\s\-]+$/u',
            'last_name' => 'required|string|regex:/^[\pL\s\-]+$/u',
            'phone_no' => 'required|numeric|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password|min:6',
            'service' => 'required',
            // 'state'=>'required',
            // 'country'=>'required',
            // 'account_number'=>'required'
        ], [
            'first_name.regex' => 'The first name may only contains letters',
            'last_name.regex' => 'The last name may only contains letters'
        ]);
        // return response()->json(['data'=>Jobs::where('job_category',$request->service)->where('provider_id','0')->select('consumer_id')->get()]);

        if ($val->fails()) {
            return response()->json(['status' => false, 'message' => $val->errors()->first(), 'response' => []]);
        }

        if (Provider::where('service', $request->service)->count() == 0) {
            $consumer_id = Jobs::where('job_category', $request->service)
                ->where('provider_id', '0')
                // ->select('consumer_id')
                ->get();
            // $notification_data = [
            //     'title'=>'Ji ayann nu ',

            //     'type'=>'romeo lb gya',
            //     'body'=>'Biree thode vaste provider lb gya hai ',
            // ];
            // return response()->json(['status'=>false,'message'=>[$consumer_id],'response'=>[]]);
            $notification_data = [
                'title' => 'Greetings ',

                'type' => 'provider found',
                'body' => "We've found someone matching your requirements",
            ];
            if ($consumer_id) {
                foreach ($consumer_id as $row) {

                    $to = User::where('id', $row->consumer_id)->first()->device_token;
                    // echo $to;
                    Helper::sendPushNotification(Helper::firebaseServerKey(), $to, $notification_data);
                    // echo "<br/>";
                    //echo $row;

                    // return $row->consumer_id;
                    // print($row->consumer_id);
                    //Helper::sendPushNotification(Helper::firebaseServerKey(),User::where('id',$row->consumer_id)->first()->device_token,$notification_data);
                }
            }


            $user_id = User::insertGetId([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_no' => $request->phone_no,
                'device_token' => $request->device_token,
                'device_type' => $request->device_type,
                'role' => 'provider',
                'email' => $request->email,
                'password'  => bcrypt($request->password),
                'address' => $request->address,
                // 'state'=>$request->state,
                // 'country'=>$request->country,
                'lat' => $request->lat,
                'long' => $request->long,
                // 'email_verified_at'=>'1'
                // 'account_number'=>$request->account_number
            ]);
            UserDetails::insert([
                'user_id' => $user_id,
                'user_role' => 'provider'
            ]);
            Provider::insert([
                'user_id' => $user_id,
                'service' => $request->service,
            ]);
            if ($request->hasFile('image')) {
                $name = 'user_image_' . mt_rand(10, 1000) . '.' . $request->image->extension();
                $request->image->move(public_path() . '/images/user_images/provider/id-' . $user_id, $name);
                // $complete_path = url('/') . '/images/user_images/provider/id-'.$request->user_id.'/'.UserDetails::where('user_id',$request->user_id)->first()->image;
                UserDetails::where('user_id', $user_id)->update(['image' => $name]);
            }
            $verificationLink = url('/') . '/user/email-verification/' . Crypt::encryptString($user_id);

            if ($consumer_id) {
                foreach ($consumer_id as $row) {
                    DB::table('notifications')->insert([
                        'job_id' => '0',
                        'consumer_id' => $row->consumer_id,
                        'provider_id' => $user_id,
                        'type' => '4', // find provider for empty job

                        'title' => 'Hi',
                        'msg_title' => 'provider found',
                        'description' => "is available for your posted job"
                    ]);
                }
            }
            try {
                Notification::send(User::find($user_id), new SignupEmailVerification($request->email, $verificationLink));
            } catch (\Exception $e) {
                return response()->json(['status' => true, 'message' => 'Signup successfull ! A verification link is successfully sent to your registered email id please complete the email verification process', 'response' => User::find($user_id)]);
            }
            return response()->json(['status' => true, 'message' => 'Signup successfull ! A verification link is successfully sent to your registered email id please complete the email verification process', 'response' => User::find($user_id)]);
        } else {
            $user_id = User::insertGetId([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_no' => $request->phone_no,
                'device_token' => $request->device_token,
                'device_type' => $request->device_type,
                'role' => 'provider',
                'email' => $request->email,
                'password'  => bcrypt($request->password),
                'address' => $request->address,
                // 'state'=>$request->state,
                // 'country'=>$request->country,
                'lat' => $request->lat,
                'long' => $request->long,
                // 'email_verified_at'=>'1'
                // 'account_number'=>$request->account_number
            ]);
            UserDetails::insert([
                'user_id' => $user_id,
                'user_role' => 'provider'
            ]);
            Provider::insert([
                'user_id' => $user_id,
                'service' => $request->service,
            ]);
            if ($request->hasFile('image')) {
                $name = 'user_image_' . mt_rand(10, 1000) . '.' . $request->image->extension();
                $request->image->move(public_path() . '/images/user_images/provider/id-' . $user_id, $name);
                // $complete_path = url('/') . '/images/user_images/provider/id-'.$request->user_id.'/'.UserDetails::where('user_id',$request->user_id)->first()->image;
                UserDetails::where('user_id', $user_id)->update(['image' => $name]);
            }
            $verificationLink = url('/') . '/user/email-verification/' . Crypt::encryptString($user_id);
            try {
                Notification::send(User::find($user_id), new SignupEmailVerification($request->email, $verificationLink));
            } catch (\Exception $e) {
                return response()->json(['status' => true, 'message' => 'Signup successfull ! A verification link is successfully sent to your registered email id please complete the email verification process', 'response' => User::find($user_id)]);
            }
            return response()->json(['status' => true, 'message' => 'Signup successfull ! A verification link is successfully sent to your registered email id please complete the email verification process', 'response' => User::find($user_id)]);
        }
    }

    /**
     * -------------------------------------------------------
     * SOCIAL SIGNUP -- VIA GOOGLE, FACEBOOK, APPLE STORE
     * -------------------------------------------------------
     */
    public function socialSignup(Request $request)
    {
        $val = Validator::make($request->all(), [
            # rules for validation
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            // 'phone_no' => 'required|numeric|unique:users',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:provider,consumer',
            // 'social_id'=>'',
            'social_login_type' => 'required|in:google,facebook,apple',
        ]);
        // return response()->json(['data'=>Jobs::where('job_category',$request->service)->where('provider_id','0')->select('consumer_id')->get()]);
        $user = DB::table('users')->where('email', $request->email)->first();
        if ($val->fails()) {
            return response()->json(['status' => false, 'message' => $val->errors()->first(), 'response' => []]);
        }
        if ($user) {
            if (DB::table('users')->where('email', $request->email)->first()->role == 'provider') {
                // User::where('email',$request->email)->update(['social_login_type'=>$request->social_login_type,'social_id'=>$request->social_id]);
                $data = DB::table('users')
                    ->join('user_details', 'users.id', '=', 'user_details.user_id')
                    ->where('users.email', $request->email)
                    ->select('users.*', 'user_details.user_id', 'user_details.onboarding_status', 'user_details.user_role', 'user_details.stripe_account_id', 'user_details.stripe_refresh_token')
                    ->first();
                return response()->json(['status' => false, 'message' => 'User is already registerd on this platform as a provider having same email', 'response' => $data]);
            }
            if (DB::table('users')->where('email', $request->email)->first()->role == 'consumer') {
                // User::where('email',$request->email)->update(['social_login_type'=>$request->social_login_type,'social_id'=>$request->social_id]);
                $data = User::where('email', $request->email)->first();
                return response()->json(['status' => false, 'message' => 'User is already registered on this platform as a consumer having same email', 'response' => $data]);
            }
        } else {
            if ($request->role == 'provider') {
                if (Provider::where('service', $request->service)->count() == 0) {
                    $consumer_id = Jobs::where('job_category', $request->service)->where('provider_id', '0')->select('consumer_id')->get();
                    // $notification_data = [
                    //     'title'=>'Ji ayann nu ',

                    //     'type'=>'romeo lb gya',
                    //     'body'=>'Biree thode vaste provider lb gya hai ',
                    // ];
                    $notification_data = [
                        'title' => 'Greetings ',

                        'type' => 'provider found',
                        'body' => "We've found someone matching your requirements",
                    ];

                    foreach ($consumer_id as $row) {
                        // return $row->consumer_id;
                        Helper::sendPushNotification(Helper::firebaseServerKey(), User::where('id', $row->consumer_id)->first()->device_token, $notification_data);
                    }
                    $user_id = User::insertGetId([
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'phone_no' => $request->phone_no,
                        'device_token' => $request->device_token,
                        'device_type' => $request->device_type,
                        'role' => 'provider',
                        'email' => $request->email,
                        'password'  => bcrypt($request->password),
                        'address' => $request->address,
                        // 'state'=>$request->state,
                        // 'country'=>$request->country,
                        'lat' => $request->lat,
                        'long' => $request->long,
                        // 'email_verified_at'=>'1'
                        // 'account_number'=>$request->account_number
                    ]);
                    UserDetails::insert([
                        'user_id' => $user_id,
                        'user_role' => 'provider'
                    ]);
                    Provider::insert([
                        'user_id' => $user_id,
                        'service' => $request->service,
                    ]);
                    if ($request->hasFile('image')) {
                        $name = 'user_image_' . mt_rand(10, 1000) . '.' . $request->image->extension();
                        $request->image->move(public_path() . '/images/user_images/provider/id-' . $user_id, $name);
                        // $complete_path = url('/') . '/images/user_images/provider/id-'.$request->user_id.'/'.UserDetails::where('user_id',$request->user_id)->first()->image;
                        UserDetails::where('user_id', $user_id)->update(['image' => $name]);
                    }
                    $verificationLink = url('/') . '/user/email-verification/' . Crypt::encryptString($user_id);

                    foreach ($consumer_id as $row) {
                        DB::table('notifications')->insert([
                            'job_id' => '0',
                            'consumer_id' => $row->consumer_id,
                            'provider_id' => $user_id,
                            'type' => '4', // accept job invitation

                            'title' => 'Hi',
                            'msg_title' => $notification_data['type'],
                            'description' => "is available for your posted job"
                        ]);
                    }
                    try {
                        Notification::send(User::find($user_id), new SignupEmailVerification($request->email, $verificationLink));
                    } catch (\Exception $e) {
                        return response()->json(['status' => true, 'message' => 'Signup successfull ! A verification link is successfully sent to your registered email id please complete the email verification process', 'response' => User::find($user_id)]);
                    }
                    return response()->json(['status' => true, 'message' => 'Signup successfull ! A verification link is successfully sent to your registered email id please complete the email verification process', 'response' => User::find($user_id)]);
                }
                $user_id = User::insertGetId([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone_no' => $request->phone_no,
                    'device_token' => $request->device_token,
                    'device_type' => $request->device_type,
                    'social_login_type' => $request->social_login_type,
                    'social_id' => $request->social_id,
                    'role' => 'provider',
                    'email' => $request->email,
                    'email_verified_at' => '1',
                    // 'password'  => bcrypt($request->password),
                    'address' => $request->address,
                    'state' => $request->state,
                    'country' => $request->country,
                    'lat' => $request->lat,
                    'long' => $request->long,
                    // 'account_number'=>$request->account_number
                ]);
                UserDetails::insert([
                    'user_id' => $user_id,
                    'user_role' => 'provider'
                ]);
                Provider::insert([
                    'user_id' => $user_id,
                    'service' => $request->service,
                ]);
                if ($request->hasFile('image')) {
                    $name = 'user_image_' . mt_rand(10, 1000) . '.' . $request->image->extension();
                    $request->image->move(public_path() . '/images/user_images/provider/id-' . $user_id, $name);
                    // $complete_path = url('/') . '/images/user_images/provider/id-'.$request->user_id.'/'.UserDetails::where('user_id',$request->user_id)->first()->image;
                    UserDetails::where('user_id', $user_id)->update(['image' => $name]);
                }
                $data = DB::table('users')
                    ->join('user_details', 'users.id', '=', 'user_details.user_id')
                    ->where('users.email', $request->email)
                    ->select('users.*', 'user_details.user_id', 'user_details.onboarding_status', 'user_details.user_role', 'user_details.stripe_account_id', 'user_details.stripe_refresh_token')
                    ->first();
                return response()->json(['status' => true, 'message' => 'Provider signup successfull', 'response' => $data]);
            }
            if ($request->role == 'consumer') {
                $user_id = User::insertGetId([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone_no' => $request->phone_no,
                    'device_token' => $request->device_token,
                    'device_type' => $request->device_type,
                    'social_login_type' => $request->social_login_type,
                    'social_id' => $request->social_id,
                    'role' => 'consumer',
                    'email' => $request->email,
                    'email_verified_at' => '1',
                    // 'password'  => bcrypt($request->password),
                    'address' => $request->address,
                    'lat' => $request->lat,
                    'long' => $request->long,
                ]);
                UserDetails::insert([
                    'user_id' => $user_id,
                    'user_role' => 'consumer'
                ]);
                Consumer::insert([
                    'user_id' => $user_id,
                    'user_role' => 'consumer'
                ]);
                ServiceCategory::insert([
                    'user_id' => $user_id,
                    'user_role' => 'consumer',
                    'current_location' => $request->address
                ]);
                if ($request->hasFile('image')) {
                    $name = 'user_image_' . mt_rand(10, 1000) . '.' . $request->image->extension();
                    $request->image->move(public_path() . '/images/user_images/consumer/id-' . $user_id, $name);
                    // $complete_path = url('/') . '/images/user_images/consumer/id-'.$request->user_id.'/'.UserDetails::where('user_id',$request->user_id)->first()->image;
                    UserDetails::where('user_id', $user_id)->update(['image' => $name]);
                }
                return response()->json(['status' => true, 'message' => 'Consumer signup successfull', 'response' => User::find($user_id)]);
            }
        }
    }
    /**
     * -------------------------------------------------------------
     * SOCIAL LOGIN API --  to login via google ,  apple, facebook
     * -------------------------------------------------------------
     */
    public function socialLogin(Request $request)
    {
        $val = Validator::make($request->all(), [
            #rules for validation
            'username' => 'required',
            'social_id' => 'required',
            'social_login_type' => 'required|in:google,facebook,apple'
        ]);
        $user = User::Where('email', $request->username)->first();
        if ($val->fails()) {
            return response()->json(['status' => false, 'message' => $val->errors()->first(), 'response' => []]);
        }
        // dd($user->role,$user->social_login_type);
        if ($user === null) {
            return response()->json(['status' => false, 'message' => 'Invalid credentials ! user not found ', 'response' => []]);
        }

        $user = User::where('email', $request->username)->first();
        if ($user) {

            // if($user->email_verified_at == '0'){
            //     return response()->json(['status'=>false,'message'=>"The consumer email is not verified","response"=>[]]);
            // }
            if ($user->is_blocked == '1') {
                return response()->json(['status' => false, 'message' => "Your account has been blocked by administator", "response" => []]);
            }
            if ($user->social_login_type  != $request->social_login_type) {
                // dd('hello');
                // User::where('email',$request->username)->update(['social_login_type'=>$request->social_login_type,'social_id'=>$request->social_id]);
                if ($user->role === 'consumer') {
                    User::where('email', $request->username)->update(['social_login_type' => $request->social_login_type, 'social_id' => $request->social_id, 'device_token' => $request->device_token]);
                    $data = User::where('email', $request->username)->first();
                    return response()->json(['status' => true, 'message' => 'consumer social login', 'response' => $data]);
                } elseif ($user->role === 'provider') {
                    User::where('email', $request->username)->update(['social_login_type' => $request->social_login_type, 'social_id' => $request->social_id, 'device_token' => $request->device_token]);
                    $data = DB::table('users')
                        ->join('user_details', 'users.id', '=', 'user_details.user_id')
                        ->where('users.email', $request->username)
                        ->select('users.*', 'user_details.user_id', 'user_details.onboarding_status', 'user_details.user_role', 'user_details.stripe_account_id', 'user_details.stripe_refresh_token')
                        ->first();
                    return response()->json(['status' => true, 'message' => 'provider social login successfull', 'response' => $data]);
                }
            } else {
                if ($user->role === 'consumer') {
                    User::where('email', $request->username)->update(['social_login_type' => $request->social_login_type, 'social_id' => $request->social_id, 'device_token' => $request->device_token]);
                    $data = User::where('email', $request->username)->first();
                    return response()->json(['status' => true, 'message' => 'consumer login via facebook succcessfull', 'response' => $data]);
                } elseif ($user->role === 'provider') {
                    User::where('email', $request->username)->update(['social_login_type' => $request->social_login_type, 'social_id' => $request->social_id, 'device_token' => $request->device_token]);
                    $data = DB::table('users')
                        ->join('user_details', 'users.id', '=', 'user_details.user_id')
                        ->where('users.email', $request->username)
                        ->select('users.*', 'user_details.user_id', 'user_details.onboarding_status', 'user_details.user_role', 'user_details.stripe_account_id', 'user_details.stripe_refresh_token')
                        ->first();
                    return response()->json(['status' => true, 'message' => 'provider login via facebook successfull', 'response' => $data]);
                } elseif ($user->role === 'admin') {
                    return response()->json(['status' => false, 'message' => "Login denied ! these credentials belong to admin, you don't have permissions to login using these credentials", "response" => []]);
                }
                // return response()->json(['status'=>false,'message'=>"The user email is not verified","response"=>[]]);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'User not found']);
        }

        #login via facebook -- checklist
        // if($request->social_login_type == 'facebook'){
        //     if(User::where('email',$request->username)->where('social_login_type',$request->social_login_type)->first()){
        //         if($user->email_verified_at == '0'){
        //             return response()->json(['status'=>false,'message'=>"The consumer email is not verified","response"=>[]]);
        //         }
        //         if($user->is_blocked == '1'){
        //             return response()->json(['status'=>false,'message'=>"Your account has been blocked by administator","response"=>[]]);
        //         }
        //         else{
        //             if($user->role ==='consumer'){
        //                 User::where('email',$request->username)->update(['device_token'=>$request->device_token]);
        //                 $data = User::where('email',$request->username)->first();
        //                 return response()->json(['status'=>true,'message'=>'consumer login via facebook succcessfull','response'=>$data]);
        //             }
        //             elseif($user->role ==='provider'){
        //                 User::where('email',$request->username)->update(['device_token'=>$request->device_token]);
        //                 $data = DB::table('users')
        //                             ->join('user_details','users.id','=','user_details.user_id')
        //                             ->where('users.email',$request->username)
        //                             ->select('users.*','user_details.user_id','user_details.onboarding_status','user_details.user_role','user_details.stripe_account_id','user_details.stripe_refresh_token')
        //                             ->first();
        //                 return response()->json(['status'=>true,'message'=>'provider login via facebook successfull','response'=>$data]);
        //             }
        //             elseif($user->role ==='admin'){
        //                 return response()->json(['status'=>false,'message'=>"Login denied ! these credentials belong to admin, you don't have permissions to login using these credentials","response"=>[]]);
        //             }
        //             // return response()->json(['status'=>false,'message'=>"The user email is not verified","response"=>[]]);
        //         }

        //     }
        //    # later
        //     // if(User::where('phone_no',$request->username)->first() and Hash::check($request->password,User::where('phone_no',$request->username)->first()->password))
        //     // {

        //     // }
        //     else{
        //         return response()->json(['status'=>false,'message'=>'Please select different social login type','response'=>[]]);
        //     }
        // }
        // #login via google -- checklist
        // if($request->social_login_type == 'google'){
        //     if(User::where('email',$request->username)->where('social_login_type',$request->social_login_type)->first()){
        //         if($user->email_verified_at == '0'){
        //             return response()->json(['status'=>false,'message'=>"The consumer email is not verified","response"=>[]]);
        //         }
        //         if($user->is_blocked == '1'){
        //             return response()->json(['status'=>false,'message'=>"Your account has been blocked by administator","response"=>[]]);
        //         }
        //         else{
        //             if($user->role ==='consumer'){
        //                 User::where('email',$request->username)->update(['device_token'=>$request->device_token]);
        //                 $data = DB::table('users')->where('email',$request->username)->first();
        //                 return response()->json(['status'=>true,'message'=>'consumer via google login succcessfull','response'=>$data]);
        //             }
        //             elseif($user->role ==='provider'){
        //                 User::where('email',$request->username)->update(['device_token'=>$request->device_token]);
        //                 $data = DB::table('users')
        //                             ->join('user_details','users.id','=','user_details.user_id')
        //                             ->where('users.email',$request->username)
        //                             ->select('users.*','user_details.user_id','user_details.onboarding_status','user_details.user_role','user_details.stripe_account_id','user_details.stripe_refresh_token')
        //                             ->first();
        //                 return response()->json(['status'=>true,'message'=>'provider login via google successfull','response'=>$data]);
        //             }
        //             elseif($user->role ==='admin'){
        //                 return response()->json(['status'=>false,'message'=>"Login denied ! these credentials belong to admin, you don't have permissions to login using these credentials","response"=>[]]);
        //             }
        //             // return response()->json(['status'=>false,'message'=>"The user email is not verified","response"=>[]]);
        //         }

        //     }
        //     # later
        //     // if(User::where('phone_no',$request->username)->first() and Hash::check($request->password,User::where('phone_no',$request->username)->first()->password))
        //     // {

        //     // }
        //     else{
        //         return response()->json(['status'=>false,'message'=>'Please select different social login type','response'=>[]]);
        //     }
        // }
        // # login via apple store -- checklist
        // if($request->social_login_type == 'apple'){
        //     if(User::where('email',$request->username)->where('social_login_type',$request->social_login_type)->first()){
        //         if($user->email_verified_at == '0'){
        //             return response()->json(['status'=>false,'message'=>"The consumer email is not verified","response"=>[]]);
        //         }
        //         if($user->is_blocked == '1'){
        //             return response()->json(['status'=>false,'message'=>"Your account has been blocked by administator","response"=>[]]);
        //         }
        //         else{
        //             if($user->role ==='consumer'){
        //                 User::where('email',$request->username)->update(['device_token'=>$request->device_token]);
        //                 $data = DB::table('users')->where('email',$request->username)->first();
        //                 return response()->json(['status'=>true,'message'=>'consumer via apple store login succcessfull','response'=>$data]);
        //             }
        //             elseif($user->role ==='provider'){
        //                 User::where('email',$request->username)->update(['device_token'=>$request->device_token]);
        //                 $data = DB::table('users')
        //                             ->join('user_details','users.id','=','user_details.user_id')
        //                             ->where('users.email',$request->username)
        //                             ->select('users.*','user_details.user_id','user_details.onboarding_status','user_details.user_role','user_details.stripe_account_id','user_details.stripe_refresh_token')
        //                             ->first();
        //                 return response()->json(['status'=>true,'message'=>'provider login via apple store successfull','response'=>$data]);
        //             }
        //             elseif($user->role ==='admin'){
        //                 return response()->json(['status'=>false,'message'=>"Login denied ! these credentials belong to admin, you don't have permissions to login using these credentials","response"=>[]]);
        //             }
        //             // return response()->json(['status'=>false,'message'=>"The user email is not verified","response"=>[]]);
        //         }

        //     }
        //     # later
        //     // if(User::where('phone_no',$request->username)->first() and Hash::check($request->password,User::where('phone_no',$request->username)->first()->password))
        //     // {

        //     // }
        //     else{
        //         return response()->json(['status'=>false,'message'=>'Please select different social login type','response'=>[]]);
        //     }
        // }
    }
    /**
     * -----------------------------------------
     * VERIFY USER EMAIL AND SET IT STATUS TO ONE
     * -----------------------------------------
     */
    public function verifyEmail($id)
    {
        // dd(User::where('id',Crypt::decryptString($id))->first()->id);
        User::where('id', Crypt::decryptString($id))->update(['email_verified_at' => '1']);
        // return response()->json([
        //     'status'=>true,
        //     'message'=>"The email verification process is successfully completed",
        //     'response'=>User::find($id)
        // ]);
        return view('layouts.verificationcomplete');
    }
    /**
     * -----------------------------------------
     * USER LOGIN API
     * -----------------------------------------
     */
    public function userLogin(Request $request)
    {
        $val = Validator::make($request->all(), [
            #rules for validation
            'username' => 'required|string',
            'password' => 'required|string|',
            // 'device_token'=>'required|string|'
        ]);
        if ($val->fails()) {
            return response()->json(['status' => false, 'message' => $val->errors()->first(), 'response' => []]);
        } else {
            $user = User::where('phone_no', $request->username)->orWhere('email', $request->username)->first();
            if ($user === null) {
                return response()->json(['status' => false, 'message' => 'Invalid credentials ! username does not match ', 'response' => []]);
            }
            // if($request->role === 'provider'){
            if ($user->role === 'provider') {
                if (Auth::attempt(['email' => $request->input('username'), 'password' => $request->input('password'), 'email_verified_at' => '1', 'role' => 'provider'])) {
                    // dd(Auth::user()->id);
                    User::where('id', Auth::user()->id)->update(['device_token' => $request->device_token, 'device_type' => $request->device_type]);
                    $data = DB::table('users')
                        ->join('user_details', 'users.id', '=', 'user_details.user_id')
                        ->where('users.id', Auth::user()->id)
                        ->select('users.*', 'user_details.user_id', 'user_details.onboarding_status', 'user_details.user_role', 'user_details.stripe_account_id', 'user_details.stripe_refresh_token')
                        ->first();
                    // return response()->json(['status'=>true,'message'=>'provider login successfull','response'=>Auth::user()]);
                    return response()->json(['status' => true, 'message' => 'provider login successfull', 'response' => $data]);
                } elseif (Auth::attempt(['phone_no' => $request->input('username'), 'password' => $request->input('password'), 'email_verified_at' => '1', 'role' => 'provider'])) {
                    User::where('id', Auth::user()->id)->update(['device_token' => $request->device_token, 'device_type' => $request->device_type]);
                    $data = DB::table('users')
                        ->join('user_details', 'users.id', '=', 'user_details.user_id')
                        ->where('users.id', Auth::user()->id)
                        ->select('users.*', 'user_details.user_id', 'user_details.onboarding_status', 'user_details.user_role', 'user_details.stripe_account_id', 'user_details.stripe_refresh_token')
                        ->first();
                    // return response()->json(['status'=>true,'message'=>'provider login successfull','response'=>Auth::user()]);
                    return response()->json(['status' => true, 'message' => 'provider login successfull', 'response' => $data]);
                }
            }
            // }
            // if($request->role === 'consumer'){
            if ($user->role === 'consumer') {
                if (Auth::attempt(['email' => $request->input('username'), 'password' => $request->input('password'), 'email_verified_at' => '1', 'role' => 'consumer'])) {
                    User::where('id', Auth::user()->id)->update(['device_token' => $request->device_token, 'device_type' => $request->device_type]);
                    return response()->json(['status' => true, 'message' => 'consumer login succcessfull', 'response' => Auth::user()]);
                } elseif (Auth::attempt(['phone_no' => $request->input('username'), 'password' => $request->input('password'), 'email_verified_at' => '1', 'role' => 'consumer'])) {
                    User::where('id', Auth::user()->id)->update(['device_token' => $request->device_token, 'device_type' => $request->device_type]);
                    return response()->json(['status' => true, 'message' => 'consumer login succcessfull', 'response' => Auth::user()]);
                }
            }
            // }
            // if(Auth::attempt(['email'=>$request->input('username'),'password'=>$request->input('password'),'email_verified_at'=>'1','role'=>'consumer'])){
            //     return response()->json(['status'=>true,'message'=>'consumer login succcessfull','response'=>[]]);
            // }
            // elseif(Auth::attempt(['phone_no'=>$request->input('username'),'password'=>$request->input('password'),'email_verified_at'=>'1','role'=>'provider'])){
            //     return response()->json(['status'=>true,'message'=>'provider login successfull','response'=>[]]);
            // }
            return response()->json(['status' => false, 'message' => 'Invalid credentials ! password does not match', 'response' => []]);
        }
    }
    /**
     * ---------------------------------------------
     * Logout api
     * ---------------------------------------------
     */
    public function userLogout(Request $request)
    {
        $val = Validator::make($request->all(), [
            #rules for validation
            'user_id' => 'required|string',

        ]);
        if ($val->fails()) {
            return response()->json(['status' => false, 'message' => $val->errors()->first(), 'response' => []]);
        } else {
            User::where('id', $request->user_id)->update(['device_token' => '']);
            return response()->json(['status' => true, 'message' => 'user logout successfull', 'response' => []]);
        }
    }
    /**
     * ---------------------------------------------
     * CHANGE PASSWORD API
     * ---------------------------------------------
     */
    public function changePassword(Request $request)
    {
        $val = Validator::make($request->all(), [
            // rules for validation
            'id' => 'required',
            'old_password' => 'required',
            'new_password' => 'required|min:8|different:password',
        ]);
        if ($val->fails()) {
            return response()->json(['status' => false, 'message' => $val->errors()->first(), 'response' => []]);
        } else {
            $user = User::find($request->id);
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'User with the mentioned id does not exist', 'response' => []]);
            }
            if ($user->email_verified_at != '1') {
                if ($user->role === 'consumer') {
                    return response()->json(['status' => false, 'message' => 'The consumer email is not verified', 'response' => []]);
                }
                if ($user->role === 'provider') {
                    return response()->json(['status' => false, 'message' => 'The provider email is not verified', 'response' => []]);
                }
            }
            if (Hash::check($request->old_password, $user->password) and $user->remember_me_as != 'admin') {
                $user->fill(['password' => Hash::make($request->new_password)])->save();
                return response()->json(['status' => true, 'message' => 'Password is updated successfully', 'response' => $user]);
            }
            if ($user->role === 'admin') {
                return response()->json(['status' => false, 'message' => 'you dont have permissions to change password for ths id', 'reponse' => []]);
            } else {
                return response()->json(['status' => false, "message" => "Please enter the correct old password", 'response' => []]);
            }
        }
    }
    /**
     * -------------------------------------------------
     * FORGOT PASSWORD API
     * -------------------------------------------------
     */
    public function forgotPassword(Request $request)
    {
        $rulesForValidation = [
            'email' => 'required|email',
        ];
        $val = validator::make($request->all(), $rulesForValidation);
        if ($val->fails()) {
            return response()->json(['status' => 'false', 'message' => $val->errors()->first(), 'response' => []]);
        }
        $user = User::where('email', $request->email)->first();
        // dd($user->id);
        if ($user == null) {
            return response()->json(['status' => false, 'message' => 'Please enter correct email address ! specified email is not found', 'response' => []]);
        } else {
            $verificationLink = url('/') . "/user/forgot-password/password-reset-link/" . Crypt::encryptString($request->email) . "/" . time();
            try {
                Notification::send(User::find($user->id), new ForgotPasswordNotification($request->email, $verificationLink));
            } catch (\Exception $e) {
                return response()->json(['status' => true, 'message' => 'The reset password link is successfully sent to your registered email', 'response' => $user]);
            }
            return response()->json(['status' => true, 'message' => 'The reset password link is successfully sent to your registered email', 'response' => $user]);
        }
    }
    /**
     * -----------------------------------------------------
     * RESET PASSWORD OF A USER
     * -----------------------------------------------------
     */
    public function resetPassword(Request $request, $email, $time)
    {
        if ($request->isMethod('post')) {
            // dd($request->all());
            // dd( time() - $time);
            $val = Validator::make($request->all(), [
                'password' => 'required',
                'confirm_password' => 'required'
            ]);
            if ($val->fails()) {
                Session::flash('error_message', $val->errors()->first());
                return redirect()->back();
            } else {
                $email = Crypt::decryptString($email);
                if (time() - $time <= 300) {
                    if ($request->password == $request->confirm_password) {
                        User::where('email', $email)->update(['password' => bcrypt($request->password)]);
                        Session::flash('success_message', 'password is changed successfully');
                        return redirect()->back();
                    } else {
                        Session::flash('error_message', 'The password and confirm password fields should be same');
                        return redirect()->back();
                    }
                } else {

                    Session::flush();
                }
            }
        } else {
            return view('layouts.resetpassword')->with(compact('email', 'time'));
        }
    }
    /**
     * ---------------------------------------------------------------
     * CHANGE PHONE NUMBER API
     * ---------------------------------------------------------------
     */
    public function updatePhoneNumber(Request $request)
    {
        // dd('hello');
        $user = User::find($request->user_id);
        $val = Validator::make($request->all(), [
            'user_id' => 'required',
            // 'old_phone'=>'required|numeric|min:11',
            'new_phone' => 'required|numeric|min:11',
            // 'name'=>'required'
        ]);
        if ($val->fails()) {
            return response()->json(['status' => 'false', 'message' => $val->errors()->first(), 'response' => []]);
        }
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User with the mentioned id does not exsist', 'response' => []]);
        } else {
            // if($user->phone_no != $request->old_phone){
            //     return response()->json(['status'=>false,'message'=>'The old phone number credentials does not match with the registered phone number','response'=>[]]);
            // }
            // if($user->email_verified_at != '1'){
            //     return response()->json(['status'=>false,'message'=>'The user email is not verified ! please complete the verification process first','response'=>[]]);
            // }
            if (User::where('phone_no', $request->new_phone)->first() != null) {
                return response()->json(['status' => false, 'message' => 'The new phone number is already been taken by another user', 'response' => []]);
            }
            User::where('id', $request->user_id)->update(['phone_no' => $request->new_phone]);
            return response()->json(['status' => true, 'message' => 'Phone number is updated successfully', 'response' => $user]);
        }
    }
    /**
     * ---------------------------------------------------------------
     * UPDATE EMAIL API
     * ---------------------------------------------------------------
     */
    public function updateEmail(Request $request)
    {
        $val = Validator::make($request->all(), [
            'old_email' => 'required|email',
            'new_email' => 'required|email|different:email',
        ]);
        if ($val->fails()) {
            return response()->json(['status' => false, 'message' => $val->errors()->first()]);
        }
        if ($request->old_email === $request->new_email) {
            return response()->json(['status' => false, 'message' => 'Please enter different email address', 'response' => []]);
        } else {
            $user = User::where('email', $request->old_email)->first();
            if (User::where('email', $request->new_email)->first()) {
                return response()->json(['status' => false, 'message' => 'The new email is already been taken by another user', 'response' => []]);
            }
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'The user with mentioned email address does not exsist', 'response' => []]);
            }
            if ($user->email_verified_at != '1') {
                return response()->json(['status' => false, 'message' => 'The user email is not verified ! please complete the verification process first', 'response' => []]);
            }
            User::where('email', $request->old_email)->update(['email_verified_at' => '0', 'email' => $request->new_email]);
            $verificationLink = url('/') . '/user/email-verification/' . Crypt::encryptString($user->id);
            try {
                Notification::send(User::find($user->id), new ChangeEmailNotification($request->new_email, $verificationLink));
            } catch (\Exception $e) {
                return response()->json(['status' => true, 'message' => 'The change email link is successfully sent to your new email id', 'response' => $user]);
            }
            return response()->json(['status' => true, 'message' => 'The change email link is successfully sent to your new email id', 'response' => $user]);
        }
    }
    public function split_name($name)
    {
        $name = trim($name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim(preg_replace('#' . preg_quote($last_name, '#') . '#', '', $name));
        return response()->json(['data' => array($first_name, $last_name)]);
    }
    public function updateName(Request $request)
    {
        $user = User::find($request->user_id);
        $val = Validator::make($request->all(), [
            'user_id' => 'required',
            'name' => 'required',
        ]);
        if ($val->fails()) {
            return response()->json(['status' => false, 'message' => $val->errors()->first()]);
        }
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User with the mentioned id does not exsist']);
        } else {
            $name = trim($request->name);
            $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
            $first_name = trim(preg_replace('#' . preg_quote($last_name, '#') . '#', '', $name));

            if ($user->email_verified_at != '1') {
                return response()->json(['status' => false, 'message' => 'The user email is not verified ! please complete the verification process first', 'response' => []]);
            }
            User::where('id', $request->user_id)->update([
                'first_name' => $first_name,
                'last_name' => $last_name,
            ]);
            return response()->json(['status' => true, 'message' => 'Name is updated successfully', 'response' => $user]);
        }
    }
    /**
     * -------------------------------------------------------------
     * FETCH PROFILE API
     * -------------------------------------------------------------
     */
    public function fetchProfile(Request $request)
    {
        $val = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($val->fails()) {
            return response()->json(['status' => false, 'message' => $val->errors()->first(), 'response' => []]);
        }
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User with the mentioned id does not exsist', 'response' => []]);
        } else {
            if ($user->role === 'consumer') {

                // $data = [
                //     'id'=>User::where('id',$request->user_id)->first()->id,
                //     'user_id'=>UserDetails::where('user_id',$request->user_id)->first()->user_id,
                //     'first_name'=>User::where('id',$request->user_id)->first()->first_name,
                //     'last_name'=>User::where('id',$request->user_id)->first()->first_name,
                //     'phone_no'=>User::where('id',$request->user_id)->first()->phone_no,
                //     'role'=>User::where('id',$request->user_id)->first()->role,
                //     'email'=>User::where('id',$request->user_id)->first()->email,
                //     'email_verified_at'=>User::where('id',$request->user_id)->first()->email_verified_at,
                //     'address'=>User::where('id',$request->user_id)->first()->address,
                //     'image'=>url('/') . '/images/user_images/consumer/id-'.$request->user_id.'/'.UserDetails::where('user_id',$request->user_id)->first()->image,
                // ];
                // if(UserDetails::where('user_id',$request->user_id)->first()->image == null){
                //     // $data['image'] = null;
                //     $data['image']=url('/').'/images/user_images/dummy.jpg';
                // }
                $data = DB::table('users')
                    ->join('user_details', 'user_details.user_id', '=', 'users.id')
                    ->where('user_details.user_id', $request->user_id)
                    ->select(
                        'users.id',
                        'user_details.user_id',
                        'users.first_name',
                        'users.last_name',
                        'users.phone_no',
                        'users.role',
                        'users.email',
                        'users.email_verified_at',
                        'users.address',
                        'users.lat',
                        'users.long',
                        'user_details.image'
                    )
                    ->first();
                if ($data->image != null) {
                    $data->image = url('/') . '/images/user_images/consumer/id-' . $data->user_id . '/' . $data->image;
                } else {
                    $data->image = url('/') . '/images/user_images/dummy.jpg';
                }
                return response()->json(['status' => true, 'message' => 'Data fetched succssfull', 'response' => $data]);
            }
            if ($user->role === 'provider') {
                // $data = [
                //     'id'=>User::where('id',$request->user_id)->first()->id,
                //     // 'user_id'=>UserDetails::where('user_id',$request->user_id)->first()->user_id,
                //     'first_name'=>User::where('id',$request->user_id)->first()->first_name,
                //     'last_name'=>User::where('id',$request->user_id)->first()->first_name,
                //     'phone_no'=>User::where('id',$request->user_id)->first()->phone_no,
                //     'role'=>User::where('id',$request->user_id)->first()->role,
                //     'email'=>User::where('id',$request->user_id)->first()->email,
                //     'email_verified_at'=>User::where('id',$request->user_id)->first()->email_verified_at,
                //     'address'=>User::where('id',$request->user_id)->first()->address,
                //     'state'=>User::where('id',$request->user_id)->first()->state,
                //     'country'=>User::where('id',$request->user_id)->first()->country,
                //     'account_number'=>User::where('id',$request->user_id)->first()->account_number,
                //     'image'=>url('/') . '/images/user_images/provider/id-'.$request->user_id.'/'.UserDetails::where('user_id',$request->user_id)->first()->image,
                // ];
                // if(UserDetails::where('user_id',$request->user_id)->first()->image == null){
                //     $data['image'] = null;
                // }
                $data = DB::table('users')
                    ->join('user_details', 'user_details.user_id', '=', 'users.id')
                    ->where('user_details.user_id', $request->user_id)
                    ->select(
                        'users.id',
                        'user_details.user_id',
                        'users.first_name',
                        'users.last_name',
                        'users.phone_no',
                        'users.role',
                        'users.email',
                        'users.email_verified_at',
                        'users.address',
                        'users.routing_account_number',
                        'user_details.image'
                    )
                    ->first();
                if ($data->image != null) {
                    $data->image = url('/') . '/images/user_images/provider/id-' . $data->user_id . '/' . $data->image;
                } else {
                    $data->image = url('/') . '/images/user_images/dummy.jpg';
                }
                return response()->json(['status' => true, 'message' => 'Data fetched succssfull', 'response' => $data]);
            } // ->select('users.*','user_details.user_role','user_details.onboarding_status','user_details.stripe_account_id','user_details.stripe_refresh_token','user_details')
            // return response()->json(['status'=>true,'message'=>'Data fetched succssfull','response'=>$user]);
        }
    }
    /**
     * -------------------------------------------------------------
     * UPDATE PROFILE API -- provider screeen
     * -------------------------------------------------------------
     */
    public function updateProviderProfile(Request $request)
    {
        $val = Validator::make($request->all(), [
            'user_id' => 'required',
            // 'address'=>'required',
            // 'company_name'=>'required',
            // 'experience'=>'required|numeric',
            // 'rate' => 'required|numeric',  // making it optional as per new ammendments in app
            // 'company_description'=>'|min:35',
            'account_number' => 'required|numeric',
            // 'routing_account_number'=>'required|numeric' // // making it optional as per new ammendments in app
        ]);
        if ($val->fails()) {
            return response()->json(['status' => false, 'message' => $val->errors()->first(), 'response' => []]);
        }
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User with the mentioned id does not exsist', 'response' => []]);
        }
        if (UserDetails::where('user_id', $request->user_id)->first()->user_role === 'consumer') {
            return response()->json(['status' => false, 'message' => 'Profile cannot be updated ! This user id belongs to consumer', 'response' => []]);
        } else {
            // dd($request->all());
            $user = User::where('id', $request->user_id)->first();
            User::where('id', $request->user_id)->update([
                'address' => isset($request->address) ? $request->address : $user->address,
                'account_number' => isset($request->account_number) ? $request->account_number : $user->account_number,
                'routing_account_number' => isset($request->routing_account_number) ? $request->routing_account_number : $user->routing_account_number,
                'state' => isset($request->state) ? $request->state : $user->state,
                'country' => isset($request->country) ? $request->country : $user->country,
                'lat' => isset($request->lat) ? $request->lat : $user->lat,
                'long' => isset($request->long) ? $request->long : $user->long,
            ]);
            UserDetails::where('user_id', $request->user_id)->update([
                // 'company_name'=>isset($request->company_name) ? $request->company_name : UserDetails::find($request->user_id)->company_name,
                // 'service'=>isset($request->service) ? $request->service : UserDetails::find($request->user_id)->service,
                // 'experience'=>isset($request->experience) ? $request->experience : UserDetails::find($request->user_id)->experience,
                // 'rate'=>isset($request->rate) ? $request->rate : UserDetails::find($request->user_id)->rate,
                // 'company_description'=>isset($request->company_description) ? $request->company_description : UserDetails::find($request->user_id)->company_description,
                'company_name' => $request->company_name,
                'service' => $request->service,
                'experience' => $request->experience,
                'rate' => $request->rate,
                'company_description' => $request->company_description
            ]);
            Provider::where('user_id', $request->user_id)->update([
                // 'company_name'=>isset($request->company_name) ? $request->company_name : Provider::where('user_id',$request->user_id)->first()->company_name,
                // 'service'=>isset($request->service) ? $request->service : Provider::where('user_id',$request->user_id)->first()->service,
                // 'experience'=>isset($request->experience) ? $request->experience : Provider::where('user_id',$request->user_id)->first()->experience,
                // 'rate'=>isset($request->rate) ? $request->rate : Provider::where('user_id',$request->user_id)->first()->rate,
                // 'company_description'=>isset($request->company_description) ? $request->company_description : Provider::where('user_id',$request->user_id)->first()->company_description,
                'company_name' => $request->company_name,
                'service' => $request->service,
                'experience' => $request->experience,
                'rate' => $request->rate,
                'company_description' => $request->company_description
            ]);
            // dd(Helper::doneJobsImagesUrls());

            if ($request->hasFile('image')) { // check if there is a file present in the postman request
                $name = 'user_image_' . mt_rand(10, 1000) . '.' . $request->image->extension();
                $request->image->move(public_path() . '/images/user_images/provider/id-' . $request->user_id, $name);
                // $complete_path = url('/') . '/images/user_images/provider/id-'.$request->user_id.'/'.UserDetails::where('user_id',$request->user_id)->first()->image;
                UserDetails::where('user_id', $user->id)->update(['image' => $name]);
            }
            if ($request->hasFile('done_jobs_images')) { // check if there is a image file present in the postman request
                foreach ($request->file('done_jobs_images') as $file) {
                    // if($file->extension() === 'jpeg' or $file->extension() === 'jpg' or $file->extension() === 'png' or $file->extension() === 'svg' or $file->extension() === 'webp'){
                    $name = 'done_jobs_image_' . mt_rand(10, 1000) . '.' . $file->extension();
                    $done_jobs_data[] = $name;
                    $file->move(public_path() . '/images/jobs/provider/done_jobs_images/id-' . $request->user_id, $name);
                    // }
                    // else{
                    //     return response()->json(['status'=>false,'message'=>'Images uploading process failed ! The image should be of JPEG, PNG, SVG, WEBP format','response'=>[]]);
                    // }
                }
                foreach (explode(',', Provider::where('user_id', $request->user_id)->first()->done_jobs_images) as $img) {
                    $done_jobs_images[] = $img;
                }
                $new = array_merge($done_jobs_data, $done_jobs_images); //make new array
                // dd($new);
                Provider::where('user_id', $request->user_id)->update(['done_jobs_images' => implode(",", $done_jobs_data)]); // convert that array into strings and put it into database
            }
            // $imgUrls = [];


            // foreach(explode(',',Provider::where('user_id',$request->user_id)->first()->done_jobs_images) as $img){
            //     if ($img == null){
            //         break;
            //     }
            //     else{
            //         $imgUrls[]=Helper::doneJobsImagesUrls().'id-'.$request->user_id.'/'.$img;
            //     }
            // }
            $data = DB::table('providers')
                ->join('user_details', 'user_details.user_id', '=', 'providers.user_id')
                ->join('users', 'users.id', '=', 'user_details.user_id')
                ->where('user_details.user_id', $request->user_id)
                ->select(
                    'users.id',
                    'user_details.user_id',
                    'users.address',
                    'providers.company_name',
                    'providers.service',
                    'providers.experience',
                    'providers.rate',
                    'providers.company_description',
                    'user_details.image',
                    'providers.done_jobs_images'
                )
                ->first();
            if ($data->image != null) {
                $data->image = url('/') . '/images/user_images/provider/id-' . $data->user_id . '/' . $data->image;
            } else {
                $data->image = url('/') . '/images/user_images/dummy.jpg';
            }
            if ($data->done_jobs_images != null) {
                // $data->doneimage = url('/').'/images/user_images/provider/id-'.$data->user_id.'/'.$data->image;
                $imgUrls = [];
                foreach (explode(',', $data->done_jobs_images) as $img) {
                    // dd($img);
                    if ($img == null) {
                        break;
                    }
                    $imgUrls[] = url('/') . '/images/jobs/provider/done_jobs_images/id-' . $request->user_id . '/' . $img;
                }
                $data->done_jobs_images = $imgUrls;
            }
            // $data = [
            //     'id'=>UserDetails::where('user_id',$request->user_id)->first()->id,
            //     'user_id'=>UserDetails::where('user_id',$request->user_id)->first()->user_id,
            //     'address'=>User::where('id',$request->user_id)->first()->address,
            //     'company_name'=>Provider::where('user_id',$request->user_id)->first()->company_name,
            //     'service'=>Provider::where('user_id',$request->user_id)->first()->service,
            //     'experience'=>Provider::where('user_id',$request->user_id)->first()->experience,
            //     'rate'=>Provider::where('user_id',$request->user_id)->first()->rate,
            //     'company_description'=>Provider::where('user_id',$request->user_id)->first()->company_description,
            //     'image'=>url('/') . '/images/user_images/provider/id-'.$request->user_id.'/'.UserDetails::where('user_id',$request->user_id)->first()->image,
            //     'done_jobs_images'=>$imgUrls,

            // ];
            // if(UserDetails::where('user_id',$request->user_id)->first()->image == null){
            //     $data['image'] = null;
            // }
            return response()->json(['status' => true, 'message' => 'The profile is updated successfully ', 'response' => $data]);
        }
    }
    /**
     * ---------------------------------------------------------------
     * UPDATE DONE JOBS IMAGES -- provider update profile homescreen
     * ---------------------------------------------------------------
     */
    public function updateDoneJobsImages(Request $request)
    {
        $val = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($val->fails()) {
            return response()->json(['status' => false, 'message' => $val->errors()->first(), 'response' => []]);
        }
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User with the mentioned id does not exsist', 'response' => []]);
        }
        if (UserDetails::where('user_id', $request->user_id)->first()->user_role === 'consumer') {
            return response()->json(['status' => false, 'message' => 'Profile cannot be updated ! This user id belongs to consumer', 'response' => []]);
        }
        if ($request->hasFile('done_jobs_images')) { // check if there is a image file present in the postman request
            $done_jobs_data = [];
            // foreach($request->file('done_jobs_images') as $file)
            // {
            //     if($file->extension() === 'jpeg' or $file->extension() === 'jpg' or $file->extension() === 'png' or $file->extension() === 'svg' or $file->extension() === 'webp')
            //     {
            $file = $request->done_jobs_images;
            $name = 'done_jobs_image_' . mt_rand(10, 1000) . '.' . $file->extension();
            $done_jobs_data[] = $name;
            $file->move(public_path() . '/images/jobs/provider/done_jobs_images/id-' . $request->user_id, $name);
            // }
            // else{
            //     return response()->json(['status'=>false,'message'=>'Images uploading process failed ! The image should be of JPEG, PNG, SVG, WEBP format','response'=>[]]);
            // }
            // }
            foreach (explode(',', Provider::where('user_id', $request->user_id)->first()->done_jobs_images) as $img) {
                $done_jobs_images[] = $img;
            }
            $new = array_merge($done_jobs_data, $done_jobs_images); //make new array
            // dd($new);
            Provider::where('user_id', $request->user_id)->update(['done_jobs_images' => implode(",", $new)]); // convert that array into strings and put it into database
        }
        $imgUrls = [];
        foreach (explode(',', Provider::where('user_id', $request->user_id)->first()->done_jobs_images) as $img) {
            if ($img == null) {
                break;
            } else {
                $imgUrls[] = Helper::doneJobsImagesUrls() . 'id-' . $request->user_id . '/' . $img;
            }
        }
        $data = [
            'done_jobs_images' => $imgUrls,
        ];
        if (Provider::where('user_id', $request->user_id)->first()->done_jobs_images == null) {
            $data['image'] = null;
        }
        return response()->json(['status' => true, 'message' => 'The provider done_jobs_images is updated successfully ', 'response' => $data]);
        if (!$request->done_jobs_images) {
            return response()->json(['status' => false, 'message' => 'Please select files to upload on server ', 'response' => []]);
        }
    }
    /**
     * ---------------------------------------------------------------------------------
     * UPDATE PROFILE API -- consumer screen
     * ---------------------------------------------------------------------------------
     */
    public function updateConsumerProfile(Request $request)
    {
        $val = Validator::make($request->all(), [
            'user_id' => 'required',
            // 'name'=>'required',
            // 'phone_no'=>'required',
            // 'address'=>'required',
        ]);
        if ($val->fails()) {
            return response()->json(['status' => false, 'message' => $val->errors()->first(), 'response' => []]);
        }
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User with the mentioned id does not exsist', 'response' => []]);
        }
        if (UserDetails::where('user_id', $request->user_id)->first()->user_role === 'provider') {
            return response()->json(['status' => false, 'message' => 'Profile cannot be updated ! This user id belongs to provider', 'response' => []]);
        } else {
            $name = trim($request->name);
            $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
            $first_name = trim(preg_replace('#' . preg_quote($last_name, '#') . '#', '', $name));

            user::where('id', $request->user_id)->update([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'phone_no' => $request->phone_no,
                'address' => $request->address
            ]);
            if ($request->hasFile('image')) { // check if there is a file present in the postman request
                $name = 'user_image_' . mt_rand(10, 1000) . '.' . $request->image->extension();
                $request->image->move(public_path() . '/images/user_images/consumer/id-' . $request->user_id, $name);
                // $complete_path = url('/') . '/images/user_images/consumer/id-'.$request->user_id;
                UserDetails::where('user_id', $user->id)->update(['image' => $name]);
            }
            // change the fields at the time of creating new build
            // $data = DB::table('users')
            //             ->join('user_details','user_details.user_id','=','users.id')
            //             ->where('user_details.user_id',$request->user_id)
            //             ->select('users.id','users.user_id','users.first_name','users.phone_no','users.address','user_details.image')
            //             ->first();
            // if($data->image != null){
            //     $data->image = url('/').'/images/user_images/consumer/id-'.$data->user_id.'/'.$data->image;
            // }
            $data = [
                'id' => UserDetails::where('user_id', $request->user_id)->first()->id,
                'user_id' => UserDetails::where('user_id', $request->user_id)->first()->user_id,
                'name' => User::where('id', $request->user_id)->first()->first_name,
                'phone' => User::where('id', $request->user_id)->first()->phone_no,
                'address' => User::where('id', $request->user_id)->first()->address,
                'image' => url('/') . '/images/user_images/consumer/id-' . $request->user_id . '/' . UserDetails::where('user_id', $request->user_id)->first()->image,
            ];
            if (UserDetails::where('user_id', $request->user_id)->first()->image == null) {
                $data['image'] = null;
            }
            return response()->json(['status' => true, 'message' => 'The profile is updated successfully', 'response' => $data]);
        }
    }
    //  help and feedback
    public function helpAndFeedbackSupport(Request $request)
    {
        $val = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($val->fails()) {
            return response()->json(['status' => false, 'message' => $val->errors()->first(), 'response' => []]);
        }
        $user = UserDetails::where('user_id', $request->user_id)->first();
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User with the mentioned id does not exsist', 'response' => []]);
        } else {
            UserDetails::where('user_id', $request->user_id)->update(['feedback' => $request->feedback, 'description' => $request->description]);
            return response()->json(['status' => true, 'message' => 'Your feedback is saved successfully', 'response' => $user]);
        }
    }
    public function hello(Request $request)
    {
        $val = Validator::make($request->all(), [
            // 'user_id'=>'required',
        ]);
        if ($val->fails()) {
            return response()->json(['status' => false, 'message' => $val->errors()->first(), 'response' => []]);
        } else {
            $consumer_id = Jobs::where('job_category', $request->service)
                ->join('users', 'users.id', '=', 'jobs.consumer_id')
                ->where('provider_id', '0')
                ->get();
            $notification_data = [
                'title' => 'Ji ayann nu ',

                'type' => 'romeo lb gya',
                'body' => 'Biree thode vaste provider lb gya hai ',
            ];
            // $notification_data = [
            //     'title'=>'Greetings ',

            //     'type'=>'provider found',
            //     'body'=>"We've found someone matching your requirements",
            // ];

            // foreach($consumer_id as $row){
            //     // return $row->consumer_id;
            //     Helper::sendPushNotification(Helper::firebaseServerKey(),User::where('id',$row->consumer_id)->first()->device_token,$notification_data);
            // }
            foreach ($consumer_id->pluck('device_token') as $to) {
                print($to);
                echo '<br/>';
                Helper::sendPushNotification(Helper::firebaseServerKey(), $to, $notification_data);
            }

            return response()->json(['status' => false, 'message' => 'it works', 'response' => $consumer_id->pluck('consumer_id')]);
        }
    }
    /**
     * -----------------------------------------------------------------------------
     * Login with employee id
     * -----------------------------------------------------------------------------
     */
    public function loginWithEmployeeID(Request $request)
    {
        $val = Validator::make($request->all(), [
            'employee_id' => 'required|exists:users,employee_id',
            // 'device_token' => 'required',
            // 'device_type' => 'required|in:a,i'
        ]);
        if ($val->fails()) {
            return response()->json(['status' => false, 'message' => $val->errors()->first(), 'response' => []]);
        } else {
            $auth = User::where(['employee_id' => $request->employee_id])->first();
            if ($auth) {
                User::where('id', $auth->id)->update(['device_token' => $request->device_token, 'device_type' => $request->device_type]);
                $data = DB::table('users')
                    ->join('user_details', 'users.id', '=', 'user_details.user_id')
                    ->where('users.id', $auth->id)
                    ->select('users.*', 'user_details.user_id', 'user_details.onboarding_status', 'user_details.user_role', 'user_details.rate', 'user_details.stripe_account_id', 'user_details.stripe_refresh_token')
                    ->first();
                // return response()->json(['status'=>true,'message'=>'provider login successfull','response'=>Auth::user()]);
                return response()->json(['status' => true, 'message' => 'provider login successfull', 'response' => $data]);
            } else {
                return response()->json(['status' => false, 'message' => 'Invalid credentails', 'response' => []]);
            }
        }
    }
}
