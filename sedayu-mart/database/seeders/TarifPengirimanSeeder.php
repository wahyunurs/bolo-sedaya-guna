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
            ['kabupaten' => 'Kab. Wonogiri',       'tarif_per_kg' => 10000],
            ['kabupaten' => 'Kab. Sukoharjo',     'tarif_per_kg' => 11000],
            ['kabupaten' => 'Kab. Karanganyar',   'tarif_per_kg' => 11000],
            ['kabupaten' => 'Kab. Sragen',        'tarif_per_kg' => 12000],
            ['kabupaten' => 'Kab. Ngawi',         'tarif_per_kg' => 13000],
            ['kabupaten' => 'Kab. Boyolali',      'tarif_per_kg' => 10000],
            ['kabupaten' => 'Kab. Klaten',        'tarif_per_kg' => 10000],
            ['kabupaten' => 'Kab. Semarang',      'tarif_per_kg' => 14000],
            ['kabupaten' => 'Kota Semarang',      'tarif_per_kg' => 13000],
            ['kabupaten' => 'Kab. Demak',         'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kab. Pati',          'tarif_per_kg' => 16000],
            ['kabupaten' => 'Kab. Jepara',        'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kab. Kudus',         'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kota Surakarta',     'tarif_per_kg' => 12000],
            ['kabupaten' => 'Kab. Magelang',       'tarif_per_kg' => 12000],
            ['kabupaten' => 'Kota Magelang',       'tarif_per_kg' => 12000],
            ['kabupaten' => 'Kab. Temanggung',    'tarif_per_kg' => 13000],
            ['kabupaten' => 'Kab. Wonosobo',      'tarif_per_kg' => 14000],
            ['kabupaten' => 'Kab. Purworejo',     'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kab. Kebumen',       'tarif_per_kg' => 16000],
            ['kabupaten' => 'Kab. Banyumas',      'tarif_per_kg' => 17000],
            ['kabupaten' => 'Kota Pekalongan',    'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kab. Pekalongan',    'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kota Tegal',         'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kab. Tegal',         'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kab. Brebes',        'tarif_per_kg' => 16000],
        ];

        foreach ($data as $row) {
            TarifPengiriman::updateOrCreate(
                ['kabupaten' => $row['kabupaten']],
                ['tarif_per_kg' => $row['tarif_per_kg']]
            );
        }
    }
}
