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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::post('/login','Auth\LoginController@adminLogin');
Route::get('/logout', 'Auth\LoginController@logout');
// Route::get('/admin', 'AdminController@index');

Route::group(['middleware' => 'is.admin'], function () {
    Route::get('/admin', 'AdminController@index');
});

Route::group(['middleware' => 'is.guest'], function () {
    Route::get('/verify-user/{code}', 'Auth\RegisterController@activateUser')->name('activate.user');
    Route::post('/viewlogin','Auth\LoginController@viewLogin');
});
