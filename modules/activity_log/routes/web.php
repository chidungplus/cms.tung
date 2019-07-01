<?php

/*
|--------------------------------------------------------------------------
| Routes ActivityLog
|--------------------------------------------------------------------------
|
*/

Route::group(['namespace' => 'Zent\ActivityLog\Http\Controllers', 'middleware' => ['locale']], function () {

    /**
     * Group route admin.
     */
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('activity_log', 'ActivityLogController');

        Route::prefix('activity_log')->group(function () {
            Route::post('get_list_activity_log', 'ActivityLogController@getListActivityLog')->name('activity_log.getListActivityLog');
        });
    });

    /**
     * Group route customer.
     */
    Route::group(['prefix' => 'home'], function () {
        Route::get('activity_log', 'ActivityLogController@home')->name('activityLog.home');
    });

});



