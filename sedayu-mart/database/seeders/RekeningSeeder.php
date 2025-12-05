<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rekening;

class RekeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rekening::create([
            'nama_bank' => 'Bank Rakyat Indonesia (BRI)',
            'nomor_rekening' => '1234567890',
            'atas_nama' => 'PT Sedayu Mart',
        ]);

        Rekening::create([
            'nama_bank' => 'Bank Negara Indonesia (BNI)',
            'nomor_rekening' => '987654321',
            'atas_nama' => 'Sedayu Store',
        ]);

        Rekening::create([
            'nama_bank' => 'DANA',
            'nomor_rekening' => '0812345678',
            'atas_nama' => 'CV Sedayu Jaya',
        ]);
    }
}
