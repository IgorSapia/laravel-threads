<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

Route::prefix('customer')->group(function () {
    Route::Post('/store', [CustomerController::class, 'store']);
    Route::get('/getAmount/{id}', [CustomerController::class, 'getAmount']);
    Route::Patch('/update/{id}', [CustomerController::class, 'update']);
});

