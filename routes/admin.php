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
            Route::get('/', 'categoriesController@index')->name('admin.categories');
            Route::get('create', 'categoriesController@create')->name('admin.categories.create');
            Route::post('store', 'categoriesController@store')->name('admin.categories.store');
            Route::get('edit/{id}', 'categoriesController@edit')->name('admin.categories.edit');
            Route::put('update/{id}', 'categoriesController@update')->name('admin.categories.update');
            Route::get('delete/{id}', 'categoriesController@delete')->name('admin.categories.delete');
        });
        #################################### Brands routes ###############################################
        Route::group(['prefix' => 'brands'], function () {
            Route::get('/', 'BrandsController@index')->name('admin.brands');
            Route::get('{create', 'BrandsController@create')->name('admin.brands.create');
            Route::post('store', 'BrandsController@store')->name('admin.brands.store');
            Route::get('edit/{id}', 'BrandsController@edit')->name('admin.brands.edit');
            Route::put('update/{id}', 'BrandsController@update')->name('admin.brands.update');
            Route::get('delete/{id}', 'BrandsController@delete')->name('admin.brands.delete');
        });
        #################################### Tags routes ###############################################
        Route::group(['prefix' => 'tags'], function () {
            Route::get('/', 'TagsController@index')->name('admin.tags');
            Route::get('create', 'TagsController@create')->name('admin.tags.create');
            Route::post('store', 'TagsController@store')->name('admin.tags.store');
            Route::get('edit/{id}', 'TagsController@edit')->name('admin.tags.edit');
            Route::put('update/{id}', 'TagsController@update')->name('admin.tags.update');
            Route::get('delete/{id}', 'TagsController@delete')->name('admin.tags.delete');
        });
    });

    Route::group(['namespace' => 'Dashboard', 'middleware' => 'guest:admin', 'prefix' => 'admin'], function () {

        Route::get('/login', 'LoginController@loginPage')->name('admin.login');
        Route::post('/login', 'LoginController@postLogin')->name('admin.post.login');
    });


});
