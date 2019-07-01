<?php

/*
|--------------------------------------------------------------------------
| Routes Job
|--------------------------------------------------------------------------
|
*/

Route::group(['namespace' => 'Zent\Job\Http\Controllers', 'middleware' => ['locale', 'activity']], function () {

    /**
     * Group route admin.
     */
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('job', 'JobController');

        Route::prefix('job')->group(function () {
            Route::post('get_list_job', 'JobController@getListJob')->name('job.getListJob');
        });
    });

    /**
     * Group route customer.
     */
    Route::group(['prefix' => 'home'], function () {
        Route::get('job', 'JobController@home')->name('job.home');
    });

});



