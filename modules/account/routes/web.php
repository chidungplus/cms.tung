<?php

/*
|--------------------------------------------------------------------------
| Routes Account
|--------------------------------------------------------------------------
|
*/

Route::group(['namespace' => 'Zent\Account\Http\Controllers', 'middleware' => ['locale', 'activity']], function () {

    /**
     * Group route admin.
     */
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('account', 'AccountController');

        Route::prefix('account')->group(function () {
            Route::post('get_list_account', 'AccountController@getListAccount')->name('account.getListAccount');
        });
    });

    /**
     * Group route customer.
     */
    Route::group(['prefix' => 'home'], function () {
        Route::get('account', 'AccountController@home')->name('account.home');
    });

});



