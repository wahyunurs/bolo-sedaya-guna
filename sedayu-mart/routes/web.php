<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
* GUEST CONTROLLERS
*/
use App\Http\Controllers\Guest\GuestController;

/*
* ADMIN CONTROLLERS
*/
use App\Http\Controllers\User\ProdukUserController;

/*
* USER CONTROLLERS
*/
use App\Http\Controllers\User\ProfilUserController;
use App\Http\Controllers\User\BerandaUserController;
use App\Http\Controllers\User\PesananUserController;
use App\Http\Controllers\Admin\ProfilAdminController;
use App\Http\Controllers\User\KeranjangUserController;
use App\Http\Controllers\Admin\DashboardAdminController;

require __DIR__ . '/auth.php';

/*
* GUEST ROUTES
*/
Route::get('/', [GuestController::class, 'beranda'])->name('guest.beranda');
Route::get('/produk', [GuestController::class, 'produk'])->name('guest.produk');
Route::get('/tentang', [GuestController::class, 'tentang'])->name('guest.tentang');
Route::get('/kontak', [GuestController::class, 'kontak'])->name('guest.kontak');

/*
* ADMIN ROUTES
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        // Dashboard
        Route::get('/', [DashboardAdminController::class, 'index'])->name('admin.dashboard');

        // Profil
        Route::get('/profil', [ProfilAdminController::class, 'index'])->name('admin.profil.index');
    });
});

/*
* USER ROUTES
*/
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::prefix('user')->group(function () {

        // Beranda
        Route::get('/', [BerandaUserController::class, 'index'])->name('user.beranda');

        // Produk
        Route::prefix('produk')->group(function () {

            Route::get('/checkout', [ProdukUserController::class, 'checkout'])
                ->name('user.produk.checkout');

            Route::post('/bayar-sekarang', [ProdukUserController::class, 'bayarSekarang'])
                ->name('user.produk.bayarSekarang');

            Route::post('/beli-sekarang', [ProdukUserController::class, 'beliSekarang'])
                ->name('user.produk.beliSekarang');

            Route::get('/', [ProdukUserController::class, 'index'])
                ->name('user.produk.index');

            Route::get('/detail/{id}', [ProdukUserController::class, 'detail'])
                ->name('user.produk.detail');

            Route::post('/tambah-keranjang', [ProdukUserController::class, 'tambahKeranjang'])
                ->name('user.produk.tambahKeranjang');
        });

        // Keranjang
        Route::get('/keranjang', [KeranjangUserController::class, 'index'])
            ->name('user.keranjang.index');

        // Pesanan
        Route::get('/pesanan', [PesananUserController::class, 'index'])
            ->name('user.pesanan.index');

        // Profil
        Route::get('/profil', [ProfilUserController::class, 'index'])
            ->name('user.profil.index');
    });
});
