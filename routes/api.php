<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/provider/signup','Api\UserController@ProviderSignup');
Route::post('/consumer/signup','Api\UserController@ConsumerSignup');
Route::namespace ('api')->group(function () {
	//USER CONTROLLER ROUTES
	Route::post("register/", "UserController@register");
	Route::post("login/", "UserController@login");
	Route::post("signup-with-phone-no/", "UserController@signupWithMobileNo");
	Route::post("verify-phone_no/", "UserController@verifyPhoneNo");
	Route::post("send_otp_again/", "UserController@sendAgain");
	Route::post("forgot-password", "ForgotPasswordController@sendResetLinkEmail");
	Route::post("get-profile", "UserController@getProfile");
	Route::post("update-profile", "UserController@updateProfile");
	Route::post("add-products", "ProductsController@addProducts");
	Route::get("get-available-catagories", "ProductsController@getAvailableCatagories");
	
});



Route::post('/provider/signup','Api\UserController@ProviderSignup');
Route::post('/consumer/signup','Api\UserController@ConsumerSignup');
Route::post('/provider/login-with-employee-id','Api\UserController@loginWithEmployeeID');

Route::group(['middleware' => ['userLogin']], function (){
    Route::post('login','Api\UserController@userLogin');
});
Route::post('forgot-password','Api\UserController@forgotPassword');
Route::post('change-password','Api\UserController@changePassword');
Route::post('update-phone','Api\UserController@updatePhoneNumber');
Route::post('update-email','Api\UserController@updateEmail');
Route::post('update-name','Api\UserController@updateName');
Route::post('fetch-profile','Api\UserController@fetchProfile');
Route::post('provider/update-profile','Api\UserController@updateProviderProfile');
Route::post('provider/update-profile/done-jobs-images','Api\UserController@updateDoneJobsImages');
Route::post('consumer/update-profile','Api\UserController@updateConsumerProfile');
Route::post('provider/my-schedule','Api\ProviderController@mySchedule');
Route::post('provider/scheduled-tasks','Api\ProviderController@scheduledTasks');
Route::post('provider/all-scheduled-tasks','Api\ProviderController@AllScheduledTasks');
#service category -- list of available service categories to a consumer added by admin
Route::post('consumer/service-category-add','Api\ConsumerController@consumerCategory'); 
Route::post('consumer/service-categories-list','Api\ConsumerController@fetchCategories'); 
#nearby service providers -- consumer screen
Route::post('consumer/upate-location','Api\ConsumerController@updateCurrentLocation');
Route::post('consumer/nearby-service-providers','Api\ConsumerController@nearbyServiceProviders');
#service provider info -- consumer screen
Route::post('consumer/service-providers-info','Api\ConsumerController@serviceProviderInfo');
#manage jobs -- consumer screen
Route::post('consumer/jobs/post-jobs','Api\ManageJobsController@postJobs');
Route::post('consumer/jobs/post-jobs/post-jobs-images','Api\ManageJobsController@updatePostJobsImages');
Route::post('consumer/jobs/fetch-proposed-jobs','Api\ManageJobsController@fetchProposedJobs');

Route::post('consumer/jobs/fetch-job-details','Api\ManageJobsController@fetchProposedJobDetails');
Route::post('consumer/manage-jobs/scheduled-jobs','Api\ManageJobsController@scheduledJobs');
Route::post('consumer/manage-jobs/done-jobs','Api\ManageJobsController@doneJobsConsumer');
Route::post('consumer/current-location','Api\ConsumerController@fetchCurrentLocation');
#new jobs request -- provider screen

