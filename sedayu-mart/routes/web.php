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
use App\Http\Controllers\User\OnboardingController;
use App\Http\Controllers\User\ProdukUserController;
use App\Http\Controllers\User\ProfilUserController;
use App\Http\Controllers\User\BerandaUserController;
use App\Http\Controllers\User\PesananUserController;
use App\Http\Controllers\Admin\ProdukAdminController;
use App\Http\Controllers\Admin\ProfilAdminController;
use App\Http\Controllers\Admin\PesananAdminController;

/*
* USER CONTROLLERS
*/
use App\Http\Controllers\User\KeranjangUserController;
use App\Http\Controllers\Admin\PenggunaAdminController;
use App\Http\Controllers\Admin\RekeningAdminController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\TarifPengirimanAdminController;

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

        // Pengguna
        Route::prefix('pengguna')->group(function () {
            Route::get('/', [PenggunaAdminController::class, 'index'])->name('admin.pengguna.index');
            Route::get('/{id}', [PenggunaAdminController::class, 'show'])->name('admin.pengguna.show');
        });

        // Produk
        Route::prefix('produk')->group(function () {
            Route::get('/', [ProdukAdminController::class, 'index'])->name('admin.produk.index');
            Route::get('/show/{id}', [ProdukAdminController::class, 'show'])->name('admin.produk.show');
            Route::get('/create', [ProdukAdminController::class, 'create'])->name('admin.produk.create');
            Route::post('/store', [ProdukAdminController::class, 'store'])->name('admin.produk.store');
            Route::get('/edit/{id}', [ProdukAdminController::class, 'edit'])->name('admin.produk.edit');
            Route::put('/update/{id}', [ProdukAdminController::class, 'update'])->name('admin.produk.update');
            Route::delete('/destroy/{id}', [ProdukAdminController::class, 'destroy'])->name('admin.produk.destroy');

            // Varian Produk
            Route::prefix('varian-produk')->group(function () {
                Route::get('/{produkId}/varian', [ProdukAdminController::class, 'indexVarian'])->name('admin.produk.varian.index');
                Route::post('/{produkId}/varian', [ProdukAdminController::class, 'storeVarian'])->name('admin.produk.varian.store');
                Route::put('/{produkId}/varian/{varianId}', [ProdukAdminController::class, 'updateVarian'])->name('admin.produk.varian.update');
                Route::delete('/{produkId}/varian/{varianId}', [ProdukAdminController::class, 'destroyVarian'])->name('admin.produk.varian.destroy');
            });
        });

        // Pesanan
        Route::prefix('pesanan')->group(function () {
            Route::get('/', [PesananAdminController::class, 'index'])->name('admin.pesanan.index');
            Route::get('/show/{id}', [PesananAdminController::class, 'show'])->name('admin.pesanan.show');
            Route::get('/verifikasi/{id}', [PesananAdminController::class, 'showVerifikasi'])->name('admin.pesanan.showVerifikasi');
            Route::post('/verifikasi/{id}', [PesananAdminController::class, 'verifikasi'])->name('admin.pesanan.verifikasi');
            Route::get('/update-status/{id}', [PesananAdminController::class, 'showUpdateStatus'])->name('admin.pesanan.showUpdateStatus');
            Route::post('/update-status/{id}', [PesananAdminController::class, 'updateStatus'])->name('admin.pesanan.updateStatus');
        });

        // Tarif Pengiriman
        Route::prefix('tarif-pengiriman')->group(function () {
            Route::get('/', [TarifPengirimanAdminController::class, 'index'])->name('admin.tarifPengiriman.index');
            Route::get('/edit/{id}', [TarifPengirimanAdminController::class, 'edit'])->name('admin.tarifPengiriman.edit');
            Route::post('/store', [TarifPengirimanAdminController::class, 'store'])->name('admin.tarifPengiriman.store');
            Route::put('/update/{id}', [TarifPengirimanAdminController::class, 'update'])->name('admin.tarifPengiriman.update');
            Route::delete('/destroy/{id}', [TarifPengirimanAdminController::class, 'destroy'])->name('admin.tarifPengiriman.destroy');
        });

        // Rekening
        Route::prefix('rekening')->group(function () {
            Route::get('/', [RekeningAdminController::class, 'index'])->name('admin.rekening.index');
            Route::post('/store', [RekeningAdminController::class, 'store'])->name('admin.rekening.store');
            Route::get('/edit/{id}', [RekeningAdminController::class, 'edit'])->name('admin.rekening.edit');
            Route::put('/update/{id}', [RekeningAdminController::class, 'update'])->name('admin.rekening.update');
            Route::delete('/destroy/{id}', [RekeningAdminController::class, 'destroy'])->name('admin.rekening.destroy');
        });

        // Profil
        Route::prefix('profil')->group(function () {
            Route::get('/', [ProfilAdminController::class, 'index'])->name('admin.profil.index');
            Route::get('/edit', [ProfilAdminController::class, 'edit'])->name('admin.profil.edit');
            Route::put('/update', [ProfilAdminController::class, 'update'])->name('admin.profil.update');
        });
    });
});

/*
* USER ROUTES
*/
Route::middleware(['auth', 'role:user'])->group(function () {
    // Onboarding
    Route::prefix('onboarding')->group(function () {

        // 1️⃣ Tampilkan form onboarding
        Route::get('/', [OnboardingController::class, 'index'])
            ->name('user.onboarding');

        // 2️⃣ Submit data onboarding
        Route::post('/', [OnboardingController::class, 'store'])
            ->name('user.onboarding.store');
    });

    Route::middleware('onboarded.web')->group(function () {
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
                Route::get('/checkout', [KeranjangUserController::class, 'checkout'])
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

                // Profil Menu
                Route::get('/', [ProfilUserController::class, 'index'])
                    ->name('user.profil.index');

                // Data Diri
                Route::prefix('data-diri')->group(function () {
                    Route::get('/', [ProfilUserController::class, 'dataDiri'])
                        ->name('user.profil.dataDiri');
                    Route::get('/edit', [ProfilUserController::class, 'editDataDiri'])
                        ->name('user.profil.dataDiri.edit');
                    Route::put('/update', [ProfilUserController::class, 'updateDataDiri'])
                        ->name('user.profil.dataDiri.update');
                });

                // Alamat Pengiriman
                Route::prefix('alamat-pengiriman')->group(function () {
                    Route::get('/', [ProfilUserController::class, 'alamatPengiriman'])
                        ->name('user.profil.alamatPengiriman');
                    Route::get('/create', [ProfilUserController::class, 'createAlamatPengiriman'])
                        ->name('user.profil.alamatPengiriman.create');
                    Route::post('/store', [ProfilUserController::class, 'storeAlamatPengiriman'])
                        ->name('user.profil.alamatPengiriman.store');
                    Route::get('/edit/{id}', [ProfilUserController::class, 'editAlamatPengiriman'])
                        ->name('user.profil.alamatPengiriman.edit');
                    Route::put('/update/{id}', [ProfilUserController::class, 'updateAlamatPengiriman'])
                        ->name('user.profil.alamatPengiriman.update');
                    Route::delete('/delete/{id}', [ProfilUserController::class, 'destroyAlamatPengiriman'])
                        ->name('user.profil.alamatPengiriman.destroy');
                });

                // Ganti Password
                Route::prefix('ganti-password')->group(function () {
                    Route::get('/', [ProfilUserController::class, 'gantiPassword'])
                        ->name('user.profil.gantiPassword');
                    Route::put('/update', [ProfilUserController::class, 'updatePassword'])
                        ->name('user.profil.gantiPassword.update');
                });
            });
        });
    });
});
