<?php

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

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

        Route::group(['prefix'=>'store','namespace'=>'Site'],function(){
            Route::get('/','StoreController@index')->name('store.index');
            Route::get('all-products','StoreController@allProducts')->name('store.all.products');
            Route::get('products/{id}','StoreController@ProductsOfCat')->name('store.cat.products');
            Route::get('product/details/{id}','StoreController@productDetails')->name('store.product.details');
        });



});
