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
    Route::group(['middleware' => 'admin'],function(){
        // check the admin middleware before proceeding
        Route::get('dashboard','AdminController@dashboard');
        Route::get('logout','AdminController@adminLogout');
        Route::match(['get','post'],'settings/profile/change-password','AdminController@changePassword');
        Route::match(['get','post'],'settings/profile/update-profile','AdminController@updateProfile');
        Route::get('profile-settings','AdminController@profileSettings');

        // user management
        Route::get('users/all-users','AdminController@allUsers');
        Route::get('users/blocked-users','AdminController@blockedUsers');
        Route::get('users/block-user/{id?}','UserController@blockUser');
        Route::get('users/unblock-user/{id?}','UserController@unblockUser');
        Route::get('users/view-user/{id?}','UserController@viewUser');
        Route::get('users/view-user-orders/{id?}','OrdersController@viewUserOrders');

        // farms management
        Route::get('farms/all-farms','FarmController@allFarms');
        Route::get('farms/blocked-farms','FarmController@blockedFarms');
        Route::get('farms/block-farm/{id?}','FarmController@blockFarm');
        Route::get('farms/unblock-farm/{id?}','FarmController@unblockFarm');
        Route::get('farms/view-farm/{id?}','FarmController@viewFarm');
        Route::get('farms/view-farm-products/{id?}','FarmController@viewFarmProducts');
        Route::get('farms/view-driver-requests/{id?}','FarmController@viewDriverRequests');
        Route::get('farms/view-farm-products/view-product/{id?}','ProductController@viewProduct');

        // drivers management 
        Route::get('drivers/all-drivers','DriverController@allDrivers');
        Route::get('drivers/blocked-drivers','DriverController@blockedDrivers');
        Route::get('drivers/block-driver/{id?}','DriverController@blockDriver');
        Route::get('drivers/unblock-driver/{id?}','DriverController@unblockDriver');
        Route::get('drivers/view-driver/{id?}','DriverController@viewDriver');
        Route::get('drivers/driver-requests','DriverController@allDriverRequests');
        Route::match(['get','post'],'drivers/driver-requests/assign-driver/{id?}','DriverController@assignDriver');
        Route::get('drivers/driver-requests/remove-driver/{id?}','DriverController@removeDriver');
        
        // categories management 
        Route::get('categories/all-categories','AdminController@allCategories');
        Route::match(['get','post'],'categories/add-category','AdminController@addCategory');
        Route::match(['get','post'],'categories/edit-category/{id?}','AdminController@editCategory');
        Route::get('categories/delete-category/{id?}','AdminController@deleteCategory');
        Route::get('categories/set-category-active/{id?}','AdminController@setCategoryActive');
        Route::get('categories/set-category-inactive/{id?}','AdminController@setCategoryInactive');

        // subcategories management -- subcategories of universal categories is not in use for now
        // Route::get('categories/view-subcategories/{id?}','AdminController@viewSubcategories');
        // Route::get('categories/subcategories-list','AdminController@allSubcategories');
        // Route::match(['get','post'],'categories/add-subcategory/{id?}','AdminController@addSubcategory');
        // Route::match(['get','post'],'categories/edit-subcategory/{id?}','AdminController@editSubcategory');
        // Route::match(['get','post'],'subcategories/delete-subcategory/{id?}','AdminController@deleteSubcategory');

        // shop subcategories management 
        Route::get('shops/categories/view-subcategories/{id?}/{category_id?}','AdminController@viewSubcategories');
        Route::get('shops/categories/subcategories-list/{shop_id?}','AdminController@allSubcategories');
        Route::match(['get','post'],'shops/categories/add-subcategory/{id?}','AdminController@addSubcategory');
        Route::match(['get','post'],'shops/categories/edit-subcategory/{id?}','AdminController@editSubcategory');
        Route::match(['get','post'],'shops/subcategories/delete-subcategory/{id?}','AdminController@deleteSubcategory');

        // Bidding requests management
        Route::get('biddings/all-requests','BiddingController@allBiddingRequests');
        Route::get('biddings/approve-request/{id?}','BiddingController@approveBiddingRequest');
        Route::get('biddings/disapprove-request/{id?}','BiddingController@disapproveBiddingRequest');
        Route::get('biddings/bidding-details/{id?}','BiddingController@biddingDetails');

        // Products
        Route::get('products/all-farm-products','ProductController@allFarmProducts');
        Route::match(['get','post'],'products/add-product','ProductController@addProduct');
        Route::match(['get','post'],'products/update-product-price/{id?}','ProductController@updateProductPrice');
        Route::get('products/view-product/{id?}','ProductController@viewProduct');
        Route::get('products/product-price-updates/{id?}','ProductController@priceUpdates');
        Route::match(['get','post'],'products/price-filter/{id?}/{option?}','ProductController@priceFilter');
        Route::get('products/view-images/{id?}','ProductController@galary');
        Route::match(['get','post'],'products/add-products-via-csv','ProductController@addProductsViaCSV');
        
        // Orders management
        Route::get('orders/all-orders','OrdersController@allOrders');
        Route::get('orders/view-order/{id?}','OrdersController@viewOrder');
        Route::match(['get','post'],'orders/assign-driver/{id?}','DriverController@assignDriverToOrder');
        Route::match(['get','post'],'orders/remove-driver/{id?}','DriverController@removeDriverToOrder');

        // Verticals management
        Route::get('verticals/all-verticals','VerticalController@allVerticals');
        Route::match(['get','post'],'verticals/delete-vertical/{id?}','VerticalController@deleteVertical');
        Route::match(['get','post'],'verticals/edit-vertical/{id?}','VerticalController@editVertical');
        Route::match(['get','post'],'verticals/add-vertical','VerticalController@addVertical');
       

        // Cuisines management
        Route::get('cuisines/all-cuisines','CuisineController@allCuisines');
        Route::match(['get','post'],'cuisines/add-cuisines','CuisineController@addCuisine');
        Route::match(['get','post'],'cuisines/delete-cuisine/{id?}','CuisineController@deleteCuisine');
        Route::match(['get','post'],'cuisines/edit-cuisine/{id?}','CuisineController@editCuisine');
       
        


        // company ----> crud
        Route::get('companies/companies-list','CompanyController@allCompanies');
        Route::get('companies/inactive-companies-list','CompanyController@inactiveCompanies');
        Route::match(['get','post'],'companies/add-company','CompanyController@addCompany');
        Route::get('companies/view-company/{id?}','CompanyController@viewCompany');
        Route::get('companies/set-company-inactive/{id?}','CompanyController@setCompanyInactive');
        Route::get('companies/set-company-active/{id?}','CompanyController@setCompanyActive');
        Route::get('companies/view-company-shops/{id?}','CompanyController@viewCompanyShops');
        Route::get('companies/view-shop/{id?}','ShopController@viewShop');
        Route::match(['get','post'],'companies/edit-company/{id?}','CompanyController@editCompany');
        Route::match(['get','post'],'companies/delete-company/{id?}','CompanyController@deleteCompany');
        Route::match(['get','post'],'companies/add-company-shop/{id?}','CompanyController@addCompanyShop');
        Route::match(['get','post'],'companies/edit-company-shop/{id?}','ShopController@editShop');

        //shops 
        Route::get('shops/shops-list','ShopController@allShops');
        Route::get('shops/inactive-shops-list','ShopController@inactiveShops');
        Route::get('shops/view-shop/{id?}','ShopController@viewShop');
        Route::get('shops/shop-menu/{id?}','ShopController@shopMenu');
        Route::get('shops/view-shop-branches/{id?}','ShopController@viewShopBranches');
        Route::get('shops/view-shop-products/{shop_id?}/{category_id?}','ShopController@viewShopProducts');
        Route::match(['get','post'],'shops/edit-shop/{id?}','ShopController@editShop');
        Route::match(['get','post'],'shops/add-shop-category/{id?}','ShopController@addShopCategory');
        Route::match(['get','post'],'shops/delete-shop/{id?}','ShopController@deleteShop');
        Route::get('shops/set-shop-inactive/{id?}','ShopController@setShopInactive');
        Route::get('shops/set-shop-active/{id?}','ShopController@setShopActive');
        Route::get('shops/set-shop-category-active/{id?}','ShopController@setShopCategoryActive');
        Route::get('shops/set-shop-category-inactive/{id?}','ShopController@setShopCategoryInactive');
        Route::match(['get','post'],'shops/add-shop','ShopController@addShops');
        Route::match(['get','post'],'shops/link-shop-with-company/{shop_id?}','ShopController@linkCompany');

        // Configurations
        Route::get('shops/view-configurations/{shop_id?}','AdminController@viewConfigurations');

        //branches
        Route::get('branches/branches-list','BranchController@allBranches');
        Route::get('branches/inactive-branches-list','BranchController@inactiveBranches');
        Route::get('branches/set-branch-inactive/{id?}','BranchController@setBranchInactive');
        Route::get('branches/set-branch-active/{id?}','BranchController@setBranchActive');
        Route::match(['get','post'],'branches/add-branch','BranchController@addBranch');
        Route::match(['get','post'],'branches/edit-branch/{id?}','BranchController@editBranch');
        
        // Coupons management
        Route::match(['get','post'],'coupons/create-coupon','CouponController@createCoupon');
       
        Route::match(['get','post'],'coupons/get-coupon','CouponController@GetCoupon');
        Route::match(['get','post'],'coupons/get-coupon-details','CouponController@GetCouponById');
        Route::match(['get','post'],'coupons/delete-coupon/{id?}','CouponController@deleteCoupon');
        Route::match(['get','post'],'coupons/update-coupon/{id?}','CouponController@updateCoupon');
        Route::match(['get','post'],'coupons/active-coupon/{id?}','CouponController@ActiveCoupon');

        // mahsool farm management
        Route::get('mahsool/shop-menu','MahsoolController@shopMenu');
        Route::get('mahsool/categories/subcategories-list/{shop_id?}','AdminController@allSubcategories');
        Route::get('mahsool/view-configurations/{shop_id?}','AdminController@viewConfigurations');
        Route::get('mahsool/view-shop-products/{shop_id?}/{category_id?}','ShopController@viewShopProducts');
        Route::get('mahsool/categories/view-subcategories/{id?}/{category_id?}','AdminController@viewSubcategories');
        Route::match(['get','post'],'mahsool/edit-shop-category/{id?}','MahsoolController@editCategory');
        Route::match(['get','post'],'mahsool/set-shop-category-inactive/{id?}','ShopController@setShopCategoryInactive');
        Route::match(['get','post'],'mahsool/set-shop-category-active/{id?}','ShopController@setShopCategoryActive');
        Route::get('/best-seller-list','MahsoolController@BestSellerLists');
        Route::get('/best-seller-add','MahsoolController@BestSeller');
        Route::match(['get', 'post'],'/remove-best-seller/{id?}','MahsoolController@RemoveBestSeller');

        // product documents 
        Route::match(['get','post'],'companies/product/add-product-document/{id?}','DocumentMgmtController@addProductDocument');
        Route::match(['get','post'],'companies/product/delete-product-document/{id?}','DocumentMgmtController@deleteProductDocument');
        Route::match(['get','post'],'companies/product/document-list/{id?}','DocumentMgmtController@productDocumentList');
        // change admin pannel language

        Route::group(['middleware'=>'CheckLang'], function(){
            Route::get('set-lang/{lang?}','AdminController@changeLang');
        });
        
    });

});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');