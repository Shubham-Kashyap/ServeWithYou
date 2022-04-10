<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;
use Validator;
use Helper;
use Str;
use App\Models\User;
use App\Models\UserDetails;
use Auth;
use DB;
use Hash;
use Session;

class AdminController extends Controller
{
    //
    public function adminSignup(Request $request){
        $val = Validator::make($request->all(),[
            #rules for validaton
            'name'=>'required|regex:/^[\pL\s\-]+$/u',
            'email'=>'required|unique:admins',
            'phone_no'=>'required|unique:admins',
            'password'=>'required|min:6',
            'device_type'=>'required|in:i,a'
        ],[
            'name.regex'=>'The name may only contains letters'
        ]);
        if ($val->fails()){
            return response()->json([
                'status'=>'false',
                'message'=>$val->errors()->first(),
                'response'=>[]
            ]);
        }
        else{
            $id = DB::table('admins')->insertGetId([
                'name'=>$request->name,
                'username'=>Helper::generate_username($request->name),
                'email'=>$request->email,
                // 'country_code'=>$request->country_code,
                'email_verified_at'=>'1',
                'phone_no'=>$request->phone_no,
                'device_type'=>$request->device_type,
                'device_token'=>$request->device_token,
                'role'=>'admin',
                'remember_token'=>Str::random(36),
                'password'=>Hash::make($request->password),
                'lat'=>$request->latitude,
                'long'=>$request->longitude,
                'address'=>$request->address
            ]);
            if ($request->hasFile('image')) { // check if there is a file present in the postman request
                $name = 'admin_image_' .  date('d-m-y_H:i:s_a'). '.' . $request->image->extension();
                // $request->image->move(public_path() . '/images/userimages/', $name);
                // $complete_path = url('/') . '/images/userimages/' . $name;
                $path = 'images/admin_images/id-'.$id.'/'.$name; // s3 bucket path
                Storage::disk('s3')->put($path,file_get_contents($request->image)); // store the renamed file to the s3 bucket
                $user_detail = DB::table('admins')->where('id', $id)->update(['image' => $name]);
            }
            $retData = DB::table('admins')->where('id',$id)->first();
            return response()->json(['status'=>true,'message'=>'Admin signup successfull','response'=>$retData]);
        }
    }
    public function dashboard(){
        // dd('hello');
        Session::put('page','dashboard');
        $userCount = User::all()->count() -1;
        return view('admin.sections.dashboard')->with(compact('userCount'));
    }
    public function adminLogin(Request $request){
        // dd('hello');
        if($request->isMethod('post')){
            // dd($request->all());
            $val = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if ($val->fails()) {
                Session::flash('error_message', $val->errors()->first());
                return redirect()->back()->withInput();
            }
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'email_verified_at' => '1', 'role' => 'admin'])) {
                // return view('admin.index');
                return redirect('/admin/dashboard');
            } else {
                Session::flash('error_message', 'Incorrect username or password');
                return redirect()->back()->withInput();
            }
        }
        return view('admin.login');
    }
    public function adminLogout(){
        Session::put('page','logout');
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
    //load profile settings page
    public function profileSettings(){
        Session::put('page','profile');
        Session::put('tab','profile');
        $data = DB::table('admins')
                    ->where('id', Auth::guard('admin')->user()->id)
                    ->first();
        return view('admin.sections.profile')->with(compact('data'));
    }
    // to update the profile of the admin
    public function updateProfile(Request $request){
        Session::put('page', 'profile');
        Session::put('tab', 'profileSettings');
        // dd($request->image);
        if ($request->isMethod('post')) {
            $val = Validator::make($request->all(), [
                // 'email'=>'required',
                'name' => 'required',
                'phone_no' => 'required|numeric',
                'image' => 'image|mimes:jpeg,png,jpg' // 1024 -> 1MB
            ],[
                'image.image' => 'The profile picture must be an image'
            ]);
            // dd($request->all());
            if ($val->fails()) {
                Session::flash('profile_error_message', $val->errors()->first());
                return redirect()->back();
            }
            else {
                $user = DB::table('admins')->where('email', Auth::guard('admin')->user()->email);
                $user->update(['name' => $request->name,'phone_no'=>$request->phone_no]);
                
                if ($request->hasFile('image')) { // check if there is a file present in the postman request

                    $name = 'admin_image_' . date('Y-m-d H:i:s_a') . '.' . $request->image->extension();
                    $path = 'images/admin_images/'.$name;
                    $request->image->move(public_path() . '/images/admin_images/', $name);// upload the file to the public folder
                    $complete_path = url('/') . '/images/admin_images/' . $name;

                    // Storage::disk('s3')->put($path,file_get_contents($request->file('image'))); // upload the file to the bucket 
                    DB::table('admins')->where('id', $user->first()->id)->update(['image' => $name]);
                }
                Session::flash('profile_success_message', 'The Admin profile is updated successfully');
                return redirect()->back();
            }
        } else {
            return redirect('/admin/profile-settings');
        }
    }
    // to update the password of the admin
    public function changePassword(Request $request)
    {
        Session::put('page', 'profile');
        Session::put('tab', 'profileSettings');
        // dd($request->all());
        if ($request->isMethod('post')) {
            $id = Auth::guard('admin')->user()->id;
            $user = DB::table('admins')->find($id);
            $val = Validator::make($request->all(), [
                // 'admin_email'=>'required',
                'current_password' => 'required|min:3',
                'new_password' => 'required|min:3',
                'confirm_new_password' => 'required|same:new_password|different:current_password',
            ]);
            
            if ($val->fails()) {
                Session::flash('pwd_error_message', $val->errors()->first());
                return redirect()->back();
            }
            if(!Hash::check($request->current_password, $user->password)){
                Session::flash('pwd_error_message', 'Your current password is incorrect ! please enter the correct current password');
                return \redirect()->back();
            }
            else {
                
                if (Hash::check($request->current_password, $user->password)) {
                    DB::table('admins')->where('id', $id)->update([
                        'password' => Hash::make($request->new_password
                    )]);
                    // Session::flash('error_message', 'Please login with the new password ! Your password is changed recently ');
                    return redirect('admin/logout');
                } 
                // else {
                //     Session::flash('error_message', 'Wrong old password ! please enter the correct old password');
                //     return redirect()->back();
                // }
            }
        } else {
            return redirect('/admin/profile-settings');
        }
    }
    /**
     * ------------------------------------------
     * All Users
     * ------------------------------------------
     */
    public function allUsers(){
        Session::put('page','allagents');
        $users = DB::table('users')
                        ->join('user_details', 'users.id', '=', 'user_details.user_id')
                        ->where('users.role','user')
                        ->where('users.is_blocked','0')
                        ->select('users.*','user_details.address','user_details.image')
                        ->get();
        // dd($agents);
        return view('admin.sections.allusers')->with(compact('users'));
    }
    /**
     * ------------------------------------------
     * Blocked Users
     * ------------------------------------------
     */
    public function blockedUsers(){
        Session::put('page','deniedagents');
        $users = DB::table('users')
                        ->join('user_details', 'users.id', '=', 'user_details.user_id')
                        ->where('users.role','user')
                        ->where('users.is_blocked','1')
                        ->get();
        // dd($agents);
        return view('admin.sections.blockedusers')->with(compact('users'));
    }
    /**
     * -----------------------------------------
     * Change admin pannel language
     * -----------------------------------------
     */
    public function changeLang(Request $request,$lang){
        // dd('hello sunil ');
        // dd($request->lang);
        // dd(Session::get('app_locale'));
        Session::put('page','app_locale');
        App::setLocale($request->lang);
        return redirect()->back();
    }
    /**
     * ------------------------------------------
     * All categories
     * ------------------------------------------
     */
    public function allCategories(){
        $data = DB::table('categories')->get();
        // dd($data);
        return view('admin.sections.allcategories')->with(compact('data'));
    }
    /**
     * ------------------------------------------
     * Add categories
     * ------------------------------------------
     */
    public function addCategory(Request $request){
        if($request->isMethod('POST')){
            $val = Validator::make($request->all(),[
                'category_name_en'=>'required|regex:/^[\pL\s\-]+$/u|unique:categories,category_name',
                'category_name_ar'=>'required|regex:/^[\pL\s\-]+$/u',
                'category_description'=>'required',
                'weight' => 'numeric'
            ],[
                'category_name_en.regex'=>'The category name may only contain letters'
            ]);
            if($val->fails()) {
                Session::flash('error_message',$val->errors()->first());
                return redirect()->back()->withInput();
            }
            else{
                $id = DB::table('categories')->insertGetId([
                    'category_name'=> $request->category_name_en,
                    'category_name_en'=> $request->category_name_en,
                    'category_name_ar'=> $request->category_name_ar,
                    'weight' => $request->weight,
                    'category_active_status' => 'pending',
                    'category_description' => $request->category_description
                ]);
                if($request->has('category_logo')){
                    $name = 'category_logo_' . date('D-m-y_H:i:s_a') . '.' . $request->category_logo->extension();
                    // $request->category_image->move(public_path() . '/images/category_images/id-'.$id, $name);
                    // $complete_path = url('/') . '/images/category_images/' . $name;
                    $path = 'images/'.$name; // s3 bucket path
                    Storage::disk('s3')->put($path,file_get_contents($request->category_logo)); // store the renamed file to the s3 bucket
                    DB::table('categories')->where('id',$id)->update(['category_logo'=>$name]);
                }
                if($request->has('category_image')){
                    $name = 'category_image_' . date('D-m-y_H:i:s_a') . '.' . $request->category_image->extension();
                    // $request->category_image->move(public_path() . '/images/category_images/id-'.$id, $name);
                    // $complete_path = url('/') . '/images/category_images/' . $name;
                    $path = 'images/'.$name; // s3 bucket path
                    Storage::disk('s3')->put($path,file_get_contents($request->category_image)); // store the renamed file to the s3 bucket
                    DB::table('categories')->where('id',$id)->update(['category_image'=>$name]);
                }
               
                Session::flash('success_message','The category is added successfully.');
                return redirect('admin/categories/all-categories');
            }
        }
        else{
            return view('admin.sections.addcategory');
        }
    }
    /**
     * ------------------------------------------
     * Edit category
     * ------------------------------------------
     */
    public function editCategory(Request $request,$id){
        $data = DB::table('categories')->where('id',$id)->first();
        if($request->isMethod('POST')){
            $val = Validator::make($request->all(),[
                'category_name'=>'required|regex:/^[\pL\s\-]+$/u',
                'category_description'=>'required',
                'weight' => 'numeric'
            ],[
                'category_name.regex'=>'The category name may only contain letters'
            ]);
            if($val->fails()) {
                Session::flash('error_message',$val->errors()->first());
                return redirect()->back()->withInput();
            }
            else{
                DB::table('categories')->where('id',$id)->update([
                    // 'category_name'=> $request->category_name,
                    'category_description' => $request->category_description,
                    'weight' => $request->weight,
                ]);
                if($request->has('category_image')){
                    $name = 'category_image_' . date('D-m-y_H:i:s_a') . '.' . $request->category_image->extension();
                    // $request->category_image->move(public_path() . '/images/category_images/id-'.$id, $name);
                    // $complete_path = url('/') . '/images/category_images/' . $name;
                    $path = 'images/'.$name; // s3 bucket path
                    Storage::disk('s3')->put($path,file_get_contents($request->category_image)); // store the renamed file to the s3 bucket
                    DB::table('categories')->where('id',$id)->update(['category_image'=>$name]);
                }
               
                Session::flash('success_message','The category is edited successfully.');
                // return redirect()->back();
                return redirect('admin/categories/all-categories');
            }
        }
        else{
            // dd($data);
            return view('admin.sections.editcategory')->with(compact('data'));
        }
    }
    /**
     * ------------------------------------------------------
     * Delete category
     * ------------------------------------------------------
     */
    public function deleteCategory($id){
        DB::table('categories')->where('id',$id)->delete();
        Session::flash('success_message','The Category is removed successfully');
        return redirect()->back();
    }
    /**
     * ------------------------------------------------------
     * view subcategories
     * ------------------------------------------------------
     * view selected shop --> selected category --> subcategories list
     */
    public function viewSubcategories($shop_id,$uni_category_id){
        // $subcategories = DB::table('sub_categories')->where('category_id',$category_id)->get();
        $category_id = $uni_category_id; // category id will be universal_category_id
        $subcategories = DB::table('shop_subcategories')
                ->join('categories','categories.id','=','shop_subcategories.shop_category_id')
                ->select('shop_subcategories.*','shop_subcategories.shop_subcategory_logo as subcategory_logo','shop_subcategories.shop_subcategory_image as subcategory_image','categories.category_name','categories.category_image','categories.category_description')
                ->where('shop_subcategories.shop_id','=',$shop_id)
                ->where('shop_subcategories.shop_category_id','=',$uni_category_id)
                ->get();
        // dd($subcategories);
        return view('admin.sections.viewsubcategories')->with(compact('subcategories','category_id'));
    }
    /**
     * ------------------------------------------------------
     * All subcategories
     * ------------------------------------------------------
     * view all selected shop --> subcategories list
     */
    public static function allSubcategories($shop_id){
        $subcategories =  DB::table('shop_subcategories')
                ->join('categories','categories.id','=','shop_subcategories.shop_category_id')
                ->select('shop_subcategories.*','shop_subcategories.shop_subcategory_logo as subcategory_logo','shop_subcategories.shop_subcategory_image as subcategory_image','categories.category_name','categories.category_image','categories.category_description')
                ->where('shop_subcategories.shop_id','=',$shop_id)
                ->get();
                // DD($subcategories);
        return view('admin.sections.allsubcategories')->with(compact('subcategories'));
    }
    /**
     * ------------------------------------------------------
     * Add subcategory
     * ------------------------------------------------------
     */
    public function addSubcategory(Request $request,$category_id =''){
        
        $categories = DB::table('categories')->get();
        switch($request->method()){
            
            case "GET": // when request method is GET
                if(!empty($category_id)){ // check if the variable is initialized in url or not
                    $categories = DB::table('categories')->where('id',$category_id)->get();
                }
                return view('admin.sections.addsubcategory')->with(compact('categories'));
                break;
                
            case "POST": // when request method is POST
                $val = Validator::make($request->all(), [
                    'category_id' => 'required|exists:categories,id',
                    'subcategory_name' => 'required',
                    'subcategory_description' => 'required'
                ],[
                    'category_id.required' => "Select category filed is required"
                ]);
                if($val->fails()){
                    Session::flash('error_message',$val->errors()->first());
                    return redirect()->back()->withInput();
                }
                else{
                    $id = DB::table('sub_categories')->insertGetId([
                        'category_id' => $request->category_id,
                        'subcategory_name'=> $request->subcategory_name,
                        'subcategory_description' => $request->subcategory_description
                    ]);
                    if($request->has('subcategory_image')){
                        $name = 'subcategory_image_' . date('D-m-y_H:i:s_a') . '.' . $request->subcategory_image->extension();
                        // $request->subcategory_image->move(public_path() . '/images/subcategory_images/id-'.$id, $name);
                        // $complete_path = url('/') . '/images/subcategory_images/' . $name;
                        $path = 'images/'.$name; // s3 bucket path
                        Storage::disk('s3')->put($path,file_get_contents($request->subcategory_image)); // store the renamed file to the s3 bucket
                        DB::table('sub_categories')->where('id',$id)->update(['subcategory_image'=>$name]);
                    }
                    Session::flash('success_message',"Subcategory is added successfully");
                    return redirect('admin/categories/view-subcategories/'.$request->category_id);
                }
                break;
            default :
                return redirect()->back();
        }
    }
     /**
     * ------------------------------------------------------
     * Edit subcategory
     * ------------------------------------------------------
     */
    public function editSubcategory(Request $request,$id){
        $data = DB::table('sub_categories')->where('id',$id)->first();
        switch($request->method()){
            
            case "GET": // when request method is GET
                return view('admin.sections.editsubcategory')->with(compact('data'));
                break;
                
            case "POST": // when request method is POST
                $val = Validator::make($request->all(), [
                    // 'category_id' => 'required|exists:categories,id',
                    'subcategory_name' => 'required',
                    'subcategory_description' => 'required'
                ],[
                    'category_id.required' => "Select category filed is required"
                ]);
                if($val->fails()){
                    Session::flash('error_message',$val->errors()->first());
                }
                else{
                    $id = DB::table('sub_categories')->where('id',$id)->update([
                        // 'category_id' => $request->category_id,
                        'subcategory_name'=> $request->subcategory_name,
                        'subcategory_description' => $request->subcategory_description
                    ]);
                    if($request->has('subcategory_image')){
                        $name = 'subcategory_image_' . date('D-m-y_H:i:s_a') . '.' . $request->subcategory_image->extension();
                        // $request->subcategory_image->move(public_path() . '/images/subcategory_images/id-'.$id, $name);
                        // $complete_path = url('/') . '/images/subcategory_images/' . $name;
                        $path = 'images/'.$name; // s3 bucket path
                        Storage::disk('s3')->put($path,file_get_contents($request->subcategory_image)); // store the renamed file to the s3 bucket
                        DB::table('sub_categories')->where('id',$id)->update(['subcategory_image'=>$name]);
                    }
                    Session::flash('success_message',"Subcategory is edited successfully");
                    return redirect('admin/categories/all-categories');
                }
                break;
            default :
                return redirect()->back();
        }
    }
     /**
     * ------------------------------------------------------
     * Delete subcategory
     * ------------------------------------------------------
     */
    public function deleteSubcategory($id){
        DB::table('sub_categories')->where('id',$id)->delete();
        Session::flash('success_message','The subcategory is deleted successfully.');
        return redirect()->back();
    }
    /**
     * ------------------------------------------------------
     * Set category active 
     * ------------------------------------------------------
     */
    public function setCategoryActive($id){
        DB::table('categories')->where('id',$id)->update([
            'category_active_status' => 'active'
        ]);
        Session::flash('success_message','The category is successfully set to active');
        return redirect()->back();
    }
    /**
     * ------------------------------------------------------
     * Set category inactive 
     * ------------------------------------------------------
     */
    public function setCategoryInactive($id){
        DB::table('categories')->where('id',$id)->update([
            'category_active_status' => 'inactive'
        ]);
        Session::flash('error_message','The category is successfully set to inactive');
        return redirect()->back();
    }
    /**
     * ------------------------------------------------------
     * view configurations
     * ------------------------------------------------------
     */
    public function viewConfigurations($shop_id){

        $configurations = DB::table('configurations')->where('shop_id',$shop_id)->get();
        return view('admin.sections.viewconfigurations')->with(compact('configurations'));
    }
}
