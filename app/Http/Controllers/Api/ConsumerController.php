<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Validator;
use App\Category;
use App\UserDetails;
use App\Provider;
use App\Consumer;
use App\ConsumerCardDetails;
use App\Rating;
use App\User;
use DB;

class ConsumerController extends Controller
{
    /**
     * ------------------------------------------------------------
     * CONSUMER CONTROLLER
     * ------------------------------------------------------------
     * All the functionalities related to consumer and functionality
     * performed by consumer on consumer homescreen are all lies here
     * 
     * ------------------------------------------------------------
     */

     /**
     * -----------------------------------------------------------
     * INSERT CATEGORY API --  FOR ADMIN USER ONLY
     * -----------------------------------------------------------
     */
    public function consumerCategory(Request $request){
        $val = Validator::make($request->all(),[
            // rules for validation
            'category'=>'required',
            // 'category_image'=>'required'
        ]);
        if($val->fails()){
            return response()->json([
                'status'=>false,
                'message'=>$val->errors()->first(),
                'response'=>[],
            ]);
        }
        else{
            $id = Category::insertGetId([
                'service_category'=>$request->category
            ]);
            if ($request->hasFile('image')) { // check if there is a file present in the postman request
                $name = 'category_image_' . mt_rand(10, 1000) . '.' . $request->image->extension();
                $request->image->move(public_path() . '/category_images/consumer/id-'.$id, $name);
                // $complete_path = url('/') . '/images/user_images/consumer/id-'.$request->user_id;
                Category::where('id', $id)->update(['service_category_image' => $name]);
            }
            return response()->json(['status'=>true,'message'=>'The category is saved successfully ! ','response'=>Category::where('id',$id)->first()]);
        }    
    }
    /** 
     * -----------------------------------------------------------------------------------
     * FETCH CATEGORIES API -- categories that are displayed in consumer homescreen
     * -----------------------------------------------------------------------------------
     */
    public function fetchCategories(Request $request){
        return response()->json(['status'=>true,'message'=>'Categories is fetched successfully','response'=>Helper::fetchingCategoryData()]);
    }
    /**
     * -----------------------------------------------------------------------------------
     * UPDATE CURRENT LOCATION -- CONSUMER HOMESCREEN
     * -----------------------------------------------------------------------------------
     * update current location field in the select categories section -- consumer screen
     */
    public function updateCurrentLocation(Request $request){
        $val= Validator::make($request->all(),[
            #rules for validation
            'consumer_id'=>'required|numeric',
            // 'lat'=>'required',
            // 'long'=>'required'
            // 'address'=>'required',
        ]);
        if($val->fails()){
            return response()->json(['status'=>false,'message'=>$val->errors()->first(),'response'=>[]]);
        }
        if(!Consumer::where('user_id',$request->consumer_id)->first()){
            return response()->json(['status'=>false,'message'=>'Consumer with the mentioned id doesnot exsist','response'=>[]]);
        }
        else{
            User::where('id',$request->consumer_id)->update([
                'address'=>isset($request->address)?$request->address : User::find($request->consumer_id)->address,
                'lat'=>isset($request->lat)?$request->lat:User::find($request->consumer_id)->lat,
                'long'=>isset($request->long)?$request->long:User::find($request->consumer_id)->long
                ]);
            return response()->json(['status'=>true,'message'=>'Data update successfull','response'=>User::where('id',$request->consumer_id)->select('id','address','lat','long')->first()]);
        }
    }
    /**
     * -------------------------------------------------
     * UPDATE CATEGORY API --  FOR ADMIN USER ONLY
     * -------------------------------------------------
     */
    public function updateCategoryImage(Request $request){
        $val = Validator::make($request->all(),[
            # rules for validation
            'id'=>'required',
        ]);
        if($val->fails()){
            return response()->json(['status'=>false,'message'=>$val->errors()->first(),'response'=>[],]);
        }
        if(!Category::find($request->id)){
            return response()->json(['status'=>false,'message'=>'Category with the mentioned id does not exsist','response'=>[]]);
        }
        // Category::where('id',$request->id)->update([
        //     ''
        // ]);
        if ($request->hasFile('image')) { // check if there is a file present in the postman request
            if(Category::find($request->id)->service_category_image == null){
                $name = 'category_image_' . mt_rand(10, 1000) . '.' . $request->image->extension();
                $request->image->move(public_path() . '/category_images/consumer/id-'.$id, $name);
                Category::where('id', $id)->update(['service_category_image' => $name]);
                return response()->json(['status'=>true,'message'=>'Category image is updated successfully','response'=>Category::find($request->id)->service_category_image]);
            }
            else{
                unlink('category_images/consumer/id-'.$request->id.'/'.Category::find($request->id)->image);
                $name = 'category_image_' . mt_rand(10, 1000) . '.' . $request->image->extension();
                $request->image->move(public_path() . '/category_images/consumer/id-'.$id, $name);
                Category::where('id', $id)->update(['service_category_image' => $name]);
                return response()->json(['status'=>true,'message'=>'Category image is updated successfully','response'=>Category::find($request->id)->service_category_image]);
            }
            
        }
    }
    public function index(Request $request) {

        $latitude       =       "28.418715";
        $longitude      =       "77.0478997";

        $shops          =       DB::table("shops");

        $shops          =       $shops->select("*", DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                                * cos(radians(latitude)) * cos(radians(longitude) - radians(" . $longitude . "))
                                + sin(radians(" .$latitude. ")) * sin(radians(latitude))) AS distance"));
        $shops          =       $shops->having('distance', '<', 20);
        $shops          =       $shops->orderBy('distance', 'asc');

        $shops          =       $shops->get();

        return view('shop-listing', compact("shops"));
    }
    /**
     * -------------------------------------------------------------
     * FETCH NEARBY SERVICE PROVIDERS -- consumer screen
     * -------------------------------------------------------------
     */
    public function nearbyServiceProviders(Request $request){
        $val = Validator::make($request->all(),[
            #rules for validation
            'user_id'=>'required',
            'service_category'=>'required',
            'lat'=>'numeric',
            'long'=>'numeric',
            'distance'=>'numeric'
        ]);
        if($val->fails()){
            return response()->json(['status'=>false,'message'=>'Error ! '.$val->errors()->first(),'response'=>[]]);
        }
        else{
            // dd($request->service_category);
            if($request->distance == 0){
                $distance = 2;
            }
            else{
                $distance = $request->distance;
            }
            $latitude = $request->lat;
            $longitude = $request->long;
            // dd($latitude,'   ',$longitude);
            $providersInfo = DB::table('users')
                                ->join('user_details', 'users.id', '=', 'user_details.user_id')
                                ->join('providers', 'user_details.user_id', '=', 'providers.user_id')
                                ->select('users.id','user_details.user_id','users.lat','users.long','users.first_name','user_details.user_id','user_details.user_role','providers.company_name','providers.company_description','user_details.image', 'providers.rate','providers.avg_rating'
                                // ->select("users.id"
                                        ,DB::raw("3959 * acos(cos(radians(" . $latitude . "))
                                        * cos(radians(users.lat)) * cos(radians(users.long) - radians(" . $longitude . "))
                                        + sin(radians(" .$latitude. ")) * sin(radians(users.lat))) AS distance"))
                                ->having('distance', '<', $distance)
                                ->where('users.role','provider')
                                ->where('providers.service','like','%'.substr($request->service_category,0,4).'%')
                                // ->orderBy('user_details.user_id','desc')
                                ->orderBy('distance','asc')
                                ->get();
            foreach($providersInfo as $pro){
                if ($pro->image == null){
                    // break;
                    $pro->image=url('/').'/images/user_images/dummy.jpg'; // displayed when user_image column is empty
                }
                else{
                    $pro->image=url('/').'/images/user_images/provider/id-'.$pro->user_id.'/'.$pro->image;
                }
            }
            return response()->json(['status'=>true,'message'=>'Nearby providers ','response'=>$providersInfo]);
        }
    }
    /**
     * -------------------------------------------------------
     * SERVICE PROVIDER INFO API -- consumer screeen
     * -------------------------------------------------------
     */
    public function serviceProviderInfo(Request $request){
        $val = Validator::make($request->all(),[
            #rules for validation
            'user_id'=>'required'
        ]);
        if($val->fails()){
            return response()->json(['status'=>false,'message'=>$val->errors()->first(),'response'=>[]]);
        }
        if(!User::where('id',$request->user_id)->first()){
            return response()->json(['status'=>false,'message'=>'User with the mentioned id does not exsist','response'=>[]]);
        }
        if(!Provider::where('user_id',$request->user_id)->first()){
            return response()->json(['status'=>false,'message'=>'Provider with the mentioned id does not exsist','response'=>[]]);
        }
        else{
            $imgUrls=[];
            foreach(explode(',',Provider::where('user_id',$request->user_id)->first()->done_jobs_images) as $img){
                if ($img == null){
                    break;
                }
                else{
                    $imgUrls[]=Helper::doneJobsImagesUrls().'id-'.$request->user_id.'/'.$img;
                }
            }
            if(UserDetails::where('user_id',$request->user_id)->first()->image == null){
                // $user_image = url('/').'/images/user_images/dummy.jpg';
                $user_image = null;
            }
            else{
                $user_image = Helper::providerImagesUrls().'id-'.$request->user_id.'/'.UserDetails::where('user_id',$request->user_id)->first()->image;
            }
            $data = DB::table('users')
                        ->join('user_details','user_details.user_id','=','users.id')
                        ->join('providers','providers.user_id','=','user_details.user_id')
                        ->where('users.id',$request->user_id)
                        ->select('user_details.user_id','users.first_name','users.last_name','users.role','user_details.onboarding_status','user_details.stripe_account_id','user_details.stripe_refresh_token','providers.company_name', 
                                'providers.company_description','users.state','users.country','users.account_number','users.routing_account_number','providers.rate','providers.service','users.address','providers.experience','providers.working_start','providers.working_end',
                                'providers.work_start_time','providers.work_end_time','user_details.image','providers.done_jobs_images')
                        ->first();
                        // dd($data);
            if($data->image != null){
                $data->image = url('/').'/images/user_images/provider/id-'.$data->user_id.'/'.$data->image;
            }
            if($data->done_jobs_images != null){
                // $data->doneimage = url('/').'/images/user_images/provider/id-'.$data->user_id.'/'.$data->image;
                $imgUrls = [];
                foreach(explode(',',$data->done_jobs_images) as $img){
                        // dd($img);
                        if($img == null){
                            break;
                        }
                        $imgUrls[]=url('/').'/images/jobs/provider/done_jobs_images/id-'.$request->user_id.'/'.$img;
                        
                }
                $data->done_jobs_images = $imgUrls;
            }

            // $data = [
            //     'user_id'=>UserDetails::where('user_id',$request->user_id)->first()->user_id,
            //     'first_name'=>User::where('id',$request->user_id)->first()->first_name,
            //     'last_name'=> User::where('id',$request->user_id)->first()->last_name,
            //     'address'=>Users::where('id',$request->user_id)->first()->address,
            //     'onboarding_status'=>UserDetails::where('id',$request->user_id)->first()->onboarding_status,
            //     'stripe_account_id'=>UserDetails::where('id',$request->user_id)->first()->stripe_account_id,
            //     'stripe_refresh_token'=>UserDetails::where('id',$request->user_id)->first()->stripe_refresh_token,
            //     'role'=>UserDetails::where('user_id',$request->user_id)->first()->user_role,
            //     'company_name'=>Provider::where('user_id',$request->user_id)->first()->company_name,
            //     'company_description'=>Provider::where('user_id',$request->user_id)->first()->company_description,
            //     'state'=>User::where('id',$request->user_id)->first()->state,
            //     'country'=>User::where('id',$request->user_id)->first()->country,
            //     'account_number'=>User::where('id',$request->user_id)->first()->account_number,
            //     'rate'=>Provider::where('user_id',$request->user_id)->first()->rate,
            //     'service'=>Provider::where('user_id',$request->user_id)->first()->service,
            //     'address'=>User::where('id',$request->user_id)->first()->address,
            //     'experience'=>Provider::where('user_id',$request->user_id)->first()->experience,
            //     'working_start'=>Provider::where('user_id',$request->user_id)->first()->working_start,
            //     'working_end'=>Provider::where('user_id',$request->user_id)->first()->working_end,
            //     'work_start_time'=>Provider::where('user_id',$request->user_id)->first()->work_start_time,
            //     'work_end_time'=>Provider::where('user_id',$request->user_id)->first()->work_end_time,
            //     'user_image'=>$user_image,
            //     'done_jobs_images'=>$imgUrls
            // ];
            return response()->json(['status'=>true,'message'=>'The data is fetched successfully !','response'=>$data]);
        }
    }
    //  give ratings to the provider and save it to the DB
    public function providerRatings(Request $request){
        $val = Validator::make($request->all(),[
            #rules for validation
            'job_id'=>'required|numeric',
            'consumer_id'=>'required|numeric',
            'provider_id'=>'required|numeric',
            'rating'=>'numeric|min:1|max:5',
            // 'feedback'=>'string',
        ]);
        if($val->fails()){
            return response()->json(['status'=>false,'message'=>$val->errors()->first(),'response'=>[]]);
        }
        // if($request->rating == null){
        //     return response()->json(['status'=>false,'message'=>'Please give us a rate for serve you','resposne'=>[]]);
        // }
        else{
            $id = Rating::insertGetId([
                'job_id'=>$request->job_id,
                'consumer_id'=>$request->consumer_id,
                'provider_id'=>$request->provider_id,
                'rating'=>$request->rating,
                'feedback'=>$request->feedback,
            ]);
            return response()->json(['status'=>true,'message'=>'Ratings are saved successfully','resposne'=>Rating::where('id',$id)->first()]);
        }
    }
    //fetch avg ratings of the provider 
    public function avgRatings(Request $request){
        $val = Validator::make($request->all(),[
            #rules for validation
            'provider_id'=>'required|numeric',
        ]);
        if($val->fails()){
            return response()->json(['status'=>false,'message'=>$val->errors()->first(),'response'=>[]]);
        }
        else{
            $avg = Rating::where('provider_id',$request->provider_id)->avg('rating');
            provider::where('user_id',$request->provider_id)->update(['avg_rating'=>$avg]);
            return response()->json(['status'=>true,'message'=>'data fetched successfully','response'=>Provider::where('user_id',$request->provider_id)->first()]);
        }
    }
    /**
     * ----------------------------------------------------------------
     * fetch user current location -- consumer screen
     * ----------------------------------------------------------------
     */
    public function fetchCurrentLocation(Request $request){
        $val= Validator::make($request->all(),[
            #rules for validation
            'consumer_id'=>'required|numeric',
        ]);
        if($val->fails()){
            return response()->json(['status'=>false,'message'=>$val->errors()->first(),'response'=>[]]);
        }
        if(!Consumer::where('user_id',$request->consumer_id)->first()){
            return response()->json(['status'=>false,'message'=>'Consumer with the mentioned id does not exsist','response'=>[]]);
        }
        else{
            // $data = User::where('id',$request->consumer_id)->select('id','address','lat','long')->first();
            $data = User::where('id',$request->consumer_id)->first()->address;
            return response()->json(['status'=>true,'message'=>'The user current location is fetched successfully','response'=>$data]);
        }
    }
    // save card details of the consumer
    public function saveCardDetails(Request $request){
        $val= Validator::make($request->all(),[
            #rules for validation
            'consumer_id'=>'required|numeric',
            'card_number'=>'numeric|unique:consumer_card_details',
            // 'card_holder_name'=>'',
            'card_expiry_month'=>'numeric',
            'card_expiry_year'=>'numeric',
            // 'card_type'=>''
        ]);
        if($val->fails()){
            return response()->json(['status'=>false,'message'=>$val->errors()->first(),'response'=>[]]);
        }
        if(!Consumer::where('user_id',$request->consumer_id)->first()){
            return response()->json(['status'=>false,'message'=>'Consumer with the mentioned id does not exsist','response'=>[]]);
        }
        else{
            Consumer::where('user_id',$request->consumer_id)->update([
                'card_number'=>$request->card_number,
                'card_holder_name'=>$request->card_holder_name,
                'card_expiry_month'=>$request->card_expiry_month,
                'card_expiry_year'=>$request->card_expiry_year,
                'card_type'=>$request->card_type,
            ]);
            $id = ConsumerCardDetails::insertGetId([
                'consumer_id'=>$request->consumer_id,
                'card_number'=>$request->card_number,
                'card_holder_name'=>$request->card_holder_name,
                'card_expiry_month'=>$request->card_expiry_month,
                'card_expiry_year'=>$request->card_expiry_year,
                'card_type'=>$request->card_type,
                'bank_name'=>$request->bank_name,
                'card_id'=>$request->card_id,
                'token_id'=>$request->token_id,
            ]);
            return response()->json(['status'=>true,'message'=>'Card details saved successfully','response'=>ConsumerCardDetails::where('id',$id)->select('id','consumer_id','card_holder_name','card_number','card_expiry_month','card_expiry_year','card_type')->first()]);

        }
    }
    //
    public function fetchConsumerCardDetails(Request $request){
        $val= Validator::make($request->all(),[
            #rules for validation
            'consumer_id'=>'required|numeric',
        ]);
        if($val->fails()){
            return response()->json(['status'=>false,'message'=>$val->errors()->first(),'response'=>[]]);
        }
        if(!Consumer::where('user_id',$request->consumer_id)->first()){
            return response()->json(['status'=>false,'message'=>'Consumer with the mentioned id does not exsist','response'=>[]]);
        }
        else{
            $data = ConsumerCardDetails::where('consumer_id',$request->consumer_id)->get();
            return response()->json(['status'=>true,'message'=>'Data fetched successfully','response'=>$data]);
        }
    }
}
