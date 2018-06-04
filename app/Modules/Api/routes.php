<?php

Route::group(['namespace' => 'Api\Controllers', 'prefix' => 'api'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::group(['middleware' => 'jwt.auth'], function(){
        Route::get('auth/user', 'AuthController@user');
    });

    Route::group(['middleware' => 'jwt.refresh'], function(){
        Route::get('auth/refresh', 'AuthController@refresh');
    });

    Route::group(['middleware' => ['api', 'jwt.auth']], function () {
        Route::post('customer', 'CustomerController@store');
        Route::post('transaction', 'TransactionController@store');
        Route::put('transaction/{id}', 'TransactionController@update');
        Route::delete('transaction/{id}', 'TransactionController@destroy');
    });

    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::get('transaction/{customerId}/{transactionId}', 'TransactionController@show');
        Route::get('transaction', 'TransactionController@list');
    });

});
