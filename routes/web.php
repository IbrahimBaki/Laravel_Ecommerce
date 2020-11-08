<?php

use Gloudemans\Shoppingcart\Facades\Cart;
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

        Route::get('/','Site\LandingPageController@index')->name('landing.page');

        Route::group(['prefix'=>'shop','namespace'=>'Site'],function(){
            Route::get('/','ShopController@index')->name('shop.all');
            Route::get('cat/{category}','ShopController@ProductsOfCat')->name('store.cat.products');
            Route::get('/{product}','ShopController@show')->name('shop.show.one');
        });
        Route::get('cart','Site\CartController@index')->name('cart.index');
        Route::post('cart','Site\CartController@store')->name('cart.store');
        Route::delete('cart/{product}','Site\CartController@destroy')->name('cart.destroy');

        Route::get('empty',function (){
            Cart::destroy();


        });




});
