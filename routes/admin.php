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


    Route::group(['namespace' => 'Dashboard', 'middleware' => 'auth:admin', 'prefix' => 'admin'], function () {

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
        Route::group(['prefix' => 'categories'], function () {
            Route::get('/{type}', 'MainCategoriesController@index')->name('admin.mainCategories');
            Route::get('{type}/create', 'MainCategoriesController@create')->name('admin.mainCategories.create');
            Route::post('{type}/store', 'MainCategoriesController@store')->name('admin.mainCategories.store');
            Route::get('{type}/edit/{id}', 'MainCategoriesController@edit')->name('admin.mainCategories.edit');
            Route::put('{type}/update/{id}', 'MainCategoriesController@update')->name('admin.mainCategories.update');
            Route::get('{type}/delete/{id}', 'MainCategoriesController@delete')->name('admin.mainCategories.delete');
        });
        Route::group(['prefix' => 'brands'], function () {
            Route::get('/', 'BrandsController@index')->name('admin.brands');
            Route::get('{create', 'BrandsController@create')->name('admin.brands.create');
            Route::post('store', 'BrandsController@store')->name('admin.brands.store');
            Route::get('edit/{id}', 'BrandsController@edit')->name('admin.brands.edit');
            Route::put('update/{id}', 'BrandsController@update')->name('admin.brands.update');
            Route::get('delete/{id}', 'BrandsController@delete')->name('admin.brands.delete');
        });
    });

    Route::group(['namespace' => 'Dashboard', 'middleware' => 'guest:admin', 'prefix' => 'admin'], function () {

        Route::get('/login', 'LoginController@loginPage')->name('admin.login');
        Route::post('/login', 'LoginController@postLogin')->name('admin.post.login');
    });


});
