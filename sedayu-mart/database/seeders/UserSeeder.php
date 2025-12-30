<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update two admin users. Idempotent via updateOrCreate.

        $now = Carbon::now();

        $users = [
            [
                'email' => 'admin@gmail.com',
                'nama' => 'Admin Testing',
                'alamat' => 'Desa Brenggolo, Kecamatan Jatiroto, Kabupaten Wonogiri',
                'kabupaten' => 'Kab. Wonogiri',
                // 'provinsi' => 'Jawa Tengah',
                'nomor_telepon' => '089676843618',
                'role' => 'admin',
                'avatar' => null,
                'password' => Hash::make('password'),
                'status' => 'aktif',
                'onboarded' => true,
            ],
            [
                'email' => 'test@gmail.com',
                'nama' => 'User Testing',
                'alamat' => 'Desa Brenggolo, Kecamatan Jatiroto, Kabupaten Wonogiri',
                'kabupaten' => 'Kab. Wonogiri',
                // 'provinsi' => 'Jawa Tengah',
                'nomor_telepon' => '081212121212',
                'role' => 'user',
                'avatar' => null,
                'password' => Hash::make('password'),
                'status' => 'aktif',
                'onboarded' => true,
            ],
        ];

        DB::beginTransaction();
        try {
            foreach ($users as $user) {
                $user = User::updateOrCreate([
                    'email' => $user['email'],
                ], array_merge($user, [
                    'email_verified_at' => $now,
                    'google_id' => null,
                    'google_token' => null,
                    'google_refresh_token' => null,
                    'remember_token' => Str::random(10),
                ]));
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
