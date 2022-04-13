<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Consumer;
Use App\Provider;
Use App\RejectedJobs;
use App\Jobs;
use DB;
use Validator;
use Session;


class ManageUserJobsController extends Controller
{
    //
    public function allCategories(){
        Session::put('page','allcategories');
        $data = Category::all();
        return view('admin.sections.allcategories')->with(compact('data'));
    }
    public function addCategories(Request $request){
        Session::put('page','addcategories');
        if($request->isMethod('post')){
            $rulesForValidation = [
                'category_name'=>'required',  
            ];
            // dd($request->all());
            $val = validator::make($request->all(),$rulesForValidation);
            if ($val->fails()){
                Session::flash('error_message',$val->errors()->first());
                return redirect()->back()->withInput();
            }
            else{
                $id = Category::insertGetId(['service_category'=>$request->category_name]);
                if ($request->hasFile('image')) { // check if there is a file present in the postman request
                    $name = 'category_image_' . mt_rand(10, 1000) . '.' . $request->image->extension();
                    $request->image->move(public_path() . '/category_images/consumer/id-'.$id, $name);
                    // $complete_path = url('/') . '/images/user_images/consumer/id-'.$request->user_id;
                    Category::where('id', $id)->update(['service_category_image' => $name]);
                }
                Session::flash('success_message','The Category is saved successfully');
                return redirect('admin/categories/all-categories');
            }
        }
        else{
            return view('admin.sections.addcategories');
        }
    }
    // edit categories 
    public function updateCategories(Request $request, $id){
        $data = Category::find($id);
        if($request->isMethod('post')){
            $rulesForValidation = [
                'category_name'=>'required',  
            ];
            // dd($request->all());
            $val = validator::make($request->all(),$rulesForValidation);
            if ($val->fails()){
                Session::flash('error_message',$val->errors()->first());
                return redirect()->back()->withInput();
            }
            Category::where('id',$id)->update(['service_category'=>$request->category_name]);
            if ($request->hasFile('image')) { // check if there is a file present in the postman request
                $name = 'category_image_' . mt_rand(10, 1000) . '.' . $request->image->extension();
                $request->image->move(public_path() . '/category_images/consumer/id-'.$id, $name);
                // $complete_path = url('/') . '/images/user_images/consumer/id-'.$request->user_id;
                Category::where('id', $id)->update(['service_category_image' => $name]);
            }
            Session::flash('success_message','The category is edited successfully');
            return redirect('admin/categories/all-categories');
        }
        else{
            // Category::
            return view('admin.sections.editcategories')->with(compact('data'));
        }
    }
    // delete category
    public function deleteCategory($id){
        if(Category::find($id)->service_category_image != null){
            unlink('category_images/consumer/id-'.$id.'/'.Category::find($id)->service_category_image);
        }
        Category::where('id',$id)->delete();
        Session::flash('success_message','The Category is successfully deleted');
        return redirect()->back();
    }
    // all jobs 
    public function allJobs(Request $request){
        Session::put('page','alljobs');
        $data = Jobs::get();
        return view('admin.sections.alljobs')->with(compact('data'));
    }
    // all rejected jobs
    public function rejectedJobs(){
        Session::put('page','rejectedjobs');
        $data = RejectedJobs::get();
        return view('admin.sections.rejectedjobs')->with(compact('data'));
    }
    // all done jobs
    public function doneJobs(){
        Session::put('page','donejobs');
        $data = Jobs::where('job_done_status','done')->get();
        return view('admin.sections.donejobs')->with(compact('data'));
    }
    // edit jobs
    public function editJobs(Request $request, $id){
        Session::put('page','alljobs');
        $data = Jobs::where('id',$id)->first();
        if($request->isMethod('post')){
            // dd($request->all());
            $rulesForValidation = [
                'job_title'=>'required|',
                'job_location'=>'required',
                'job_description'=>'required'
            ];
            $val = validator::make($request->all(),$rulesForValidation);
            if ($val->fails()){
                Session::flash('error_message',$val->errors()->first());
                return redirect()->back();
            }
            Jobs::where('id',$id)->Update([
                'job_title'=>$request->job_title,
                'job_location'=>$request->job_location,
                'job_description'=>$request->job_description,
            ]);
            if ($request->hasFile('images')) { // check if there is a image file present in the postman request
                $dataImg=[];
                foreach($request->file('images') as $file)
                {
                    if($file->extension() === 'jpeg' or $file->extension() === 'jpg' or $file->extension() === 'png' or $file->extension() === 'svg')
                    {    
                        $name = 'job_image_' . mt_rand(10, 1000) . '.' . $file->extension();
                        $dataImg[] = $name;
                        $file->move(public_path() . '/jobs/job_id-'.$request->id, $name);
                        
                    }
                    else{
                        Session::flash('error_message','Images uploading process failed !!! The image must be of JPEG, PNG or SVG format');
                    }
                }
                foreach(explode(',',Jobs::find($id)->images) as $img){
                    $images[]=$img;
                }
                $new = array_merge($dataImg,$images);//make new array
                Jobs::where('id',$id)->update(['images'=>implode(",",$new)]);// convert that array into strings and put it into database
            }
            Session::flash('success_message','The job is edited successfully');
            // return redirect('admin/Jobs/alljobs');
            return redirect()->back(); // temporary adjustment
            
        }
        else{
            return view('admin.sections.editjob')->with(compact('data'));
        }
    }
    // job image crud -- delete the job image
    public function jobImageDelete($id,$name){
        $jobDetails = Jobs::find($id);
        // dd($name);
        // dd($jobDetails->images);
        foreach( explode(',',$jobDetails->images) as $img ){
            if ($img === $name){
                unlink('jobs/job_id-'.$id.'/'.$name); // delete the image file from the folder
                $targetElement = array_search( $name , explode(',',$jobDetails->images) );
            }
            elseif ($img == null ){
            break;
            }
        }
        $images =  explode(',',$jobDetails->images);
        unset($images[$targetElement]);
        Jobs::where('id',$id)->update(['images'=>implode(',',$images)]);
        // return redirect('/admin/Jobs/Jobs-list');
        Session::flash('success_message','The job image is deleted successfully');
        return redirect()->back();

    }

    public function viewJobDetails($id){
        // dd($id);
        $provider_data = DB::table('users')
                    ->join('user_details', 'user_details.user_id', '=', 'users.id')
                    ->join('providers','providers.user_id','=','user_details.user_id')
                    ->where('providers.user_id',Jobs::find($id)->provider_id)
                    ->select('users.first_name','users.last_name','users.email','users.account_number','users.phone_no','users.role','users.is_blocked','users.address','providers.*','user_details.image')
                    ->first();
        $consumer_data = DB::table('users')
                    ->join('user_details', 'user_details.user_id', '=', 'users.id')
                    ->join('consumers','consumers.user_id','=','user_details.user_id')
                    ->where('consumers.user_id',Jobs::find($id)->consumer_id)
                    ->select('users.first_name','users.last_name','users.email','users.phone_no','users.role','users.is_blocked','users.address','consumers.*','user_details.image')
                    ->first();
        $job_data = Jobs::find($id);
        // dd(Jobs::find($id)->provider_id);
        // dd($consumer_data);
        return view('admin.sections.viewjob')->with(compact('provider_data','consumer_data','job_data'));
    }
    public function deleteJob($id){
        $path = 'jobs/job_id-'.$id;  // delete the directory of the image associated with the id
        // dd(Jobs::find($id)->images);
        $jobDetails = Jobs::find($id);
        if(Jobs::find($id)->images != null){
            foreach( explode(',',$jobDetails->images) as $img ){
                if ($img == null ){
                    break;
                }
                else{
                    unlink('jobs/job_id-'.$id.'/'.$img); // delete the image file from the folder
                }
            }
        }
        // else{
        //     Jobs::find($id)->delete();
        // }
        Jobs::find($id)->delete();
        Session::flash('success_message','The job is deleted successfully');
        return redirect()->back();
    }
}
