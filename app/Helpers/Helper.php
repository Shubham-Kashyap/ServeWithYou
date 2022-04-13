<?php
namespace App\Helpers;
use App\Category;
use App\User;
use App\UserDetails;
use App\BlockedUsers;
use App\Provider;
use App\Consumer;
use App\Jobs;
use App\Notification;
use App\ProviderNotification;
Use App\RejectedJobs;
use Auth;
use DB;


class Helper{
    public static function adminImage(){
        if(Auth::guard('admin')->check()){
            $id = Auth::guard('admin')->user()->id;
            // dd(UserDetails::where('id',$id)->first());
            if(UserDetails::where('id',$id)->first()->image){
                $admin_image = url('/').'/images/admin_images/'.UserDetails::where('id',$id)->first()->image;
            }
            else{
                $admin_image = url('/').'/images/user_images/dummy.jpg';
            }
            return $admin_image;
        }
       

    }
    public static function adminName(){
        if(Auth::guard('admin')->check()){
            $first_name = Auth::guard('admin')->user()->first_name;
            $last_name = Auth::guard('admin')->user()->last_name;
            return $first_name.' '.$last_name;
        }
        
        
        
    }
    public static function memberSince(){

        if(Auth::guard('admin')->check()){
            return Auth::guard('admin')->user()->created_at;
        }
    }
    public static function blockedUsersCount(){
        return BlockedUsers::all()->count();
    }
    public static function userImageUrl(){
        $complete_path = url('/') . '/images/userimages/' ;
        return $complete_path;
    }
    public static function doneJobsImagesUrls(){
        return url('/').'/images/jobs/provider/done_jobs_images/';
    }
    public static function providerImagesUrls(){
        return url('/').'/images/user_images/provider/';
    }
    public static function consumerImagesUrls(){
        return url('/').'/images/user_images/consumer/';
    }
    public static function categoriesImagesUrls(){
        return url('/').'/category_images/consumer/';
    }
    public static function postJobsImageUrls(){
        $complete_path = url('/') . '/jobs/';
        return $complete_path;
    }
    public static function totalUsersCount(){
        return User::all()->count()-1;
    }
    public static function totalConsumersCount(){
        return Consumer::all()->count();
    }
    public static function totalProvidersCount(){
        return Provider::all()->count();
    }
    public static function totalCategoriesCount(){
        return Category::all()->count();
    }
    public static function totalJobsCount(){
        return Jobs::all()->count();
    }
    public static function rejectedJobsCount(){
        return RejectedJobs::all()->count();
    }
    public static function doneJobsCount(){
        return Jobs::where('job_done_status','done')->count();
    }
    public static function consumerRejectedJobsCount($consumer_id,$provider_id){
        $data = RejectedJobs::where('consumer_id',$consumer_id)->where('provider_id',$provider_id)->count();
        return $data;
    }
    public static function updateProviderNotificationData($provider_id){
        $notification_data = [
            'title'=>"Hi, ".User::where('id',$request->provider_id)->first()->first_name,
            'description'=>'Consumer '.User::where('id', $request->consumer_id )->first()->first_name.' has posted you a new job  !',
            'image'=>Helper::consumerImagesUrls().'id-'.$request->consumer_id.'/'.UserDetails::where('user_id',$request->consumer_id)->first()->image,
        ];
    }
    public static function updateConsumerNotificationData($consumer_id){
        $notification_data = [
            'title'=>"Hi, ".User::where('id', Jobs::where('id',$request->job_id)->first()->consumer_id )->first()->first_name,
            'description'=>'Provider '.User::where('id', Jobs::where('id',$request->job_id)->first()->provider_id )->first()->first_name.' has accepted your job request !',
            'image'=>Helper::providerImagesUrls().'id-'.Jobs::where('id',$request->job_id)->first()->provider_id.'/'.UserDetails::where('user_id',Jobs::where('id',$request->job_id)->first()->provider_id)->first()->image,
        ];
        Notification::where('consumer_id',$request->user_id)->update($notification_data);
    }
    public static function consumerDoneJobsCount($consumer_id,$provider_id){
        $data = Jobs::where('consumer_id',$consumer_id)->where('provider_id',$provider_id)
                    ->where('job_status','accepted')
                    ->where('job_done_status','done')
                    ->count();
        return $data;
    }
    // jobs posted by consumer to a particular provider
    public static function consumerPostedJobsCount($consumer_id,$provider_id){
        $data = Jobs::where('consumer_id',$consumer_id)->where('provider_id',$provider_id)->count();
        // if($data == null){
        //     $data = RejectedJobs::where('consumer_id',$id)->count();
        // }
        return $data;
    }
    public static function providerRejectedJobsCount($consumer_id,$provider_id){
        $data = RejectedJobs::where('provider_id',$provider_id)->where('consumer_id',$consumer_id)->where('job_status','rejected')->count();
        return $data;
    }
    public static function deviceToken($id){
        $user_id = Jobs::where('id',$id)->first()->consumer_id;
        return User::where('id',$user_id)->first()->device_token;
    }
    public static function completedJobImagesUrls(){
        return url('/').'/images/jobs/provider/completed_job_images/';
    }
    public static function sendPushNotification($server_key,$device_token,$notification_body){// function to send push notification 
        
        $headers = [
            'Authorization: key=' . $server_key,
            'Content-Type: application/json',
        ];
        
        $data = [
            'to' => $device_token,
            'notification' =>$notification_body,
            
            'priority'=>'high',
        ];
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));// data should be sended in json format 
        $response = curl_exec($ch);
        if($response == false){
            return response()->json(['status'=>false,'message'=>curl_error($ch),'response'=>[]]);
        }
        // dd($response);
        // return response()->json(['status'=>false,'message'=>'send nofications testing','response'=>$response]);
    }
    public static function fetchingCategoryData(){
        $categories = Category::all();
        $data =[];
        foreach($categories as $cat){
            $cat->image = url('/').'/category_images/consumer/id-'.$cat->id.'/'.$cat->service_category_image;
            if($cat->service_category_image == null){
                // $cat->image = null;
                $cat->image = url('/').'/category_images/consumer/dummy_category.jpg';
            }
            $data[] = $cat;
        }
        return $data;
    }
    public static function generateRandomPasswrod($len){
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#$%&!";
        $password = substr( str_shuffle( $chars ), 0, $len );
        return $password;
    }
    public static function ShortIntro($string, $wordsreturned)
    {
        $retval = $string;  //  Just in case of a problem
        $array = explode(" ", $string);
        /*  Already short enough, return the whole thing*/
        if (count($array)<=$wordsreturned)
        {
            $retval = $string;
        }
        /*  Need to chop of some words*/
        else
        {
            array_splice($array, $wordsreturned);
            $retval = implode(" ", $array)." ...";
        }
        return $retval;
    }
    /**
     * ----------------------------------------------------------------
     * Generate company id 
     * ----------------------------------------------------------------
     */
    public static function generateCompanyID($string_name, $rand_no = 1000000000){
		$username_parts = array_filter(explode(" ", strtoupper($string_name))); //explode and lowercase name
		$username_parts = array_slice($username_parts, 0, 2); //return only first two arry part
	
		$part1 = (!empty($username_parts[0]))?substr($username_parts[0], 0,8):""; //cut first name to 8 letters
		$part2 = (!empty($username_parts[1]))?substr($username_parts[1], 0,5):""; //cut second name to 5 letters
		$part3 = ($rand_no)?rand(10000, $rand_no):"";
		
		$username = $part1. str_shuffle($part2). $part3; //str_shuffle to randomly shuffle all characters 
		if(User::where('company_id',$username)->first()){
            Helper::generate_username($string_name , $rand_no = 1000000000);
        }
        return $username;
    }
    /**
     * ----------------------------------------------------------------
     * Generate employee id
     * ----------------------------------------------------------------
     */
    public static function generateEmployeeID($string_name, $rand_no = 1000){
		$username_parts = array_filter(explode(" ", strtoupper($string_name))); //explode and lowercase name
		$username_parts = array_slice($username_parts, 0, 2); //return only first two arry part
	
		$part1 = (!empty($username_parts[0]))?substr($username_parts[0], 0,8):""; //cut first name to 8 letters
		$part2 = (!empty($username_parts[1]))?substr($username_parts[1], 0,5):""; //cut second name to 5 letters
		$part3 = ($rand_no)?rand(99, $rand_no):"";
		
		$username = $part1. str_shuffle($part2). $part3; //str_shuffle to randomly shuffle all characters 
		if(User::where('employee_id',$username)->first()){
            Helper::generate_username($string_name , $rand_no = 1000);
        }
        return $username;
    }
    public static function fetchingCompaniesData(){
        return DB::table('companies')
                    ->orderBy('company_name','ASC')
                    ->get();
    }
    
}