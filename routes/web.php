<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
/** Admin Login Route */
/** Admin auth Route */
/** Authenticated Admin Routes */
/**
 * ------------------------------------------------------------------------
 * ADMIN DEFINED ROUTES
 * ------------------------------------------------------------------------
 */
Route::prefix('admin')->namespace('Admin')->group(function(){
   
    Route::match(['get','post'],'login','AdminController@adminLogin');
    Route::group(['middleware' => ['admin']], function () {
        
        Route::get('dashboard', 'AdminController@dashboard');
       
        Route::get('logout', 'AdminController@logout');
        Route::match(['get', 'post'], 'settings/profile', 'AdminController@profileSettings');
        Route::post('settings/profile/update-profile', 'AdminController@updateProfile'); 
        Route::post('settings/profile/change-password', 'AdminController@changePassword');
        Route::get('users/all-users', 'UserController@allUsersData'); 
        Route::get('/users/user-management/block-user/{id?}', 'UserController@BlockUser'); 
        Route::get('/users/blocked-users', 'UserController@blockedUsersData'); 
        Route::get('/users/user-management/unblock-user/{id?}', 'UserController@UnblockUser'); 
        Route::get('users/view-user/{id?}', 'UserController@viewUserProfile');
        Route::match(['get', 'post'], 'providers/add-providers', 'ProviderController@addProvider');
        Route::get('providers/all-providers', 'ProviderController@allProvidersData');
        Route::get('providers/view-provider/{id?}', 'ProviderController@viewProviderProfile');
        Route::match(['get', 'post'], 'providers/edit-provider/{id?}', 'ProviderController@editProvider');
        Route::get('categories/all-categories', 'JobsMgmtController@allCategories');
        Route::match(['get', 'post'], 'categories/add-categories', 'JobsMgmtController@addCategories');
        Route::match(['get', 'post'], 'categories/edit-category/{id?}', 'JobsMgmtController@updateCategories');
        Route::get('categories/categories-management/delete-category/{id?}', 'JobsMgmtController@DeleteCategory');
        Route::match(['get', 'post'], 'consumers/add-consumer', 'ConsumerController@addConsumer');
        Route::get('consumers/all-consumers', 'ConsumerController@allConsumers');
        Route::get('consumers/view-consumer/{id?}', 'ConsumerController@viewConsumerProfile');
        Route::match(['get', 'post'], 'consumers/edit-consumer/{id?}', 'ConsumerController@editConsumer');
        Route::get('jobs/all-jobs', 'JobsMgmtController@allJobs');
        Route::match(['get', 'post'], 'jobs/edit-job/{id?}', 'JobsMgmtController@editJobs');
        Route::get('jobs/edit-job/delete-image/{id?}/{name?}', 'JobsMgmtController@jobImageDelete');
        Route::get('jobs/done-jobs', 'JobsMgmtController@doneJobs');
        Route::get('jobs/rejected-jobs', 'JobsMgmtController@rejectedJobs');
        Route::get('jobs/view-job/{id?}', 'JobsMgmtController@viewJobDetails');
        Route::get('jobs/delete-job/{id?}', 'JobsMgmtController@deleteJob');
        Route::match(['get', 'post'], 'companies/all-companies', 'ProviderController@allCompanies');
        Route::match(['get', 'post'], 'companies/add-company', 'ProviderController@addCompany');
        Route::match(['get', 'post'], 'companies/edit-company/{id?}', 'ProviderController@editCompany');
        Route::match(['get', 'post'], 'companies/company-management/delete-company/{id?}', 'ProviderController@deleteCompany');
        Route::match(['get', 'post'], 'companies/view-company/{id?}', 'ProviderController@viewCompany');
        Route::match(['get', 'post'], 'companies/view-company-employes/{id?}', 'ProviderController@viewCompanyEmployes');
        Route::match(['get', 'post'], 'providers/company-associated-providers/{id?}', 'ProviderController@viewCompanyEmployes');
        Route::match(['get', 'post'], 'providers/add-associated-providers/{company_id?}', 'ProviderController@addAssociatedProviders');
    });

});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');