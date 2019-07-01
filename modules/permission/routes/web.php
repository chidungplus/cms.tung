<?php

/*
|--------------------------------------------------------------------------
| Routes Permission
|--------------------------------------------------------------------------
|
*/

Route::group(['namespace' => 'Zent\Permission\Http\Controllers', 'middleware' => ['locale', 'activity']], function () {

    /**
     * Group route admin.
     */
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('permission', 'PermissionController')->only(['index']);

        Route::post('permission/get-list-permission', 'PermissionController@getListPermission')->name('permission.getListPermission');
    });

    /**
     * Group route customer.
     */
    Route::group(['prefix' => 'home'], function () {
        Route::get('permission', 'PermissionController@home')->name('permission.home');
    });

});



