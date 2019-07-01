<?php

/*
|--------------------------------------------------------------------------
| Routes AccountGroup
|--------------------------------------------------------------------------
|
*/

Route::group(['namespace' => 'Zent\AccountGroup\Http\Controllers', 'middleware' => ['locale', 'activity']], function () {

    /**
     * Group route admin.
     */
    Route::group(['prefix' => 'admin'], function () {

        Route::prefix('account_group')->group(function () {
            Route::post('get_list_account_group', 'AccountGroupController@getListAccountGroup')->name('account_group.getListAccountGroup');

            Route::post('count_account', 'AccountGroupController@countAccount')->name('account_group.countAccount');

            Route::post('change_password', 'AccountGroupController@changePassword')->name('account_group.changePassword');
            Route::post('get_info_change_password', 'AccountGroupController@getInfoPassword')->name('account_group.getInfoPassword');
            Route::get('account/{id}', 'AccountGroupController@listAccount')->name('account_group.listAccount');

            Route::get('account/{group_id}/create', 'AccountGroupController@createAccount')->name('account_group.createAccount');

            Route::get('download/{group_id}/{status}', array('as'=> 'download', 'uses' => 'AccountGroupController@download'));

        });

        Route::resource('account_group', 'AccountGroupController');
    });

    /**
     * Group route customer.
     */
    Route::group(['prefix' => 'home'], function () {
        Route::get('account_group', 'AccountGroupController@home')->name('accountGroup.home');
    });

});



