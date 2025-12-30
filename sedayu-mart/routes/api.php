<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Mobile\BerandaController;
use App\Http\Controllers\Api\Mobile\Auth\AuthController;
use App\Http\Controllers\Api\Mobile\OnboardingController;

Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome to Sedayu Mart Mobile API',
        'status' => 'success',
    ]);
});

/*
* MOBILE API ROUTES
*/
Route::prefix('mobile')->group(function () {
    // Auth routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/login-google', [AuthController::class, 'loginGoogle']);

    Route::middleware('auth:sanctum')->group(function () {

        // ONBOARDING (BISA DIAKSES USER BELUM ONBOARDED)
        Route::get('/onboarding', [OnboardingController::class, 'index']);
        Route::post('/onboarding', [OnboardingController::class, 'store']);

        // PROTECTED ROUTES (WAJIB ONBOARDED)
        Route::middleware('onboarded.api')->group(function () {

            // Beranda
            Route::prefix('beranda')->group(function () {
                Route::get('/welcome', [BerandaController::class, 'welcome']);
                Route::get('/produk', [BerandaController::class, 'produk']);
            });

            // Logout
            Route::post('/logout', [AuthController::class, 'logout']);
        });
    });
});
