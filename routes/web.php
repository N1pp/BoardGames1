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
    Route::group(['middleware' => 'admin'], function() {
        Route::get('/admin','AdminController@index')->name('admin');
        Route::get('/admin/createProduct', 'ProductController@createShow')->name('createProductForm');
        Route::post('/admin/createProduct', 'ProductController@create')->name('createProduct');
        Route::get('/admin/editProduct', 'ProductController@editShow')->name('editProductForm');
        Route::post('/admin/editProduct', 'ProductController@edit')->name('editProduct');
        Route::post('/admin/deleteProduct', 'ProductController@delete')->name('deleteProduct');
        Route::post('/admin/addAmount', 'ProductController@add')->name('addAmount');
        Route::get('/admin/showComments','AdminController@showComments')->name('showComments');
        Route::post('/admin/deleteComment','AdminController@deleteComment')->name('deleteComment');
        Route::get('/admin/statistics/product','AdminController@showProductStatistics')->name('showProductStatistics');
    });
    Route::post('/leaveComment', 'ProductManagerController@createComment')->name('makeComment');
    Route::post('/rate', 'ProductManagerController@createRate')->name('makeRate');
    Route::post('/manageFavourites', 'ProductManagerController@manageFavourites')->name('manageFavourites');
    Route::post('/buyProduct', 'ProductManagerController@buy')->name('buyProduct');
    Route::post('/add','ProductManagerController@addToCart')->name('add');
    Route::post('/remove','ProductManagerController@removeFromCart')->name('remove');
});
Route::get('/filter', 'ProductController@filter')->name('filter');


Auth::routes([
    'verify' => true,
]);

Route::get('/home', 'HomeController@index')->name('home');
