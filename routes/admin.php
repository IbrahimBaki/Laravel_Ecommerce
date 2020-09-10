<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// All Admin Route Has Default [[        Prefix=> 'admin'        ]] In RouteServiceProvider.php

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {


    Route::group(['namespace' => 'Dashboard', 'middleware' => 'auth:admin' , 'prefix' => 'admin'], function () {

        Route::get('/', 'DashboardController@index')->name('admin.dashboard');//the first page admin visit if authenticated
        Route::get('/logout', 'LoginController@logout')->name('admin.logout');



        Route::group(['prefix' => 'settings'], function () {
            Route::get('shipping-methods/{type}', 'SettingsController@editShippingMethods')->name('edit.shipping.methods');
            Route::put('shipping-methods/{id}', 'SettingsController@updateShippingMethods')->name('update.shipping.methods');
        });
        Route::group(['prefix' => 'profile'], function () {
            Route::get('edit', 'ProfileController@editProfile')->name('edit.profile');
            Route::put('update/{id}', 'ProfileController@updateProfile')->name('update.profile');
        });

        #################################### Main-categories routes ###############################################
        Route::group(['prefix' => 'categories'],function(){
            Route::get('/{type}','MainCategoriesController@index')->name('admin.mainCategories');
            Route::get('{type}/create','MainCategoriesController@create')->name('admin.mainCategories.create');
            Route::post('{type}/store','MainCategoriesController@store')->name('admin.mainCategories.store');
            Route::get('{type}/edit/{id}','MainCategoriesController@edit')->name('admin.mainCategories.edit');
            Route::put('{type}/update/{id}','MainCategoriesController@update')->name('admin.mainCategories.update');
            Route::get('{type}/delete/{id}','MainCategoriesController@delete')->name('admin.mainCategories.delete');
        });
#################################### Sub-categories routes ###############################################
        Route::group(['prefix' => 'sub_categories'],function(){
            Route::get('/','SubCategoriesController@index')->name('admin.subCategories');
            Route::get('create','SubCategoriesController@create')->name('admin.subCategories.create');
            Route::post('store','SubCategoriesController@store')->name('admin.subCategories.store');
            Route::get('edit/{id}','SubCategoriesController@edit')->name('admin.subCategories.edit');
            Route::put('update/{id}','SubCategoriesController@update')->name('admin.subCategories.update');
            Route::get('delete/{id}','SubCategoriesController@delete')->name('admin.subCategories.delete');
        });


    });

    Route::group(['namespace' => 'Dashboard', 'middleware' => 'guest:admin' , 'prefix' => 'admin'], function () {

        Route::get('/login', 'LoginController@loginPage')->name('admin.login');
        Route::post('/login', 'LoginController@postLogin')->name('admin.post.login');
    });


});
