<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Mobile\BerandaController;
use App\Http\Controllers\API\Mobile\Auth\AuthController;
use App\Http\Controllers\API\Mobile\CheckoutController;
use App\Http\Controllers\API\Mobile\OnboardingController;

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
                Route::get('/produk/{id}', [BerandaController::class, 'detailProduk']);
                Route::post('/keranjang', [BerandaController::class, 'tambahKeranjang']);
                Route::post('/beli-sekarang', [BerandaController::class, 'beliSekarang']);

                // Checkout
                Route::prefix('checkout')->group(function () {
                    Route::post('/', [CheckoutController::class, 'checkout']);
                    Route::get('/alamat-utama', [CheckoutController::class, 'alamatUtama']);
                    Route::get('/rekening-list', [CheckoutController::class, 'rekeningList']);

                    // Alamat Pengiriman
                    Route::prefix('alamat-pengiriman')->group(function () {
                        Route::get('/', [CheckoutController::class, 'alamatPengiriman']);
                        Route::get('/kabupaten-dropdown', [CheckoutController::class, 'kabupatenDropdown']);
                        Route::post('/tambah', [CheckoutController::class, 'tambahAlamatPengiriman']);
                        Route::put('/update/{alamatId}', [CheckoutController::class, 'updateAlamatPengiriman']);
                        Route::delete('/hapus/{alamatId}', [CheckoutController::class, 'hapusAlamatPengiriman']);
                        Route::post('/pilih/{alamatId}', [CheckoutController::class, 'pilihAlamatPengiriman']);
                    });
                });
            });

            // Logout
            Route::post('/logout', [AuthController::class, 'logout']);
        });
    });
});
