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
