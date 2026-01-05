<?php

namespace App\Http\Controllers\API\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = $user->keranjang()->with(['produk.gambarUtama', 'varian']);

        // Logic search by varian->nama or produk->nama
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('produk', function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%");
            })->orWhereHas('varian', function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%");
            });
        }

        $keranjangs = $query->get();

        if ($keranjangs->isEmpty()) {
            return $this->successResponse([], 'Item keranjang tidak ditemukan');
        }

        $keranjangData = $keranjangs->map(function ($keranjang) {
            $keterangan = null;
            if ($keranjang->varian && $keranjang->varian->stok <= 10) {
                $keterangan = 'Stok produk hampir habis';
            }

            return [
                'user' => [
                    'id' => $keranjang->user->id,
                    'nama' => $keranjang->user->nama,
                ],
                'id' => $keranjang->id,
                'produk' => [
                    'id' => $keranjang->produk->id,
                    'nama' => $keranjang->produk->nama,
                    'satuan_produk' => $keranjang->produk->satuan_produk,
                    'gambar_utama' => 'storage/img/produk/' . ($keranjang->produk->gambarUtama ? $keranjang->produk->gambarUtama->gambar : null),
                ],
                'varian' => [
                    'id' => $keranjang->varian->id,
                    'nama_varian' => $keranjang->varian->nama,
                    'harga' => $keranjang->varian->harga,
                ],
                'kuantitas' => $keranjang->kuantitas,
                'subtotal' => $keranjang->subtotal,
                'keterangan' => $keterangan,
            ];
        });

        return $this->successResponse($keranjangData, 'Berhasil mengambil data keranjang');
    }

    public function tambahKuantitas(Request $request, $keranjangId)
    {
        $user = Auth::user();

        $keranjang = $user->keranjang()->where('id', $keranjangId)->firstOrFail();


        $request->validate([
            'tambah' => 'required|integer|min:1',
        ]);

        $tambah = (int) $request->tambah;
        $kuantitasBaru = $keranjang->kuantitas + $tambah;
        $batasStok = $keranjang->varian->stok - 10;
        if ($kuantitasBaru > $batasStok) {
            $e = new \Exception('Stok tidak mencukupi');
            return $this->exceptionError($e, 'Stok tidak mencukupi', 400);
        }

        $keranjang->kuantitas = $kuantitasBaru;
        $keranjang->subtotal = $keranjang->varian->harga * $kuantitasBaru;
        $keranjang->save();

        $keranjangData = [
            'user' => [
                'id' => $keranjang->user->id,
                'nama' => $keranjang->user->nama,
            ],
            'id' => $keranjang->id,
            'produk' => [
                'id' => $keranjang->produk->id,
                'nama' => $keranjang->produk->nama,
                'satuan_produk' => $keranjang->produk->satuan_produk,
                'gambar_utama' => 'storage/img/produk/' . ($keranjang->produk->gambarUtama ? $keranjang->produk->gambarUtama->gambar : null),
            ],
            'varian' => [
                'id' => $keranjang->varian->id,
                'nama_varian' => $keranjang->varian->nama,
                'harga' => $keranjang->varian->harga,
            ],
            'kuantitas' => $keranjang->kuantitas,
            'subtotal' => $keranjang->subtotal,
        ];

        return $this->successResponse($keranjangData, 'Item keranjang berhasil diperbarui');
    }

    public function kurangKuantitas(Request $request, $keranjangId)
    {
        $user = Auth::user();

        $keranjang = $user->keranjang()->where('id', $keranjangId)->firstOrFail();

        $request->validate([
            'kurang' => 'required|integer|min:1',
        ]);

        $kurang = (int) $request->kurang;
        $kuantitasBaru = $keranjang->kuantitas - $kurang;

        if ($kuantitasBaru < 1) {
            $e = new \Exception('Kuantitas tidak boleh kurang dari 1');
            return $this->exceptionError($e, 'Kuantitas tidak boleh kurang dari 1', 400);
        }

        $keranjang->kuantitas = $kuantitasBaru;
        $keranjang->subtotal = $keranjang->varian->harga * $kuantitasBaru;
        $keranjang->save();

        $keranjangData = [
            'user' => [
                'id' => $keranjang->user->id,
                'nama' => $keranjang->user->nama,
            ],
            'id' => $keranjang->id,
            'produk' => [
                'id' => $keranjang->produk->id,
                'nama' => $keranjang->produk->nama,
                'satuan_produk' => $keranjang->produk->satuan_produk,
                'gambar_utama' => 'storage/img/produk/' . ($keranjang->produk->gambarUtama ? $keranjang->produk->gambarUtama->gambar : null),
            ],
            'varian' => [
                'id' => $keranjang->varian->id,
                'nama_varian' => $keranjang->varian->nama,
                'harga' => $keranjang->varian->harga,
            ],
            'kuantitas' => $keranjang->kuantitas,
            'subtotal' => $keranjang->subtotal,
        ];

        return $this->successResponse($keranjangData, 'Item keranjang berhasil diperbarui');
    }

    public function hapus(Request $request, $keranjangId)
    {
        $user = Auth::user();

        $keranjang = $user->keranjang()->where('id', $keranjangId)->firstOrFail();

        $keranjang->delete();

        return $this->successResponse([], 'Item keranjang berhasil dihapus');
    }

    public function hapusSemua(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:keranjang,id',
        ]);

        $ids = $request->ids;
        $deleted = $user->keranjang()->whereIn('id', $ids)->delete();

        return $this->successResponse([
            'user' => [
                'id' => $user->id,
                'nama' => $user->nama,
            ],
            'deleted_count' => $deleted,
            'deleted_ids' => $ids,
        ], 'Item keranjang terpilih berhasil dihapus');
    }

    public function beliSekarang(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'keranjang_id' => 'required|integer|exists:keranjang,id',
        ]);

        $keranjang = $user->keranjang()->where('id', $request->keranjang_id)->firstOrFail();

        $beliSekarangData = [
            'user' => [
                'id' => $user->id,
                'nama' => $user->nama,
            ],
            'keranjang_id' => $keranjang->id,
            'produk' => [
                'id' => $keranjang->produk->id,
                'nama' => $keranjang->produk->nama,
                'satuan_produk' => $keranjang->produk->satuan_produk,
                'gambar_utama' => 'storage/img/produk/' . ($keranjang->produk->gambarUtama ? $keranjang->produk->gambarUtama->gambar : null),
            ],
            'varian' => [
                'id' => $keranjang->varian->id,
                'nama_varian' => $keranjang->varian->nama,
                'harga' => $keranjang->varian->harga,
            ],
            'kuantitas' => $keranjang->kuantitas,
            'subtotal' => $keranjang->subtotal,
        ];

        return $this->successResponse($beliSekarangData, 'Berhasil mengambil data beli sekarang dari keranjang');
    }

    public function beliSekarangSemua(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:keranjang,id',
        ]);

        $ids = $request->ids;
        $keranjangs = $user->keranjang()->whereIn('id', $ids)->get();

        $beliSekarangData = $keranjangs->map(function ($keranjang) use ($user) {
            return [
                'user' => [
                    'id' => $user->id,
                    'nama' => $user->nama,
                ],
                'keranjang_id' => $keranjang->id,
                'produk' => [
                    'id' => $keranjang->produk->id,
                    'nama' => $keranjang->produk->nama,
                    'satuan_produk' => $keranjang->produk->satuan_produk,
                    'gambar_utama' => 'storage/img/produk/' . ($keranjang->produk->gambarUtama ? $keranjang->produk->gambarUtama->gambar : null),
                ],
                'varian' => [
                    'id' => $keranjang->varian->id,
                    'nama_varian' => $keranjang->varian->nama,
                    'harga' => $keranjang->varian->harga,
                ],
                'kuantitas' => $keranjang->kuantitas,
                'subtotal' => $keranjang->subtotal,
            ];
        });

        return $this->successResponse($beliSekarangData, 'Berhasil mengambil data beli sekarang dari keranjang terpilih');
    }
}
