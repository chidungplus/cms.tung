<?php

/*
|--------------------------------------------------------------------------
| Routes Module
|--------------------------------------------------------------------------
|
*/

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Zent\Module\Http\Controllers', 'middleware' => ['locale', 'activity']], function () {

    /**
     * Group route admin.
     */
    Route::prefix('admin')->group(function () {
        Route::resource('module', 'ModuleController')->except(['create']);
        Route::post('/module/get-list', 'ModuleController@getList')->name('module.get-list');
    });

    /**
     * Group route customer.
     */
    Route::prefix('home')->group(function () {
        Route::get('module', 'ModuleController@home')->name('module.home');
    });
});



