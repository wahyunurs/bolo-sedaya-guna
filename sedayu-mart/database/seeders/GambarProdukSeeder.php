<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Produk;
use App\Models\GambarProduk;

class GambarProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua produk
        $produkList = Produk::all();

        foreach ($produkList as $produk) {
            GambarProduk::where('produk_id', $produk->id)->delete();

            // Buat 3 gambar untuk setiap produk
            $gambarData = [
                [
                    'produk_id' => $produk->id,
                    'gambar' => "{$produk->id}_1.png",
                    'utama' => 1,
                ],
                [
                    'produk_id' => $produk->id,
                    'gambar' => "{$produk->id}_2.png",
                    'utama' => 0,
                ],
                [
                    'produk_id' => $produk->id,
                    'gambar' => "{$produk->id}_3.png",
                    'utama' => 0,
                ],
            ];

            foreach ($gambarData as $gambar) {
                GambarProduk::create($gambar);
            }
        }
    }
}
