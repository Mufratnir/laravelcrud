<?php

use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [RegisterController::class, 'login']);

Route::post('/forgot-password', [ForgotPasswordController::class, 'forgot']);
Route::post('/reset-password', [ForgotPasswordController::class, 'reset']);

Route::get('/verify-email/{token}', [EmailVerificationController::class, 'verifyEmail']);

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (SANCTUM)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [RegisterController::class, 'logout']);

    Route::post('/email/resend', [EmailVerificationController::class, 'resend']);

    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/unread', [NotificationController::class, 'unread']);
    Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);


    Route::prefix('v1')->group(function () {

        Route::get('categories', [CategoryApiController::class, 'index']);

        Route::get('products', [ProductApiController::class, 'index']);
        Route::post('products', [ProductApiController::class, 'store']);
        Route::get('products/{product}', [ProductApiController::class, 'show']);
        Route::post('products/{product}', [ProductApiController::class, 'update']);
        Route::delete('products/{product}', [ProductApiController::class, 'destroy']);
    });
});