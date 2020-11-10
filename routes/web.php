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

        Route::group(['namespace'=>'Site'],function(){
            Route::get('/','LandingPageController@index')->name('landing.page');
            Route::group(['prefix'=>'shop'],function(){
                    Route::get('/','ShopController@index')->name('shop.all');
                    Route::get('category/{category}','ShopController@ProductsOfCat')->name('store.cat.products');
                    Route::get('/{product}','ShopController@show')->name('shop.show.one');
            });
                Route::get('cart','CartController@index')->name('cart.index');
                Route::post('cart','CartController@store')->name('cart.store');
                Route::delete('cart/{product}','CartController@destroy')->name('cart.destroy');
                Route::post('cart/saveForLater/{product}','CartController@switchToSaveForLater')->name('cart.save.later');

                Route::delete('saveForLater/{product}','saveForLaterController@destroy')->name('saveForLater.destroy');
                Route::post('saveForLater/moveToCart/{product}','saveForLaterController@switchToCart')->name('saveForLater.move.to.cart');

                Route::get('checkout','CheckoutController@index')->name('checkout.index');

        });








            Route::get('empty',function (){Cart::instance('saveForLater')->destroy();});




});
