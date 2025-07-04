<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    
    Route::group(['prefix' => 'customers'], function () {
        Route::get('/', \App\Http\Controllers\Api\Customer\ListController::class);
        Route::post('/', \App\Http\Controllers\Api\Customer\StoreController::class);
    });

    Route::group(['prefix' => 'invoices'], function () {
        Route::get('/', \App\Http\Controllers\Api\Invoice\ListController::class);
        Route::post('/', \App\Http\Controllers\Api\Invoice\StoreController::class);
    });
});
