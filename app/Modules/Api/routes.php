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

    Route::group(['middleware' => 'jwt.auth', 'prefix' => 'api'], function () {
        Route::get('currency/forselect', 'CurrencyController@forselect');
        Route::patch('currency/{id}/restore', 'CurrencyController@restore');
        Route::get('customer/search', 'CustomerController@search');
        Route::patch('customer/{id}/restore', 'CustomerController@restore');
        Route::get('provider/search', 'ProviderController@search');
        Route::patch('provider/{id}/restore', 'ProviderController@restore');
        Route::patch('user/{id}/restore', 'UserController@restore');

        Route::resource('user', 'UserController', ['only' => ['index', 'store', 'update', 'show', 'destroy']]);
        Route::resource('currency', 'CurrencyController', ['only' => ['index', 'store', 'update', 'show', 'destroy']]);
        Route::resource('customer', 'CustomerController', ['only' => ['index', 'store', 'update', 'show', 'destroy']]);
        Route::resource('transaction', 'TransactionController', ['only' => ['index']]);
    });
});
