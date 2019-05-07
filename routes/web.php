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
Route::get('/viewadminlogin','Auth\LoginController@viewAdminLogin');
Route::post('/login','Auth\LoginController@userLogin');
Route::post('/adminlogin','Auth\LoginController@adminLogin');
Route::get('/logout', 'Auth\LoginController@logout');

//STORE ROUTES
Route::get('/category/{id}','HomeController@pageCategory');
Route::get('/product/{id}','HomeController@pageProduct');

//CART
Route::resource('/cart','CartController');

// ADMIN ONLY ROUTES
Route::group(['middleware' => 'is.admin'], function () {
    Route::prefix('admin')->group(function () {

        Route::get('/', 'AdminController@index');
        Route::resource('/dataadmin', 'AdminController');
        Route::resource('/productcategory', 'ProductsCategoryController');
        Route::resource('/courier', 'CourierController');
        Route::resource('/product', 'ProductController');
        Route::post('/product/image/delete', 'ProductController@destroyImage');

        Route::get('/product/discount/{id}/index','DiscountController@index');
        Route::resource('/product/discount', 'DiscountController',['except' => 'index']);

    });
});

// GUEST ONLY ROUTES
Route::group(['middleware' => 'is.guest'], function () {
    Route::get('/verify-user/{code}', 'Auth\RegisterController@activateUser')->name('activate.user');
    Route::get('/viewlogin','Auth\LoginController@viewLogin')->name('viewlogin');
});
