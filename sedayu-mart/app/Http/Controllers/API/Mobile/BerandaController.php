<?php

namespace App\Http\Controllers\API\Mobile;

use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    /**
     * Tampilan banner selamat datang di beranda mobile
     */
    public function welcome(Request $request)
    {
        try {
            $welcome = "Selamat Datang";
            $userName = Auth::user()->nama;

            return $this->successResponse([
                'welcome_message' => $welcome,
                'user_name' => $userName,
            ], 'Berhasil mengambil data banner welcome');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }


    /**
     * Tampilkan produk di beranda mobile
     */
    public function produk(Request $request)
    {
        try {
            $user = $request->user();

            $search = $request->query('search');

            $query = Produk::with([
                'gambarProduks' => function ($q) {
                    $q->where('utama', 1)->limit(1);
                }
            ]);

            // 🔍 Search
            if ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            }

            $produks = $query->get()->map(function ($produk) {
                return [
                    'id'    => $produk->id,
                    'nama'  => $produk->nama,
                    'harga' => $produk->harga,
                    'stok'  => $produk->stok,
                    'gambar_utama' => optional($produk->gambarProduks->first())->url,
                ];
            });

            return $this->successResponse([
                'user' => [
                    'id'   => $user->id,
                    'nama' => $user->nama,
                ],
                'search'  => $search,
                'produk'  => $produks,
            ], 'Berhasil mengambil data produk');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }
}
