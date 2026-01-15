<?php

use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('categories', [CategoryApiController::class, 'index']);

    Route::get('products', [ProductApiController::class, 'index']);
    Route::post('products', [ProductApiController::class, 'store']);
    Route::get('products/{product}', [ProductApiController::class, 'show']);
    Route::post('products/{product}', [ProductApiController::class, 'update']);
    Route::delete('products/{product}', [ProductApiController::class, 'destroy']);
});
