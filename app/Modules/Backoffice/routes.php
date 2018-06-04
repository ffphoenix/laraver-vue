<?php

Route::group(['namespace' => 'Backoffice\Controllers'], function () {
    Route::post('auth/login', 'AuthController@login');
    Route::post('auth/logout', 'AuthController@logout');
    Route::post('auth/refresh', 'AuthController@refresh');
    Route::group(['middleware' => 'jwt.auth'], function(){
        Route::get('auth/user', 'AuthController@user');
    });

    Route::group(['middleware' => 'jwt.refresh'], function(){
        Route::get('auth/refresh', 'AuthController@refresh');
    });

    Route::group(['middleware' => 'jwt.auth', 'prefix' => 'bapi'], function () {
        Route::get('currency/forselect', 'CurrencyController@forselect');
        Route::patch('currency/{id}/restore', 'CurrencyController@restore');
        Route::get('customer/search', 'CustomerController@search');
        Route::patch('customer/{id}/restore', 'CustomerController@restore');
        Route::patch('user/{id}/restore', 'UserController@restore');

        Route::resource('user', 'UserController', ['only' => ['index', 'store', 'update', 'show', 'destroy']]);
        Route::resource('currency', 'CurrencyController', ['only' => ['index', 'store', 'update', 'show', 'destroy']]);
        Route::resource('customer', 'CustomerController', ['only' => ['index', 'store', 'update', 'show', 'destroy']]);
        Route::resource('transaction', 'TransactionController', ['only' => ['index']]);
    });
});

Route::group(['namespace' => 'Backoffice\Controllers'], function () {
    Route::get('{all}', 'HomeController@index')->where('all', '(?!(api|bapi)\/).*');
});
