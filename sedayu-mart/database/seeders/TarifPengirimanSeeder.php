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
            ['kabupaten' => 'Kabupaten Wonogiri',       'tarif_per_kg' => 10000],
            ['kabupaten' => 'Kabupaten Sukoharjo',     'tarif_per_kg' => 11000],
            ['kabupaten' => 'Kabupaten Karanganyar',   'tarif_per_kg' => 11000],
            ['kabupaten' => 'Kabupaten Sragen',        'tarif_per_kg' => 12000],
            ['kabupaten' => 'Kabupaten Ngawi',         'tarif_per_kg' => 13000],
            ['kabupaten' => 'Kabupaten Boyolali',      'tarif_per_kg' => 10000],
            ['kabupaten' => 'Kabupaten Klaten',        'tarif_per_kg' => 10000],
            ['kabupaten' => 'Kabupaten Semarang',      'tarif_per_kg' => 14000],
            ['kabupaten' => 'Kota Semarang',      'tarif_per_kg' => 13000],
            ['kabupaten' => 'Kabupaten Demak',         'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kabupaten Pati',          'tarif_per_kg' => 16000],
            ['kabupaten' => 'Kabupaten Jepara',        'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kabupaten Kudus',         'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kota Surakarta',     'tarif_per_kg' => 12000],
            ['kabupaten' => 'Kabupaten Magelang',       'tarif_per_kg' => 12000],
            ['kabupaten' => 'Kota Magelang',       'tarif_per_kg' => 12000],
            ['kabupaten' => 'Kabupaten Temanggung',    'tarif_per_kg' => 13000],
            ['kabupaten' => 'Kabupaten Wonosobo',      'tarif_per_kg' => 14000],
            ['kabupaten' => 'Kabupaten Purworejo',     'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kabupaten Kebumen',       'tarif_per_kg' => 16000],
            ['kabupaten' => 'Kabupaten Banyumas',      'tarif_per_kg' => 17000],
            ['kabupaten' => 'Kota Pekalongan',    'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kabupaten Pekalongan',    'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kota Tegal',         'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kabupaten Tegal',         'tarif_per_kg' => 15000],
            ['kabupaten' => 'Kabupaten Brebes',        'tarif_per_kg' => 16000],
        ];

        foreach ($data as $row) {
            TarifPengiriman::updateOrCreate(
                ['kabupaten' => $row['kabupaten']],
                ['tarif_per_kg' => $row['tarif_per_kg']]
            );
        }
    }
}
