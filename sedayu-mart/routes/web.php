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
        Route::prefix('keranjang')->group(function () {
            Route::get('/', [KeranjangUserController::class, 'index'])
                ->name('user.keranjang.index');
            Route::post('/select-destroy', [KeranjangUserController::class, 'selectDestroy'])
                ->name('user.keranjang.selectDestroy');
            Route::post('/update', [KeranjangUserController::class, 'update'])
                ->name('user.keranjang.update');
            Route::delete('/destroy/{id}', [KeranjangUserController::class, 'destroy'])
                ->name('user.keranjang.destroy');
            Route::post('/checkout', [KeranjangUserController::class, 'checkout'])
                ->name('user.keranjang.checkout');
        });

        // Pesanan
        Route::prefix('pesanan')->group(function () {
            Route::get('/', [PesananUserController::class, 'index'])
                ->name('user.pesanan.index');
            Route::post('/select-destroy', [PesananUserController::class, 'selectDestroy'])
                ->name('user.pesanan.selectDestroy');
            Route::delete('/destroy/{id}', [PesananUserController::class, 'destroy'])
                ->name('user.pesanan.destroy');
            Route::get('/{id}', [PesananUserController::class, 'show'])
                ->name('user.pesanan.show');
            // Edit pesanan (show edit form)
            Route::get('/{id}/edit', [PesananUserController::class, 'edit'])
                ->name('user.pesanan.edit');
            // Update pesanan (address, bukti_pembayaran, catatan, item quantities)
            Route::put('/{id}', [PesananUserController::class, 'update'])
                ->name('user.pesanan.update');
        });

        // Profil
        Route::prefix('profil')->group(function () {
            Route::get('/edit', [ProfilUserController::class, 'edit'])
                ->name('user.profil.edit');
            Route::put('/update', [ProfilUserController::class, 'update'])
                ->name('user.profil.update');
            Route::get('/', [ProfilUserController::class, 'index'])
                ->name('user.profil.index');
        });
    });
});