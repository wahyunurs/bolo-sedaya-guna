<?php

namespace Database\Seeders;

use App\Models\TarifPengiriman;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TarifPengirimanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [
            // ===== SOLO RAYA =====
            ['kabupaten' => 'Kota Surakarta', 'tarif_per_kg' => 12000],
            ['kabupaten' => 'Kabupaten Boyolali', 'tarif_per_kg' => 10000],
            ['kabupaten' => 'Kabupaten Klaten', 'tarif_per_kg' => 10000],
            ['kabupaten' => 'Kabupaten Sukoharjo', 'tarif_per_kg' => 11000],
            ['kabupaten' => 'Kabupaten Karanganyar', 'tarif_per_kg' => 11000],
            ['kabupaten' => 'Kabupaten Sragen', 'tarif_per_kg' => 12000],
            ['kabupaten' => 'Kabupaten Wonogiri', 'tarif_per_kg' => 10000],

            // ===== SEMARANG & SEKITAR =====
            ['kabupaten' => 'Kota Semarang', 'tarif_per_kg' => 13000],
            ['kabupaten' => 'Kabupaten Semarang', 'tarif_per_kg' => 14000],
            ['kabupaten' => 'Kabupaten Demak', 'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kabupaten Kendal', 'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kota Salatiga', 'tarif_per_kg' => 13000],

            // ===== PATI RAYA =====
            ['kabupaten' => 'Kabupaten Pati', 'tarif_per_kg' => 16000],
            ['kabupaten' => 'Kabupaten Kudus', 'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kabupaten Jepara', 'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kabupaten Rembang', 'tarif_per_kg' => 16000],
            ['kabupaten' => 'Kabupaten Blora', 'tarif_per_kg' => 16000],

            // ===== KEDU =====
            ['kabupaten' => 'Kabupaten Magelang', 'tarif_per_kg' => 12000],
            ['kabupaten' => 'Kota Magelang', 'tarif_per_kg' => 12000],
            ['kabupaten' => 'Kabupaten Temanggung', 'tarif_per_kg' => 13000],
            ['kabupaten' => 'Kabupaten Wonosobo', 'tarif_per_kg' => 14000],
            ['kabupaten' => 'Kabupaten Purworejo', 'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kabupaten Kebumen', 'tarif_per_kg' => 16000],

            // ===== BANYUMAS RAYA =====
            ['kabupaten' => 'Kabupaten Banyumas', 'tarif_per_kg' => 17000],
            ['kabupaten' => 'Kabupaten Cilacap', 'tarif_per_kg' => 17000],
            ['kabupaten' => 'Kabupaten Purbalingga', 'tarif_per_kg' => 16000],
            ['kabupaten' => 'Kabupaten Banjarnegara', 'tarif_per_kg' => 16000],

            // ===== PEKALONGAN & TEGAL =====
            ['kabupaten' => 'Kota Pekalongan', 'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kabupaten Pekalongan', 'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kabupaten Batang', 'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kota Tegal', 'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kabupaten Tegal', 'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kabupaten Pemalang', 'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kabupaten Brebes', 'tarif_per_kg' => 16000],
        ];

        foreach ($data as $row) {
            TarifPengiriman::updateOrCreate(
                ['kabupaten' => $row['kabupaten']],
                ['tarif_per_kg' => $row['tarif_per_kg']]
            );
        }
    }
}
