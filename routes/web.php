<?php
/*|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you c   an register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;

Route::get('/product/{id}', 'ProductController@show')->name('product');
Route::get('/', 'ProductController@get')->name('products');
Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/createProduct', 'ProductController@createShow')->name('createProductForm')->middleware('admin');///////
    Route::post('/createProduct', 'ProductController@create')->name('createProduct')->middleware('admin');//////////////
    Route::post('/leaveComment', 'ProductManagerController@createComment')->name('makeComment');
    Route::post('/rate', 'ProductManagerController@createRate')->name('makeRate');
    Route::post('/manageFavourites', 'ProductManagerController@manageFavourites')->name('manageFavourites');
    Route::post('/buyProduct', 'ProductManagerController@buy')->name('buyProduct');
});
Route::get('/filter', 'ProductController@filter')->name('filter');

Auth::routes([
    'verify' => true,
    'reset' => true
]);

Route::get('/home', 'HomeController@index')->name('home');
