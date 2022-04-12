<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\User;
use App\UserDetails;
use App\Provider;
use DB;

class ProviderController extends Controller
{
    //
    /**
     * --------------------------------------------------------
     * MY SCHEDULE -- provider
     * --------------------------------------------------------
     * All the functionalities related to provider and functionality
     * performed by provider on provider homescreen are all lies here
     * 
     * --------------------------------------------------------------
     */
    public function mySchedule(Request $request){
        $val = Validator::make($request->all(),[
            #rules for validation
            'user_id'=>'required',
            // 'work_start_date'=>'date|date_format:Y-m-d',
            // 'work_end_date'=>'date|date_format:Y-m-d',
            // 'work_start_time'=>'date|date_format:Y-m-d',
            // 'work_end_time'=>'date|date_format:Y-m-d'
        ]);
        if($val->fails()){
            return response()->json(['status'=>false,'message'=>$val->errors()->first(),'response'=>[]]);
        }
        $user = User::find($request->user_id);
        if(!$user){
            return response()->json(['status'=>false,'message'=>'User with the mentioned id does not exsist','response'=>[]]);
        }
        if($user->role === 'consumer' ){
            return response()->json(['status'=>false,'message'=>'This user id belongs to consumer','response'=>[]]);
        }
        else{
            // dd($request->work_end_date);
            Provider::where('user_id',$request->user_id)->update([
                'user_id'=>$request->user_id,
                // 'company_name'=>UserDetails::find($request->user_id)->company_name,
                // 'service'=>UserDetails::find($request->user_id)->service,
                // 'experience'=>UserDetails::find($request->user_id)->experience,
                // 'rate'=>UserDetails::find($request->user_id)->rate,
                'working_start'=>$request->work_start_date,
                'working_end'=>$request->work_end_date,
                'work_start_time'=>$request->work_start_time,
                'work_end_time'=>$request->work_end_time,
                // 'company_description'=>UserDetails::find($request->user_id)->company_description
            ]);
            $data = Provider::where('user_id',$request->user_id)->select('working_start','working_end','work_start_time','work_end_time')->first();
            // dd($data);
            // $data = [
            //     // 'user_id'=>Provider::where('user_id',$request->user_id)->first()->user_id,
            //     'working_start'=>Provider::where('user_id',$request->user_id)->first()->working_start,
            //     'working_end'=>Provider::where('user_id',$request->user_id)->first()->working_end,
            //     'work_start_time'=>Provider::where('user_id',$request->user_id)->first()->work_start_time,
            //     'work_end_time'=>Provider::where('user_id',$request->user_id)->first()->work_end_time,
            // ];
            return response()->json(['status'=>true,'message'=>'The schedule is updated successfully','response'=>$data]);
        }
    }
    /**
     * ----------------------------------------------------------------
     * Update rate for associated providers
     * ----------------------------------------------------------------
     */
    public function updateRate(Request $request){
        $val = Validator::make($request->all(),[
            'user_id' => 'required|exists:users,id',
            'address'=>'required',
            'lat' => 'required',
            'long' => 'required',
            'rate'=>'required|numeric',
 
        ]);
        if($val->fails()){
            return response()->json(['status' =>false,'message'=>$val->errors()->first(),'response'=>[]]);
        }
        else{
            if($request->has('type')){
                if($request->type == 'assoc_provider'){
                    
                }
            }
            $user = User::where('id',$request->user_id)->first();
            User::where('id',$request->user_id)->update([
                'address' => $request->address,
                'lat' => $request->lat,
                'long' => $request->long,
            ]);
            UserDetails::where('user_id',$request->user_id)->update([
                'experience'=>$request->experience,
                'rate'=>$request->rate,
            ]);
            Provider::where('user_id',$request->user_id)->update([
                'user_id'=>$request->user_id,
                // 'company_name'=>UserDetails::find($request->user_id)->company_name,
                // 'service'=>UserDetails::find($request->user_id)->service,
                // 'experience'=>UserDetails::find($request->user_id)->experience,
                'rate'=>$request->rate,
                'working_start'=>$request->work_start_date,
                'working_end'=>$request->work_end_date,
                'work_start_time'=>$request->work_start_time,
                'work_end_time'=>$request->work_end_time,
                // 'company_description'=>UserDetails::find($request->user_id)->company_description
            ]);
            $data = Provider::where('user_id',$request->user_id)->select('working_start','working_end','work_start_time','work_end_time')->first();
            return response()->json(['status'=>true,'message'=>'Data update successfully','response'=>$data]);
        }
    }
     /**
     * ----------------------------------------------------------------
     * fetch scheduled tasks for providers by date
     * ----------------------------------------------------------------
     */
    public function scheduledTasks(Request $request){
        $val = Validator::make($request->all(),[
            #rules for validation
            'user_id'=>'required|exists:jobs,provider_id',
            'date' => 'required'
        ],[
            'user_id.exists' => 'No jobs found'
        ]);
        if($val->fails()){
            return response()->json(['status'=>false,'message'=>$val->errors()->first(),'response'=>[]]);
        }
        $user = User::find($request->user_id);
        if(!$user){
            return response()->json(['status'=>false,'message'=>'User with the mentioned id does not exsist','response'=>[]]);
        }
        if($user->role === 'consumer' ){
            return response()->json(['status'=>false,'message'=>'This user id belongs to consumer','response'=>[]]);
        }
        else{
            // $data = DB::table('jobs')   
            //             ->where('provider_id',$request->user_id)
            //             ->whereDate('job_date', $request->date)
            //             ->get();
                        // dd($data);
            $data = DB::table('user_details')
                ->join('consumers','consumers.user_id','=','user_details.user_id')
                ->join('users','users.id','=','user_details.user_id')
                ->join('jobs','jobs.consumer_id','=','consumers.user_id')
                ->select('jobs.id','jobs.consumer_id','jobs.provider_id','jobs.job_title','jobs.job_category','users.first_name','jobs.job_date','jobs.job_time','jobs.created_at','jobs.job_status','jobs.job_done_status','user_details.image')
                // ->where('jobs.id',$request->job_id)
                ->where('jobs.provider_id',$request->user_id)
                // ->where('jobs.job_status','not_accepted')
                // ->where('jobs.job_done_status','pending')
                ->whereDate('jobs.job_date', $request->date)
                ->orderBy('jobs.id','desc')
                ->get();
                foreach($data as $consumer){
                    if ($consumer->image == null){
                        // break;
                        $consumer->image=url('/').'/images/user_images/dummy.jpg'; // displayed when user_image column is empty
                    }
                    else{
                        $consumer->image=url('/').'/images/user_images/consumer/id-'.$consumer->consumer_id.'/'.$consumer->image;
                    }
                }
            return response()->json(['status'=>true,'message'=>'The data successfully','response'=>$data]);
        }
    }
     /**
     * ----------------------------------------------------------------
     * fetch all scheduled tasks
     * ----------------------------------------------------------------
     */
    public function AllScheduledTasks(Request $request){
        $val = Validator::make($request->all(),[
            #rules for validation
            'user_id'=>'required|exists:jobs,provider_id',
        ],[
            'user_id.exists' => 'No jobs found'
        ]);
        if($val->fails()){
            return response()->json(['status'=>false,'message'=>$val->errors()->first(),'response'=>[]]);
        }
        $user = User::find($request->user_id);
        if(!$user){
            return response()->json(['status'=>false,'message'=>'User with the mentioned id does not exsist','response'=>[]]);
        }
        if($user->role === 'consumer' ){
            return response()->json(['status'=>false,'message'=>'This user id belongs to consumer','response'=>[]]);
        }
        else{
            // $data = DB::table('jobs')   
            //             ->where('provider_id',$request->user_id)
            //             ->whereDate('job_date', $request->date)
            //             ->get();
                        // dd($data);
            $data = DB::table('user_details')
                ->join('consumers','consumers.user_id','=','user_details.user_id')
                ->join('users','users.id','=','user_details.user_id')
                ->join('jobs','jobs.consumer_id','=','consumers.user_id')
                ->select('jobs.id','jobs.consumer_id','jobs.provider_id','jobs.job_title','jobs.job_category','users.first_name','jobs.job_date','jobs.job_time','jobs.created_at','jobs.job_status','jobs.job_done_status','user_details.image')
                // ->where('jobs.id',$request->job_id)
                ->where('jobs.provider_id',$request->user_id)
                // ->where('jobs.job_status','not_accepted')
                // ->where('jobs.job_done_status','pending')
                ->orderBy('jobs.id','desc')
                ->get();
                foreach($data as $consumer){
                    if ($consumer->image == null){
                        // break;
                        $consumer->image=url('/').'/images/user_images/dummy.jpg'; // displayed when user_image column is empty
                    }
                    else{
                        $consumer->image=url('/').'/images/user_images/consumer/id-'.$consumer->consumer_id.'/'.$consumer->image;
                    }
                }
            return response()->json(['status'=>true,'message'=>'The data successfully','response'=>$data]);
        }
    }

}
