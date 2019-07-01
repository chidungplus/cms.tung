<?php

/*
|--------------------------------------------------------------------------
| Routes SystemLog
|--------------------------------------------------------------------------
|
*/

Route::group(['namespace' => 'Zent\SystemLog\Http\Controllers', 'middleware' => ['locale', 'activity']], function () {

    /**
     * Group route admin.
     */
    Route::group(['prefix' => 'admin'], function () {
//        Route::resource('system_log', 'SystemLogController');
//
//        Route::prefix('system_log')->group(function () {
//            Route::post('get-list-system_log', 'SystemLogController@getListSystemLog')->name('system_log.getListSystemLog');
//        });

        Route::get('system_log', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('system_log.index')->middleware('auth.user');
    });

    /**
     * Group route customer.
     */
    Route::group(['prefix' => 'home'], function () {
        Route::get('system_log', 'SystemLogController@home')->name('systemLog.home');
    });

});



