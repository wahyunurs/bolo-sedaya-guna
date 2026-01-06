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
                'varians',
            ])
                // hanya produk yang punya minimal satu varian stok >= 10
                ->whereHas('varians', function ($q) {
                    $q->where('stok', '>=', 10);
                });

            if ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            }

            $produks = $query->get()->map(function ($produk) {
                // Hitung total stok semua varian produk
                $totalStok = $produk->varians->sum('stok');
                // Cari varian default (is_default == 1)
                $varianDefault = $produk->varians->where('is_default', 1)->first();
                return [
                    'id'    => $produk->id,
                    'nama'  => $produk->nama,
                    'stok'  => $totalStok,
                    'satuan' => $produk->satuan_produk,
                    'gambar_utama' => $produk->gambarUtama ? 'storage/img/produk/' . $produk->gambarUtama->gambar : null,
                    'varian_default' => $varianDefault ? [
                        'id' => $varianDefault->id,
                        'nama' => $varianDefault->nama,
                        'harga' => $varianDefault->harga,
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
                'gambar_produks' => $produk->gambarProduks->map(function ($gambar) use ($produk) {
                    return [
                        'id' => $gambar->id,
                        'gambar' => $produk->gambarUtama ? 'storage/img/produk/' . $gambar->gambar : null,
                    ];
                }),
                'varians' => $produk->varians->map(function ($varian) {
                    return [
                        'id' => $varian->id,
                        'gambar' => $varian->gambar ? 'storage/img/varian/' . $varian->gambar : null,
                        'nama' => $varian->nama,
                        'harga' => $varian->harga,
                        'stok' => $varian->stok,
                        'is_default' => $varian->is_default,
                        'satuan' => $varian->produk->satuan_produk,
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
            $batasStok = $varian->stok - 10;

            $keranjang = Keranjang::where('user_id', $user->id)
                ->where('produk_id', $produkId)
                ->where('varian_id', $varianId)
                ->first();

            if ($keranjang) {
                $kuantitasTotal = $keranjang->kuantitas + $kuantitas;
                if ($kuantitasTotal > $varian->stok || $kuantitasTotal > $batasStok) {
                    $e = new \Exception('Stok tidak mencukupi');
                    return $this->exceptionError($e, 'Stok tidak mencukupi', 400);
                }
                $keranjang->kuantitas = $kuantitasTotal;
                $keranjang->subtotal = $keranjang->subtotal + ($kuantitas * $varian->harga);
                $keranjang->save();
            } else {
                if ($kuantitas > $varian->stok || $kuantitas > $batasStok) {
                    $e = new \Exception('Stok tidak mencukupi');
                    return $this->exceptionError($e, 'Stok tidak mencukupi', 400);
                }
                Keranjang::create([
                    'user_id' => $user->id,
                    'produk_id' => $produkId,
                    'varian_id' => $varianId,
                    'kuantitas' => $kuantitas,
                    'subtotal' => $kuantitas * $varian->harga,
                ]);
            }

            $keranjangData = [
                'produk_id' => $produkId,
                'varian_id' => $varianId,
                'kuantitas' => $kuantitas,
                'subtotal' => $kuantitas * $varian->harga,
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

            $batasStok = $varian->stok - 10;
            if ($kuantitas > $varian->stok || $kuantitas > $batasStok) {
                $e = new \Exception('Stok tidak mencukupi');
                return $this->exceptionError($e, 'Stok tidak mencukupi', 400);
            }

            $subtotal = $kuantitas * $varian->harga;

            // Ambil alamat utama user
            $alamatUtama = $user->alamatPengiriman()->where('utama', true)->first();

            // Hitung berat produk (dalam gram, default 1000 jika null)
            $beratProduk = (int) ($varian->berat ?? 1000);
            $totalBeratGram = $beratProduk * $kuantitas;
            $totalBeratKg = (int) ceil($totalBeratGram / 1000);

            // Hitung ongkir
            $ongkir = 0;
            if ($alamatUtama) {
                $kabupaten = mb_strtolower(trim($alamatUtama->kabupaten));
                $tarif = TarifPengiriman::whereRaw('LOWER(TRIM(kabupaten)) = ?', [$kabupaten])->first();
                if ($tarif) {
                    $ongkir = (int) ($tarif->tarif_per_kg * $totalBeratKg);
                }
            }

            $totalBayar = $subtotal + $ongkir;

            $beliSekarangData = [
                'produk_id'   => $produkId,
                'nama_produk'  => $produk->nama,
                'satuan_produk' => $produk->satuan_produk,
                'varian_id'    => $varianId,
                'gambar_varian' => $varian->gambar ? 'storage/img/varian/' . $varian->gambar : null,
                'nama_varian'  => $varian->nama,
                'stok_varian'  => $varian->stok,
                'harga' => $varian->harga,
                'kuantitas' => $kuantitas,
                'berat_gram' => $totalBeratGram,
                'berat_kg' => $totalBeratKg,
                'subtotal' => $subtotal,
                'ongkir' => $ongkir,
                'total_bayar' => $totalBayar,
            ];

            return $this->successResponse([
                'beli_sekarang' => $beliSekarangData,
            ], 'Berhasil mengambil data beli sekarang');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }
}
