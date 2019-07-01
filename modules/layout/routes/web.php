<?php

/*
|--------------------------------------------------------------------------
| Routes Layout
|--------------------------------------------------------------------------
|
*/

use Illuminate\Support\Facades\Route;

Route::group([ 'namespace' => 'Zent\Layout\Http\Controllers', 'middleware' => ['locale', 'activity']], function () {

    /**
     * Group route admin
     */
    Route::get('/', 'LayoutController@index')->name('layout.index');

    Route::group(['prefix' => 'admin'], function () {
        Route::get('', 'LayoutController@index')->name('layout.index');

        Route::get('change_language/{locale}', function ($locale) {
            \Session::put('language', $locale);
            return redirect()->back();
        })->name('layout.change_language');
    });


    /**
     * Group route customer
     */

    Route::prefix('home')->group(function () {
        Route::get('/', 'LayoutController@home')->name('layout.home');
    });
});



