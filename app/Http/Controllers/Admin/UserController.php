<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;
use Validator;
use App\User;
use App\UserDetails;
use App\BlockedUsers;

class UserController extends Controller
{
    //
    /**
     * ----------------------------------------------------------
     * ALL REGISTERED USERS
     * ----------------------------------------------------------
     */
    public function allUsersData()
    {
        // $users = User::all();
        session::put('page', 'allusers');
        $users = DB::table('users')->join('user_details', 'user_details.user_id', '=', 'users.id')->get();
        return view('admin.sections.allusers')->with(compact('users'));
    }
    /**
     * ----------------------------------------------------------
     * BLOCK A USER
     * ----------------------------------------------------------
     */
    public function BlockUser($id){
        if($id === null){
            return redirect('admin/users/all-users');
        }
        $userData = User::where('id',$id)->update(['is_blocked'=>'1']);
        $userInfo = DB::table('users')->join('user_details','users.id','=','user_details.user_id')->where('users.id',$id)->first();
        // dd($userInfo);
        DB::table('blocked_users')->updateOrInsert([
            'id'=>$id,
            // 'user_id'=>$userInfo->user_id,
            'first_name'=>$userInfo->first_name,
            'last_name'=>$userInfo->last_name,
            'email'=>$userInfo->email,
            'phone_no'=>$userInfo->phone_no,
            'role'=>$userInfo->role,
            'is_blocked'=>$userInfo->is_blocked,
            'email_verified_at'=>$userInfo->email_verified_at,
            'address'=>$userInfo->address,
            'state'=>$userInfo->state,
            'country'=>$userInfo->country,
            'lat'=>$userInfo->lat,
            'long'=>$userInfo->long,
            'account_number'=>$userInfo->account_number,
            'image'=>$userInfo->image
        ]);
        Session::flash('success_message','User is blocked successfully');
        return redirect()->back();    
    }
    /**
     * ----------------------------------------------------------
     * ALL BLOCKED USERS
     * ----------------------------------------------------------
     */
    public function blockedUsersData(){
        Session::put('page','blockedusers');
        $users = BlockedUsers::all();
        return view('admin.sections.blockedusers')->with(compact('users'));
    }
    /**
     * ----------------------------------------------------------
     * UNBLOCK A USER
     * ----------------------------------------------------------
     */
    public function UnblockUser($id){
        if($id === null){
            return redirect('admin/users/all-users');
        }
        User::where('id',$id)->update(['is_blocked'=>'0']);
        BlockedUsers::where('id',$id)->delete();
        Session::flash('success_message','User is unblocked successfully');
        return redirect()->back();
    }
    
    /**
     * ----------------------------------------------------------
     * VIEW USER PROFILE
     * ----------------------------------------------------------
     */
    public function viewUserProfile($id){
        Session::put('page','viewuser');
        if($id === null){
            return redirect('admin/users/all-users');
        }
        $data = DB::table('users')->join('user_details','users.id','=','user_details.user_id')->where('users.id',$id)->first();
        $userImage = url('/') . '/images/userimages/';
        return view('admin.sections.viewuser')->with(compact('data','userImage'));
    }
    
}
