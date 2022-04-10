<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Notification;
use App\Notifications\SignupEmailVerification;
use App\Notifications\ForgotPasswordNotification;
use App\Notifications\ChangeEmailNotification;
use App\User;
use App\Consumer;
use Hash;
use App\UserDetails;
use App\ServiceCategory;
use Validator;
use Auth;
use DB;
use Session;

class ConsumerController extends Controller
{
    //
    public function addConsumer(Request $request){
        Session::put('page','addconsumer');
        if($request->isMethod('post')){
            $val = Validator::make($request->all(),[
                # rules for validation 
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'phone_no' => 'required|numeric|unique:users',
                'email' => 'required|email|unique:users',
                'password'=> 'required|min:6',
                'confirm_password' => 'required|same:password|min:6',
                'address'=>'required'
            ]);
            if($val->fails()){
                Session::flash('error_message',$val->errors()->first());
                return redirect()->back()->withInput();
            }
            else{
                $user_id = User::insertGetId([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone_no' =>$request->phone_no,
                    'role' =>'consumer',
                    'email' => $request->email,         
                    'password'  => bcrypt($request->password),
                    'address' =>$request->address,
                    'email_verified_at'=>'1',
                    'lat'=>$request->lat,
                    'long'=>$request->long,
                ]);
                UserDetails::insert([
                    'user_id'=>$user_id,
                    'user_role'=>'consumer'
                ]);
                Consumer::insert([
                    'user_id'=>$user_id,
                    'user_role'=>'consumer'
                ]);
                ServiceCategory::insert([
                    'user_id'=>$user_id,
                    'user_role'=>'consumer',
                    'current_location'=>$request->address
                ]);
                if($request->hasFile('image')){
                    $name = 'user_image_' . mt_rand(10, 1000) . '.' . $request->image->extension();
                    $request->image->move(public_path() . '/images/user_images/consumer/id-'.$user_id, $name);
                    // $complete_path = url('/') . '/images/user_images/consumer/id-'.$request->user_id.'/'.UserDetails::where('user_id',$request->user_id)->first()->image;
                    UserDetails::where('user_id', $user_id)->update(['image' => $name]);
                }
                $verificationLink = url('/').'/user/email-verification/'.Crypt::encryptString($user_id);
                Notification::send(User::find($user_id),new SignupEmailVerification($request->email,$verificationLink));
            }
            Session::flash('success_message','The consumer is added successfully to the list');
            return redirect()->back();
            // return redirect('admin/consumers/all-consumers');
            
        }
        else{
            return view('admin.sections.addconsumers');
        }
    }
    public function editConsumer(Request $request,$id){
        Session::put('page','allconsumers');
        $data = DB::table('users')
                        ->join('user_details', 'user_details.user_id', '=', 'users.id')
                        ->join('consumers','consumers.user_id','=','user_details.user_id')
                        ->where('consumers.user_id',$id)
                        ->select('users.first_name','users.last_name','users.email','users.phone_no','users.role','users.is_blocked','users.address','users.state','users.country','users.account_number','consumers.*','user_details.image')
                        ->first();
        if($request->isMethod('post')){
            // dd($id);
            $val = Validator::make($request->all(),[
                # rules for validation 
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'phone_number' => 'required|numeric|',
                // 'email' => 'required|email',
               
            ]);
            if($val->fails()){
                Session::flash('error_message',$val->errors()->first());
                return redirect()->back()->withInput();
            }
            else{
                User::where('id',$id)->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone_no' =>$request->phone_number,
                    'address' =>$request->address,    
                ]);
                if($request->hasFile('image')){
                    $name = 'user_image_' . mt_rand(10, 1000) . '.' . $request->image->extension();
                    $request->image->move(public_path() . '/images/user_images/consumer/id-'.$id, $name);
                    // $complete_path = url('/') . '/images/user_images/provider/id-'.$request->user_id.'/'.UserDetails::where('user_id',$request->user_id)->first()->image;
                    UserDetails::where('user_id', $id)->update(['image' => $name]);
                }
            }
            Session::flash('success_message','The consumer details is edited successfully');
            return redirect('admin/consumers/all-consumers');
        }
        
        else{
            return view('admin.sections.editconsumer')->with(compact('data'));
        }
    }
    public function allConsumers(Request $request){
        session::put('page', 'allconsumers');
        $consumers = DB::table('users')
                        ->join('user_details', 'user_details.user_id', '=', 'users.id')
                        ->join('consumers','consumers.user_id','=','user_details.user_id')
                        ->where('user_details.user_role','consumer')
                        ->select('users.first_name','users.last_name','users.email','users.phone_no','users.role','users.is_blocked','users.address','consumers.*','user_details.image')
                        ->orderby('user_details.user_id','desc')
                        ->get();
        // dd($consumers);
        return view('admin.sections.allconsumers')->with(compact('consumers'));
    }
    
    // view consumer profile 
    public function viewConsumerProfile($id){
        Session::put('page','allconsumers');
        if($id === null){
            return redirect('admin/consumers/all-consumers');
        }
        $data = DB::table('users')->join('user_details','users.id','=','user_details.user_id')
                            ->where('users.id',$id)
                            ->select('users.id','users.first_name','users.last_name','users.role','users.created_at','users.email','users.address','users.phone_no','user_details.user_id','user_details.image')
                            ->first();
        $userImage = url('/') . '/images/userimages/';
        return view('admin.sections.viewconsumer')->with(compact('data','userImage'));
    }
}
