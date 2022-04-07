<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Twilio\Rest\Client;
use App\Models\VerifyUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\EmailVerification;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**-------------------------------------------------------------------------------------------
     * sendOtp
     *
     * THIS METHOD IS FOR SEND OTP
     * ____________________________________________________________________________________________
     */

    private function sendOTP(string $message, string $recipient)
    {
        $twilio_number = getenv('TWILIO_NUMBER');

        $account_sid = config('app.twilio')['TWILIO_ACCOUNT_SID'];
        $auth_token = config('app.twilio')['TWILIO_AUTH_TOKEN'];
        // echo $twilio_number . ' sid: ' . $account_sid . 'auth_token: ' . $auth_token;die;
        $client = new Client($account_sid, $auth_token);

        return $client->messages->create($recipient, array('from' => $twilio_number, 'body' => $message));
    }
    /**-------------------------------------------------------------------------------------------
     * register
     *
     * THIS METHOD IS USER FOR REGISTER NEW USER
     * ____________________________________________________________________________________________
     */
    public function register(Request $request)
    {

        $validated =  Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone_no' => 'required|numeric',
            'country_code' => 'required|numeric',
            'address' => 'required',
            'lat' => 'required',
            'long' => 'required',
        ]);

        if ($validated->fails()) {
            return response()->json(['status' => false, 'message' => $validated->errors()->first()]);
        } else {
            $data = [
                
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_no,
                'country_code' => $request->country_code,
                'address' => $request->address,
                'lat' => $request->lat,
                'long' => $request->long,
                'otp' => random_int(100000, 999999),

            ];

            // dd($request->phone_no);

            // $user = User::create($data);
            // $id = $user->id;
            $id = User::insertGetId($data);

            $verifyUser = VerifyUser::create([
                'user_id' => $id,
                'token' => Str::random(40),
            ]);

           // $user->notify(new EmailVerification($user));
            //$message = $data['otp'] . " is your bedabeda app OTP to verify your account. Do not share it with anyone.";
            //$phone_no = $data['country_code'].$data['phone_no'];
            // $this->sendOtp($message, $phone_no);
            return response()->json(['status' => true, 'message' => 'Register Successfully!', 'details' => User::find($id)]);
        }
    }

    
    /**-------------------------------------------------------------------------------------------
     * LoginWithEmail
     *
     * THIS METHOD IS FOR LOGIN WITH EMAIL AND PASSWORD
     * ____________________________________________________________________________________________
     */
    public function login(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'password' => 'required|min:6',
        ]);

        if ($validated->fails()) {
            return response()->json(['status' => false, 'message' => $validated->errors()->first()]);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = $request->user();
            if ($user->email_verified == '0') {
            	return response()->json(['status' => false, 'message' => 'Before proceeding,please verify your email address first.']);
            }
            if ($user->is_blocked == '1') {
            	return response()->json(['status' => false, 'message' => 'Your account has been blocked by admin.']);
            }

            if ($user->is_phone_no_verified == '0') {
            	return response()->json(['status' => false, 'message' => 'Before proceeding,please verify your phoneNo address first.']);
            }
             else {

            $appResponse = [

                'id' => $user->id,
                'email' => $user->email,
                'phone_no' => $user->phone_no,
                'address'=>$user->address,
                'is_email_verified' => $user->is_email_verified,
                'is_phone_no_verified' => $user->is_phone_no_verified,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,

            ];

            return response()->json(['status' => true, 'message' => 'Login successfully', 'details' => $appResponse]);
            }

        } else {
            return response()->json(['status' => false, 'message' => 'Login credentials does not match!']);
        }
    }

    /**------------------------------------------------------------------------------------
     * verifyPhoneNo
     *
     * THIS METHOD IS FOR REGISTER VERIFY MOBILE NO
     * ____________________________________________________________________________________________
     */
    public function verifyPhoneNo(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',

            'otp' => 'required|numeric',
        ]);

        if ($validated->fails()) {
            return response()->json(['status' => false, 'message' => $validated->errors()->first()]);
        }
        $user = User::where('id', $request->user_id)->first();

        if (isset($user)) {
            if ($user->is_phone_no_verified=='0') {
                if ($user->otp == $request->otp) {

                    User::where('id', $request->user_id)->update(['is_phone_no_verified' => '1', 'phone_no_verified_at' => Carbon::now()]);
                    return response()->json(['status' => true, 'message' => 'Your phone number has verified successfully']);
                } else {
                    return \response()->json(['status' => false, 'message' => 'You enter wrong otp , please enter valid otp or resend again!']);
                }
            } else {
                return response()->json(['status' => true, 'message' => 'Your phone number has already verified successfully']);
            }
        } else {
            return \response()->json(['status' => false, 'message' => 'Your user_id is Invalid!']);
        }
    }
    /**------------------------------------------------------------------------------------
     * sendAgain
     *
     * THIS METHOD IS FOR SEND OTP AGAIN
     * ____________________________________________________________________________________________
     */
    public function sendAgain(Request $request) {
		$validated = Validator::make($request->all(), [
			'phone_no' => 'required|exists:users',

		]);
		if ($validated->fails()) {
			return response()->json(['status' => false, 'message' => 'Phone number is not registered yet!']);
		}

		$phone = User::where('phone_no', $request->phone_no)->first();
		if ($phone != null) {
			$OTP = random_int(100000, 999999);
			$message = $OTP . " is your bedabeda app OTP. Do not share it with anyone.";

			$this->sendOtp($message, $request->phone_no);
			User::where('phone_no', $request->phone_no)->update(['otp' => $OTP]);

			return response()->json(['status' => true, 'message' => 'OTP sent successfully']);
		}

	}

    /**------------------------------------------------------------------------------------
     * sendAgain
     *
     * THIS METHOD IS FOR GET USER PROFILE USING ID
     * ____________________________________________________________________________________________
     */


    public function getProfile(Request $request)
    {

        $validated = Validator::make($request->all(), [
            'id' => 'required|exists:users',

        ]);

         if ($validated->fails()) {
            return response()->json(['status' => false, 'message' => $validated->errors()->first()]);
        }


        $user = User::find($request->id);

       
        if($user)
        {
            return response()->json(['status' => true, 'message' => 'Fetch profile successfully','data'=>$user]);
        }else{

            return response()->json(['status' => false, 'message' => 'No user found']);

        }

    }


     /**------------------------------------------------------------------------------------
     * sendAgain
     *
     * THIS METHOD IS FOR UPDATE USER PROFILE USING ID
     * ____________________________________________________________________________________________
     */

    
     public function updateProfile(Request $request)
     {

        $validated = Validator::make($request->all(), [
            'id' => 'required|exists:users',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            
            'phone_number' => 'required|numeric',
            'country_code' => 'required|numeric',
            'address' => 'required',
            'lat' => 'required',
            'long' => 'required',

        ]);

         if ($validated->fails()) {
            return response()->json(['status' => false, 'message' => $validated->errors()->first()]);
        }

        

        $data = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'country_code' => $request->country_code,
                'address' => $request->address,
                'lat' => $request->lat,
                'long' => $request->long,
                

            ];
         
         User::where('id',$request->id)->update($data);
         

         $user = User::find($request->id);


         return response()->json(['status' => true, 'message' => 'Profile updated successfully','data'=>$user]);


    }




}
