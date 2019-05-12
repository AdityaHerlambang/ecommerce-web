<?php

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

//MAIN
Route::get('/', 'HomeController@index')->name('home');

//AUTH ROUTES
Auth::routes();
Route::get('/loginadmin','Auth\LoginController@viewAdminLogin');
Route::post('/login','Auth\LoginController@userLogin');
Route::post('/adminlogin','Auth\LoginController@adminLogin');
Route::get('/logout', 'Auth\LoginController@logout');

//STORE ROUTES
Route::get('/category/{id}','HomeController@pageCategory');
Route::get('/product/{id}','HomeController@pageProduct');

//TRANSACTION
Route::get('/transaction','TransactionController@index');
Route::get('/transaction/{id}','TransactionController@transactionDetail');
Route::get('/transaction/{id}/{userid}','TransactionController@transactionDetailAdmin');
Route::post('/transactionsubmitproof','TransactionController@submitProof');

// USER ONLY ROUTES
Route::group(['middleware' => 'is.user'], function () {

    //CART
    Route::resource('/cart','CartController');
    Route::get('/cart/{id}/delete','CartController@destroy');
    Route::get('/cancelcart','CartController@cancel');

    //CHECKOUT
    Route::get('/checkout','CheckoutController@index');
    Route::get('/updatetocheckout','CartController@updateToCheckout');
    Route::get('/checkout/getcity','CheckoutController@city');
    Route::get('/checkout/getshippingcost','CheckoutController@shippingCost');
    Route::post('/checkout/submit','CheckoutController@store');

    Route::post('/review/submit','ReviewController@submitReview');


});

// ADMIN ONLY ROUTES
Route::group(['middleware' => 'is.admin'], function () {

    Route::post('/response/submit','ReviewController@submitResponse');

    Route::prefix('admin')->group(function () {

        Route::get('/', 'DashboardController@index');
        Route::resource('/dataadmin', 'AdminController');
        Route::resource('/productcategory', 'ProductsCategoryController');
        Route::resource('/courier', 'CourierController');
        Route::resource('/product', 'ProductController');
        Route::post('/product/image/delete', 'ProductController@destroyImage');

        Route::get('/product/discount/{id}/index','DiscountController@index');
        Route::resource('/product/discount', 'DiscountController',['except' => 'index']);

        Route::get('/transaction','TransactionController@adminView');
        Route::get('/transaction/{id}','TransactionController@showTransaction');
        Route::put('/transaction/{id}','TransactionController@updateStatus');

    });
});

// GUEST ONLY ROUTES
Route::group(['middleware' => 'is.guest'], function () {
    Route::get('/verify-user/{code}', 'Auth\RegisterController@activateUser')->name('activate.user');
    Route::get('/viewlogin','Auth\LoginController@viewLogin')->name('viewlogin');
});
