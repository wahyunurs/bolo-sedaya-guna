import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                
                // Auth
                'resources/js/auth/login.js',
                'resources/js/auth/register.js',
                
                // Guest
                'resources/js/guest/navbar.js',
                
                // User - Produk
                'resources/js/user/produk/index.js',
                'resources/js/user/produk/detail.js',
                'resources/js/user/produk/show-modal.js',
                'resources/js/user/produk/tambah-keranjang.js',
                'resources/js/user/produk/beli-sekarang.js',
                'resources/js/user/produk/checkout.js',
                'resources/js/user/produk/edit-alamat.js',
                
                // User - Keranjang
                'resources/js/user/keranjang/index.js',
                'resources/js/user/keranjang/konfirmasi-hapus.js',
                
                // User - Pesanan
                'resources/js/user/pesanan/konfirmasi-hapus.js',
                'resources/js/user/pesanan/edit-pesanan.js',
                
                // Admin - Index
                'resources/js/admin/index.js',
                
                // Admin - Produk
                'resources/js/admin/produk/index.js',
                'resources/js/admin/produk/create.js',
                'resources/js/admin/produk/edit.js',
                'resources/js/admin/produk/show-modal.js',
                'resources/js/admin/produk/konfirmasi-hapus.js',
                
                // Admin - Pesanan
                'resources/js/admin/pesanan/index.js',
                'resources/js/admin/pesanan/show-modal.js',
                'resources/js/admin/pesanan/verifikasi-modal.js',
                'resources/js/admin/pesanan/update-status.js',
                
                // Admin - Pengguna
                'resources/js/admin/pengguna/index.js',
                'resources/js/admin/pengguna/show-modal.js',
                
                // Admin - Rekening
                'resources/js/admin/rekening/index.js',
                'resources/js/admin/rekening/create-modal.js',
                'resources/js/admin/rekening/edit-modal.js',
                'resources/js/admin/rekening/konfirmasi-hapus.js',
                
                // Admin - Tarif Pengiriman
                'resources/js/admin/tarif_pengiriman/index.js',
                'resources/js/admin/tarif_pengiriman/create-modal.js',
                'resources/js/admin/tarif_pengiriman/edit-modal.js',
                'resources/js/admin/tarif_pengiriman/konfirmasi-hapus.js',
                
                // Admin - Profil
                'resources/js/admin/profil/index.js',
            ],
            refresh: true,
        }),
    ],
});
