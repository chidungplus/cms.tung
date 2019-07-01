<?php

/*
|--------------------------------------------------------------------------
| Routes {Core}
|--------------------------------------------------------------------------
|
*/

Route::group(['namespace' => 'Zent\{Core}\Http\Controllers', 'middleware' => ['locale', 'activity']], function () {

    /**
     * Group route admin.
     */
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('{core_snake_case}', '{Core}Controller');

        Route::prefix('{core_snake_case}')->group(function () {
            Route::post('get_list_{core_snake_case}', '{Core}Controller@getList{Core}')->name('{core_snake_case}.getList{Core}');
        });
    });

    /**
     * Group route customer.
     */
    Route::group(['prefix' => 'home'], function () {
        Route::get('{core_snake_case}', '{Core}Controller@home')->name('{core}.home');
    });

});



