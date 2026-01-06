<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Mobile\ProfilController;
use App\Http\Controllers\API\Mobile\BerandaController;
use App\Http\Controllers\API\Mobile\CheckoutController;
use App\Http\Controllers\API\Mobile\Auth\AuthController;
use App\Http\Controllers\API\Mobile\CheckoutKeranjangController;
use App\Http\Controllers\API\Mobile\KeranjangController;
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

            // Keranjang
            Route::prefix('keranjang')->group(function () {
                Route::get('/', [KeranjangController::class, 'index']);
                Route::put('/tambah-kuantitas/{keranjangId}', [KeranjangController::class, 'tambahKuantitas']);
                Route::put('/kurang-kuantitas/{keranjangId}', [KeranjangController::class, 'kurangKuantitas']);
                Route::delete('/hapus/{keranjangId}', [KeranjangController::class, 'hapus']);
                Route::delete('/hapus-semua', [KeranjangController::class, 'hapusSemua']);
                Route::post('/beli-sekarang', [KeranjangController::class, 'beliSekarang']);
                Route::post('/beli-semua', [KeranjangController::class, 'beliSekarangSemua']);

                // Checkout dari Keranjang
                Route::prefix('checkout')->group(function () {
                    Route::post('/', [CheckoutKeranjangController::class, 'checkout']);
                    Route::get('/alamat-utama', [CheckoutKeranjangController::class, 'alamatUtama']);
                    Route::get('/rekening-list', [CheckoutKeranjangController::class, 'rekeningList']);

                    // Alamat Pengiriman
                    Route::prefix('alamat-pengiriman')->group(function () {
                        Route::get('/', [CheckoutKeranjangController::class, 'alamatPengiriman']);
                        Route::get('/kabupaten-dropdown', [CheckoutKeranjangController::class, 'kabupatenDropdown']);
                        Route::post('/tambah', [CheckoutKeranjangController::class, 'tambahAlamatPengiriman']);
                        Route::put('/update/{alamatId}', [CheckoutKeranjangController::class, 'updateAlamatPengiriman']);
                        Route::delete('/hapus/{alamatId}', [CheckoutKeranjangController::class, 'hapusAlamatPengiriman']);
                        Route::post('/pilih/{alamatId}', [CheckoutKeranjangController::class, 'pilihAlamatPengiriman']);
                    });
                });
            });

            // Profil
            Route::prefix('profil')->group(function () {
                Route::get('/', [ProfilController::class, 'index']);
                Route::get('kabupaten-dropdown', [ProfilController::class, 'kabupatenDropdown']);

                // Edit Profil
                Route::prefix('edit-profil')->group(function () {
                    Route::get('/', [ProfilController::class, 'profil']);
                    Route::put('/update', [ProfilController::class, 'updateProfil']);
                });

                // Alamat Pengiriman
                Route::prefix('alamat-pengiriman')->group(function () {
                    Route::get('/', [ProfilController::class, 'alamatPengiriman']);
                    Route::put('/set-utama/{alamatId}', [ProfilController::class, 'setAlamatUtama']);
                    Route::post('/tambah', [ProfilController::class, 'tambahAlamatPengiriman']);
                    Route::put('/update/{alamatId}', [ProfilController::class, 'updateAlamatPengiriman']);
                    Route::delete('/hapus/{alamatId}', [ProfilController::class, 'hapusAlamatPengiriman']);
                });
            });

            // Logout
            Route::post('/logout', [AuthController::class, 'logout']);
        });
    });
});
