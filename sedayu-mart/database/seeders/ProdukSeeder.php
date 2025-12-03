<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [
            [
            'nama' => 'Keripik Jagung',
            'harga' => 15000,
            'berat' => 250, // gram
            'stok' => 100,
            'satuan_produk' => 'Pcs',
            'deskripsi' => 'Keripik jagung renyah khas Desa Brenggolo, dibuat dari jagung pilihan yang diproses secara tradisional untuk mempertahankan cita rasa alami. Setiap keping digoreng hingga garing dengan bumbu rahasia yang menambahkan rasa gurih dan sedikit manis. Produk ini cocok sebagai camilan untuk keluarga dan teman, mudah dibawa saat bepergian. Dikemas secara higienis sehingga tahan lama dan mempertahankan kerenyahan.',
            ],
            [
            'nama' => 'Kopi Brenggolo',
            'harga' => 35000,
            'berat' => 200, // gram
            'stok' => 50,
            'satuan_produk' => 'Pcs',
            'deskripsi' => 'Kopi asli Desa Brenggolo dengan cita rasa khas dan aroma kuat. Biji kopi dipetik secara selektif dari petani lokal dan diolah dengan metode tradisional untuk menjaga kualitas. Memiliki profil rasa cokelat dan karamel dengan aftertaste yang lembut dan seimbang. Cocok diseduh dengan berbagai metode seperti manual brew atau espresso untuk mendapatkan rasa optimal.',
            ],
            [
            'nama' => 'Bawang Goreng',
            'harga' => 18000,
            'berat' => 150, // gram
            'stok' => 80,
            'satuan_produk' => 'Pcs',
            'deskripsi' => 'Bawang goreng renyah dan gurih produksi UMKM Brenggolo, dibuat dari bawang merah segar pilihan. Diolah dengan teknik penggorengan yang menjaga warna keemasan dan menghasilkan tekstur renyah tanpa berminyak. Sangat cocok sebagai taburan pada nasi, mie, atau lauk pauk untuk menambah cita rasa. Dikemas rapi untuk menjaga kesegaran dan dapat disimpan dalam suhu ruang untuk konsumsi sehari hari.',
            ],
        ];

        foreach ($data as $item) {
            Produk::updateOrCreate(
                ['nama' => $item['nama']],
                $item
            );
        }
    }
}
