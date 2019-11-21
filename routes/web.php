<?php
use \App\Http\Controllers\ProductController;
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
Route::get('/product/{id}', 'ProductController@show');
Route::get('/','ProductController@get');
Route::get('/createProduct','ProductController@createShow');
Route::post('/create','ProductController@create')->name('createProduct');
Auth::routes();

Route::get('/home', 'HomeCont roller@index')->name('home');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
