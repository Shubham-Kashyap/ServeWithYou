<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Session;
use DB;
use Notification;
use App\Notifications\SignupEmailVerification;
use App\Notifications\ForgotPasswordNotification;
use App\Notifications\ChangeEmailNotification;
use Validator;
use App\Consumer;
use App\ServiceCategory;
use App\Jobs;
use App\User;
use App\UserDetails;
use App\BlockedUsers;
use App\Provider;
use Helper;
use Carbon\Carbon;

class ProviderController extends Controller
{
    //
    public function addProvider(Request $request)
    {
        Session::put('page', 'addprovider');
        if ($request->isMethod('post')) {
            // dd($request->all());
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
            if ($val->fails()) {
                Session::flash('error_message', $val->errors()->first());
                return redirect()->back()->withInput();
            } else {
                $full_name = $request->first_name . ' ' . $request->last_name;
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
                        'email_verified_at' => '1',
                        'company_id' => $request->company,
                        'employee_id' => Helper::generateEmployeeID($full_name),
                        // 'account_number'=>$request->account_number
                    ]);
                    UserDetails::insert([
                        'user_id' => $user_id,
                        'user_role' => 'provider'
                    ]);
                    Provider::insert([
                        'user_id' => $user_id,
                        'company_name' => $request->company_name,
                        'service' => $request->service,
                        'rate' => $request->rate,
                        'working_start' => Carbon::now(),
                        'working_end' => Carbon::now()->endOfDay(),
                        'work_start_time' => Carbon::now()->startOfDay(),
                        'work_end_time' => Carbon::now()->endOfDay(),
                    ]);
                    if ($request->hasFile('image')) {
                        $name = 'user_image_' . mt_rand(10, 1000) . '.' . $request->image->extension();
                        $request->image->move(public_path() . '/images/user_images/provider/id-' . $user_id, $name);
                        // $complete_path = url('/') . '/images/user_images/provider/id-'.$request->user_id.'/'.UserDetails::where('user_id',$request->user_id)->first()->image;
                        UserDetails::where('user_id', $user_id)->update(['image' => $name]);
                    }
                    if ($request->has('company') && $request->company != null) {
                        $company_details = DB::table('companies')->where('company_id', $request->company)->first();
                        DB::table('providers')->where('user_id', $user_id)
                            ->update(['company_name' => $company_details->company_name]);
                    }
                    $verificationLink = url('/') . '/user/email-verification/' . Crypt::encryptString($user_id);
                    Notification::send(User::find($user_id), new SignupEmailVerification($request->email, $verificationLink));
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
                }
                $user_id = User::insertGetId([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone_no' => $request->phone_no,
                    'role' => 'provider',
                    'email' => $request->email,
                    'password'  => bcrypt($request->password),
                    'address' => $request->address,
                    'state' => $request->state,
                    'country' => $request->country,
                    'lat' => $request->lat,
                    'long' => $request->long,
                    'email_verified_at' => '1',
                    'company_id' => $request->company,
                    'employee_id' => Helper::generateEmployeeID($full_name),
                    // 'account_number'=>$request->account_number
                ]);
                UserDetails::insert([
                    'user_id' => $user_id,
                    'user_role' => 'provider'
                ]);
                Provider::insert([
                    'user_id' => $user_id,
                    'service' => $request->service,
                    'rate' => $request->rate,
                    'working_start' => Carbon::now(),
                    'working_end' => Carbon::now()->endOfDay(),
                    'work_start_time' => Carbon::now()->startOfDay(),
                    'work_end_time' => Carbon::now()->endOfDay(),
                ]);
                if ($request->hasFile('image')) {
                    $name = 'user_image_' . mt_rand(10, 1000) . '.' . $request->image->extension();
                    $request->image->move(public_path() . '/images/user_images/provider/id-' . $user_id, $name);
                    // $complete_path = url('/') . '/images/user_images/provider/id-'.$request->user_id.'/'.UserDetails::where('user_id',$request->user_id)->first()->image;
                    UserDetails::where('user_id', $user_id)->update(['image' => $name]);
                }
                $verificationLink = url('/') . '/user/email-verification/' . Crypt::encryptString($user_id);
                Notification::send(User::find($user_id), new SignupEmailVerification($request->email, $verificationLink));
            }
            if ($request->has('company') && $request->company != null) {
                $company_details = DB::table('companies')->where('company_id', $request->company)->first();
                DB::table('providers')->where('user_id', $user_id)
                    ->update(['company_name' => $company_details->company_name]);
            }
            Session::flash('success_message', 'The Provider is added successfully to the list');
            return redirect('admin/providers/all-providers');
        } else {
            return view('admin.sections.addproviders');
        }
    }
    /**
     * ---------------------------------------------------------
     * fetch all registered providers
     * ---------------------------------------------------------
     */
    public function allProvidersData()
    {
        // $users = User::all();
        session::put('page', 'allproviders');
        $providers = DB::table('users')
            ->join('user_details', 'user_details.user_id', '=', 'users.id')
            ->join('providers', 'providers.user_id', '=', 'user_details.user_id')
            ->where('user_details.user_role', 'provider')
            ->whereNull('users.company_id')
            ->select('users.first_name', 'users.last_name', 'users.email', 'users.phone_no', 'users.role', 'users.is_blocked', 'users.company_id', 'users.employee_id', 'providers.*', 'user_details.onboarding_status', 'user_details.image')
            ->get();
        return view('admin.sections.allproviders')->with(compact('providers'));
    }
    /**
     * ---------------------------------------------------------
     * VIEW PROVIDERS PROFILE
     * ---------------------------------------------------------
     */
    public function viewProviderProfile($id)
    {
        Session::put('page', 'allproviders');
        $data = DB::table('users')
            ->join('user_details', 'user_details.user_id', '=', 'users.id')
            ->join('providers', 'providers.user_id', '=', 'user_details.user_id')
            ->where('providers.user_id', $id)
            ->select('users.first_name', 'users.last_name', 'users.email', 'users.phone_no', 'users.role', 'users.is_blocked', 'users.address', 'providers.*', 'user_details.image')
            ->first();
        // dd($data);
        return view('admin.sections.viewprovider')->with(compact('data'));
    }
    // edit provider
    public function editProvider(Request $request, $id)
    {
        Session::put('page', 'allproviders');
        $data = DB::table('users')
            ->join('user_details', 'user_details.user_id', '=', 'users.id')
            ->join('providers', 'providers.user_id', '=', 'user_details.user_id')
            ->where('providers.user_id', $id)
            ->select('users.first_name', 'users.last_name', 'users.email', 'users.phone_no', 'users.role', 'users.is_blocked', 'users.address', 'users.state', 'users.country', 'users.account_number', 'providers.*', 'user_details.image')
            ->first();
        if ($request->isMethod('post')) {
            // dd($id);
            $val = Validator::make($request->all(), [
                # rules for validation
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                // 'phone_number' => 'required|numeric|digits:10',
                // 'email' => 'required|email',
                'state' => 'required',
                'country' => 'required',
                // 'account_number'=>'required'
            ]);
            if ($val->fails()) {
                Session::flash('error_message', $val->errors()->first());
                return redirect()->back()->withInput();
            } else {
                $full_name = $request->first_name . ' ' . $request->last_name;
                User::where('id', $id)->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    // 'phone_no' =>$request->phone_number,
                    'role' => 'provider',
                    // 'email' => $request->email,

                    'address' => $request->address,
                    'state' => $request->state,
                    'country' => $request->country,
                    'company_id' => $request->company,
                    'employee_id' => Helper::generateEmployeeID($full_name),
                    // 'account_number'=>$request->account_number
                ]);
                if ($request->hasFile('image')) {
                    $name = 'user_image_' . mt_rand(10, 1000) . '.' . $request->image->extension();
                    $request->image->move(public_path() . '/images/user_images/provider/id-' . $id, $name);
                    // $complete_path = url('/') . '/images/user_images/provider/id-'.$request->user_id.'/'.UserDetails::where('user_id',$request->user_id)->first()->image;
                    UserDetails::where('user_id', $id)->update(['image' => $name]);
                }
                if ($request->has('company') && $request->company != null) {
                    $company_details = DB::table('companies')->where('company_id', $request->company)->first();
                    DB::table('providers')->where('user_id', $id)
                        ->update(['company_name' => $company_details->company_name]);
                }
            }
            Session::flash('success_message', 'The provider details is edited successfully');
            return redirect('admin/providers/all-providers');
        } else {
            return view('admin.sections.editprovider')->with(compact('data'));
        }
    }
    /**
     * --------------------------------------------------------------
     * All Companies
     * --------------------------------------------------------------
     */
    public function allCompanies()
    {
        Session::put('page', 'allCompanies');
        $companies = DB::table('companies')->get();
        return view('admin.sections.allcompanies')->with(compact('companies'));
    }
    /**
     * --------------------------------------------------------------
     * Add Companies
     * --------------------------------------------------------------
     */
    public function addCompany(Request $request)
    {
        Session::put('page', 'allcompanies');
        if ($request->isMethod('post')) {
            // dd($request->all());
            $val = Validator::make($request->all(), [
                'company_name' => 'required',
            ]);
            if ($val->fails()) {
                Session::flash('error_message', $val->errors()->first());
                return redirect()->back()->withInput();
            } else {
                DB::table('companies')->insert([
                    'company_name' => $request->company_name,
                    'company_id' => Helper::generateCompanyID($request->company_name),
                    'company_description' => $request->company_description
                ]);
                Session::flash('success_message', 'The company is added successfully');
                return redirect('admin/companies/all-companies');
            }
        } else {
            return view('admin.sections.addcompany');
        }
    }
    /**
     * ----------------------------------------------------------------
     * Edit company
     * ----------------------------------------------------------------
     */
    public function editCompany(Request $request, $id)
    {
        $data = DB::table('companies')->where('id', $id)->first();
        if ($request->isMethod('POST')) {
            $val = Validator::make($request->all(), [
                'company_name' => 'required',
                'company_description' => 'required'
            ]);
            if ($val->fails()) {
                Session::flash('error_message', $val->errors()->first());
                return redirect()->back();
            } else {
                DB::table('companies')->where('id', $id)->update([
                    'company_name' => $request->company_name,
                    'company_description' => $request->company_description
                ]);
                Session::flash('success_message', 'The company is edited successfully');
                return redirect('admin/companies/all-companies');
            }
        } else {
            return view('admin.sections.editcompany')->with(compact('data'));
        }
    }
    /**
     * ----------------------------------------------------------------
     * Delete company
     * ----------------------------------------------------------------z
     */
    public function deleteCompany($id)
    {
        $company = DB::table('companies')->where('id', $id)->first();

        DB::table('users')->where('company_id', $company->company_id)->update([
            'company_id' => '',
            'employee_id' => ''
        ]);
        DB::table('companies')->where('id', $id)->delete();
        Session::flash('success_message', 'The company is deleted successfully');
        return redirect('admin/companies/all-companies');
    }
    /**
     * ----------------------------------------------------------------
     * View company
     * ----------------------------------------------------------------
     */
    public function viewCompany($id)
    {
        $data = DB::table('companies')->where('id', $id)->first();
        return view('admin.sections.viewcompany')->with(compact('data'));
    }
    /**
     * ----------------------------------------------------------------
     * View company employes
     * ----------------------------------------------------------------
     */
    public function viewCompanyEmployes($id = null)
    {
        if ($id == null) {
            // for all associated providers
            Session::put('page', 'associatedemployes');
            $providers = DB::table('users')
                ->join('user_details', 'user_details.user_id', '=', 'users.id')
                ->join('providers', 'providers.user_id', '=', 'user_details.user_id')
                ->where('user_details.user_role', 'provider')
                ->whereNotNull('users.company_id')
                ->select('users.first_name', 'users.last_name', 'users.email', 'users.phone_no', 'users.role', 'users.company_id', 'users.employee_id', 'users.is_blocked', 'providers.*', 'user_details.onboarding_status', 'user_details.image')
                ->get();
            $company_id = null;
            // dd('hello');
        } else {
            // for company associated providers
            $data = DB::table('companies')->where('id', $id)->first();
            $providers = DB::table('users')
                ->join('user_details', 'user_details.user_id', '=', 'users.id')
                ->join('providers', 'providers.user_id', '=', 'user_details.user_id')
                ->where('user_details.user_role', 'provider')
                ->where('users.company_id', $data->company_id)
                ->select('users.first_name', 'users.last_name', 'users.email', 'users.phone_no', 'users.role', 'users.company_id', 'users.employee_id', 'users.is_blocked', 'providers.*', 'user_details.onboarding_status', 'user_details.image')
                ->get();
            $company_id = $id;
        }

        return view('admin.sections.viewcompanyemployes')->with(compact('providers', 'company_id'));
    }
    /**
     * ----------------------------------------------------------------
     * Add associated providers
     * ----------------------------------------------------------------
     */
    public function addAssociatedProviders(Request $request, $company_id = null)
    {
        // dd('hello');
        if ($request->isMethod('post')) {
            // dd('hello');
            $full_name = $request->first_name . ' ' . $request->last_name;
            $val = Validator::make($request->all(), [
                'first_name' => 'required|string|regex:/^[\pL\s\-]+$/u',
                'last_name' => 'required|string|regex:/^[\pL\s\-]+$/u',
                'service' => 'required',
            ], [
                'first_name.regex' => 'The first name may only contains letters',
                'last_name.regex' => 'The last name may only contains letters'
            ]);
            if ($val->fails()) {
                Session::flash('error_message', $val->errors()->first());
                return redirect()->back();
            } else {
                $user_id = User::insertGetId([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'role' => 'provider',
                    'state' => $request->state,
                    'country' => $request->country,
                    'lat' => $request->lat,
                    'long' => $request->long,
                    'email_verified_at' => '1',
                    'company_id' => $request->company,
                    'employee_id' => Helper::generateEmployeeID($full_name),
                    // 'account_number'=>$request->account_number
                ]);
                UserDetails::insert([
                    'user_id' => $user_id,
                    'user_role' => 'provider'
                ]);
                $company = DB::table('companies')->where('company_id', $request->company)->first();
                Provider::insert([
                    'user_id' => $user_id,
                    'service' => $request->service,
                    'company_name' => $company->company_name,
                    'working_start' => Carbon::now(),
                    'working_end' => Carbon::now()->endOfDay(),
                    'work_start_time' => Carbon::now()->startOfDay(),
                    'work_end_time' => Carbon::now()->endOfDay(),
                ]);
                Session::flash('success_message', 'The provider is added successfully to the list');
                return redirect()->back();
            }
        } else {
            return view('admin.sections.addassociatedproviders')->with(compact('company_id'));
        }
    }
}
