<?php

/*
|--------------------------------------------------------------------------
| Routes Role
|--------------------------------------------------------------------------
|
*/

Route::group(['namespace' => 'Zent\Role\Http\Controllers', 'middleware' => ['locale', 'activity']], function () {

    /**
     * Group route admin.
     */
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('role', 'RoleController');

        Route::post('role/get-list-role', 'RoleController@getListRole')->name('role.getListRole');

        Route::get('role/permission/{role}', 'RoleController@permissionRole')->name('role.permissionRole');

        Route::post('role/get-list-permission', 'RoleController@getListPermissionRole')->name('role.getListPermissionRole');

        Route::post('role/update-permission-role', 'RoleController@updatePermissionRole')->name('role.updatePermissionRole');
    });

    /**
     * Group route customer.
     */
    Route::group(['prefix' => 'home'], function () {
        Route::get('role', 'RoleController@home')->name('role.home');
    });

});



