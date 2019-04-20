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
Route::post('/login','Auth\LoginController@adminLogin');
Route::get('/logout', 'Auth\LoginController@logout');

// ADMIN ONLY ROUTES
Route::group(['middleware' => 'is.admin'], function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', 'AdminController@index');
        Route::resource('/dataadmin', 'AdminController');
    });
});

// GUEST ONLY ROUTES
Route::group(['middleware' => 'is.guest'], function () {
    Route::get('/verify-user/{code}', 'Auth\RegisterController@activateUser')->name('activate.user');
    Route::get('/viewlogin','Auth\LoginController@viewLogin')->name('viewlogin');
});
