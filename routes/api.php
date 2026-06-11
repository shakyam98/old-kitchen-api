<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\CustomerAuthController;
use App\Http\Controllers\Api\V1\Auth\StaffAuthController;
use App\Http\Controllers\Api\V1\StaffController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/health', function () {
        return response()->json([
            'status' => 'OK',
        ]);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/debug-token', [AuthController::class, 'debugToken']);
    });

    Route::prefix('customer')->group(function () {
        Route::post('/send-otp', [CustomerAuthController::class, 'sendOtp']);
        Route::post('/verify-otp', [CustomerAuthController::class, 'verifyOtp']);
    });

    Route::prefix('staff')->group(function () {
        Route::post('/login', [StaffAuthController::class, 'login']);
        Route::middleware('auth:sanctum')->group(function () {
            Route::middleware([
                'role:admin,manager',
            ])->group(function () {
                Route::get('', [StaffController::class, 'index']);
                Route::post('/create', [StaffController::class, 'store']);
            });
            Route::get('/{user}', [StaffController::class, 'show']);
            Route::put('/{user}', [StaffController::class, 'update']);
            Route::middleware([
                'role:admin,manager',
            ])->group(function () {
                Route::patch('/{user}/status', [StaffController::class, 'updateStatus']);
            });
        });
    });
});
