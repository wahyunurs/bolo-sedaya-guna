<?php

namespace App\Http\Controllers\API\Mobile;

use App\Models\Produk;
use App\Models\Varian;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AlamatPengiriman;
use App\Models\TarifPengiriman;
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
            $user = Auth::user();
            $search = $request->query('search');

            $query = Produk::with([
                'gambarUtama',
                'varians' => function ($q) {
                    $q->where('is_default', 1)->limit(1);
                },
            ])
                // hanya produk yang punya minimal satu varian stok >= 10
                ->whereHas('varians', function ($q) {
                    $q->where('stok', '>=', 10);
                });

            if ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            }

            $produks = $query->get()->map(function ($produk) {
                return [
                    'id'    => $produk->id,
                    'nama'  => $produk->nama,
                    'gambar_utama' => 'storage/img/produk/' . ($produk->gambarUtama ? $produk->gambarUtama->gambar : null),
                    'varian_default' => $produk->varians->first() ? [
                        'id' => $produk->varians->first()->id,
                        'nama' => $produk->varians->first()->nama,
                        'harga' => $produk->varians->first()->harga,
                        'stok' => $produk->varians->first()->stok,
                    ] : null,
                ];
            });

            if ($produks->isEmpty()) {
                return $this->successResponse([
                    'user' => [
                        'id'   => $user->id,
                        'nama' => $user->nama,
                    ],
                    'search'  => $search,
                    'produk'  => [],
                ], 'Produk tidak ditemukan');
            }

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

    public function detailProduk($id)
    {
        try {
            $user = Auth::user();

            $produk = Produk::with(['gambarProduks', 'varians'])->findOrFail($id);

            $produkData = [
                'id'    => $produk->id,
                'nama'  => $produk->nama,
                'deskripsi' => $produk->deskripsi,
                'gambar_produks' => $produk->gambarProduks->map(function ($gambar) {
                    return [
                        'id' => $gambar->id,
                        'gambar' => 'storage/img/produk/' . $gambar->gambar,
                    ];
                }),
                'varians' => $produk->varians->map(function ($varian) {
                    return [
                        'id' => $varian->id,
                        'gambar' => 'storage/img/varian/' . $varian->gambar,
                        'nama' => $varian->nama,
                        'harga' => $varian->harga,
                        'stok' => $varian->stok,
                    ];
                }),
            ];

            return $this->successResponse([
                'user' => [
                    'id'   => $user->id,
                    'nama' => $user->nama,
                ],
                'produk'  => $produkData,
            ], 'Berhasil mengambil data detail produk');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }

    public function tambahKeranjang(Request $request)
    {
        try {
            $user = Auth::user();

            // Validasi request
            $request->validate([
                'produk_id'  => 'required|integer|exists:produk,id',
                'varian_id' => 'required|integer|exists:varian,id',
                'kuantitas'    => 'required|integer|min:1',
            ]);

            $produkId = $request->produk_id;
            $varianId = $request->varian_id;
            $kuantitas = (int) $request->kuantitas;

            $varian = Varian::find($varianId);

            if ($varian->stok < $kuantitas) {
                return $this->successResponse([], 'Stok varian tidak mencukupi');
            }

            $subtotal = $kuantitas * $varian->harga;

            $keranjang = Keranjang::where('user_id', $user->id)
                ->where('produk_id', $produkId)
                ->where('varian_id', $varianId)
                ->first();

            if ($keranjang) {
                $keranjang->kuantitas = $keranjang->kuantitas + $kuantitas;
                $keranjang->subtotal = $keranjang->subtotal + $subtotal;
                $keranjang->save();
            } else {
                Keranjang::create([
                    'user_id' => $user->id,
                    'produk_id' => $produkId,
                    'varian_id' => $varianId,
                    'kuantitas' => $kuantitas,
                    'subtotal' => $subtotal,
                ]);
            }

            // Kurangi stok varian
            $varian->stok = max(0, $varian->stok - $kuantitas);
            $varian->save();

            $keranjangData = [
                'produk_id' => $produkId,
                'varian_id' => $varianId,
                'kuantitas' => $kuantitas,
                'subtotal' => $subtotal,
            ];

            return $this->successResponse([
                'user' => [
                    'id'   => $user->id,
                    'nama' => $user->nama,
                ],
                'keranjang' => $keranjangData,
            ], 'Berhasil menambahkan produk ke keranjang');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }

    public function beliSekarang(Request $request)
    {
        try {
            $user = Auth::user();

            // Validasi request
            $request->validate([
                'produk_id'  => 'required|integer|exists:produk,id',
                'varian_id' => 'required|integer|exists:varian,id',
                'kuantitas'    => 'required|integer|min:1',
            ]);

            $produkId = $request->produk_id;
            $varianId = $request->varian_id;
            $kuantitas = (int) $request->kuantitas;

            $produk = Produk::find($produkId);
            $varian = Varian::find($varianId);
            if ($varian->stok < $kuantitas) {
                return $this->successResponse([], 'Stok varian tidak mencukupi');
            }

            $subtotal = $kuantitas * $varian->harga;

            $beliSekarangData = [
                'produk' => [
                    'id'    => $produkId,
                    'nama'  => $produk->nama,
                    'satuan' => $produk->satuan,
                ],
                'varian' => [
                    'id'    => $varianId,
                    'nama'  => $varian->nama,
                    'harga' => $varian->harga,
                ],
                'kuantitas' => $kuantitas,
                'subtotal' => $subtotal,
            ];

            return $this->successResponse([
                'user' => [
                    'id'   => $user->id,
                    'nama' => $user->nama,
                ],
                'beli_sekarang' => $beliSekarangData,
            ], 'Berhasil mengambil data beli sekarang');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }
}
