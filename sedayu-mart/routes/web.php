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
use App\Http\Controllers\Admin\DashboardAdminController;

/*
* USER CONTROLLERS
*/
use App\Http\Controllers\User\DashboardUserController;
use App\Http\Controllers\User\ProdukUserController;
use App\Http\Controllers\User\KeranjangUserController;
use App\Http\Controllers\User\PesananUserController;
use App\Http\Controllers\User\ProfilUserController;

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
    });
});

/*
* USER ROUTES
*/
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::prefix('user')->group(function () {
        // Dashboard
        Route::get('/', [DashboardUserController::class, 'index'])->name('user.dashboard');

        // Produk
        Route::get('/produk', [ProdukUserController::class, 'index'])->name('user.produk.index');

        // Keranjang
        Route::get('/keranjang', [KeranjangUserController::class, 'index'])->name('user.keranjang.index');

        // Pesanan
        Route::get('/pesanan', [PesananUserController::class, 'index'])->name('user.pesanan.index');

        // Profil
        Route::get('/profil', [ProfilUserController::class, 'index'])->name('user.profil.index');
    });
});
