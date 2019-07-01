<?php

/*
|--------------------------------------------------------------------------
| Routes Customer
|--------------------------------------------------------------------------
|
*/

Route::group(['namespace' => 'Zent\Customer\Http\Controllers', 'middleware' => ['locale', 'activity']], function () {

    /**
     * Group route admin.
     */
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('customer', 'CustomerController');

        Route::prefix('customer')->group(function () {
            Route::post('get_list_customer', 'CustomerController@getListCustomer')->name('customer.getListCustomer');
        });
    });

    /**
     * Group route customer.
     */
    Route::group(['prefix' => 'home'], function () {
        Route::get('customer', 'CustomerController@home')->name('customer.home');
    });

});



