<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you c   an register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/product/{id}', 'ProductController@show')->name('product');
Route::get('/', 'ProductController@get');
Route::post('/create', 'ProductController@create')->name('createProduct');
Auth::routes();

Route::post('');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/createProduct', 'ProductController@createShow');
    Route::post('/leaveComment', 'ProductManagerController@createComment')->name('makeComment');
    Route::post('/rate', 'ProductManagerController@createRate')->name('makeRate');
    Route::post('/manageFavourites','ProductManagerController@manageFavourites')->name('manageFavourites');
    Route::post('/buyProduct','ProductManagerController@buy')->name('buyProduct');
});
//TODO Изучить роуты авторизации
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
