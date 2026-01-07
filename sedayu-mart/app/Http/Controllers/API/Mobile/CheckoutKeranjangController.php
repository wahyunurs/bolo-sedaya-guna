<?php

namespace App\Http\Controllers\API\Mobile;

use App\Models\Produk;
use App\Models\Varian;
use App\Models\Pesanan;
use App\Models\Rekening;
use App\Models\ItemPesanan;
use Illuminate\Http\Request;
use App\Models\TarifPengiriman;
use App\Models\AlamatPengiriman;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CheckoutKeranjangController extends Controller
{
    /**
     * CHECKOT
     */
    public function alamatUtama(Request $request)
    {
        try {
            $user = Auth::user();

            $alamatUtama = AlamatPengiriman::where('user_id', $user->id)->where('utama', true)->first();

            if (empty($alamatUtama)) {
                return $this->successResponse([
                    'user' => [
                        'id'   => $user->id,
                        'nama' => $user->nama,
                    ],
                    'alamat_utama' => null,
                ], 'Alamat pengiriman utama belum diatur');
            }

            return $this->successResponse([
                'user' => [
                    'id'   => $user->id,
                    'nama' => $user->nama,
                ],
                'alamat_utama' => $alamatUtama,
            ], 'Berhasil mengambil data alamat pengiriman utama');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }

    public function rekeningList(Request $request)
    {
        try {
            $user = Auth::user();

            $rekenings = Rekening::all();

            return $this->successResponse([
                'user' => [
                    'id'   => $user->id,
                    'nama' => $user->nama,
                ],
                'rekenings' => $rekenings,
            ], 'Berhasil mengambil data rekening');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }

    public function checkout(Request $request)
    {
        try {
            $user = Auth::user();

            // Validasi request: hanya butuh array keranjang_id
            $request->validate([
                'keranjang_id' => 'required|array|min:1',
                'keranjang_id.*' => 'required|integer|exists:keranjang,id',
                'alamat_id' => 'required|integer|exists:alamat_pengiriman,id',
                'rekening_id' => 'required|integer|exists:rekening,id',
                'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:5120',
                'catatan' => 'nullable|string|max:1000',
            ]);

            $keranjangIds = $request->input('keranjang_id');
            $keranjangs = $user->keranjang()->whereIn('id', $keranjangIds)->get();
            if ($keranjangs->isEmpty()) {
                return $this->successResponse([], 'Keranjang tidak ditemukan');
            }

            $alamat = AlamatPengiriman::findOrFail($request->alamat_id);
            $rekeningId = $request->rekening_id;
            $rekening = Rekening::findOrFail($rekeningId);
            $catatan = $request->catatan;

            $subtotalProduk = 0;
            $totalBeratGram = 0;
            $produkCheckout = [];

            // Cek stok dan hitung subtotal & berat dari data keranjang
            foreach ($keranjangs as $keranjang) {
                $produk = $keranjang->produk;
                $varian = $keranjang->varian;
                $kuantitas = (int) $keranjang->kuantitas;

                if ($varian->stok < $kuantitas) {
                    return $this->successResponse([], 'Stok varian tidak mencukupi untuk produk: ' . $produk->nama);
                }

                $harga = (int) $varian->harga;
                $subtotalProduk += $harga * $kuantitas;
                $beratProduk = (int) ($varian->berat ?? 1000);
                $totalBeratGram += $beratProduk * $kuantitas;

                $produkCheckout[] = [
                    'produk_id' => $produk->id,
                    'nama_produk' => $produk->nama,
                    'varian_id' => $varian->id,
                    'nama_varian' => $varian->nama,
                    'kuantitas' => $kuantitas,
                    'harga' => $harga,
                    'subtotal' => $harga * $kuantitas,
                ];
            }

            $totalBeratKg = (int) ceil($totalBeratGram / 1000);
            $tarif = TarifPengiriman::whereRaw(
                'LOWER(TRIM(kabupaten)) = ?',
                [mb_strtolower(trim($alamat->kabupaten))]
            )->first();

            if (! $tarif) {
                $e = new \Exception('Tarif pengiriman tidak ditemukan untuk kabupaten tujuan: ' . $alamat->kabupaten);
                return $this->exceptionError($e, $e->getMessage(), 500);
            }

            $ongkir = (int) ($tarif->tarif_per_kg * $totalBeratKg);
            $totalBayar = $subtotalProduk + $ongkir;

            $fileName = null;
            if ($request->hasFile('bukti_pembayaran')) {
                $file = $request->file('bukti_pembayaran');
                $fileName = time() . '-' . $file->getClientOriginalName();
                Storage::disk('public')->putFileAs('img/bukti_pembayaran', $file, $fileName);
            }



            // Inisialisasi nomor_pesanan di luar transaksi agar bisa digunakan di response
            $now = now();
            $bulanTahun = $now->format('my'); // MMYY
            $counter = Pesanan::whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year)
                ->count() + 1;
            $nomorPesanan = 'ORD-' . $bulanTahun . '-' . str_pad($counter, 4, '0', STR_PAD_LEFT);

            DB::transaction(function () use (
                $user,
                $keranjangs,
                $alamat,
                $rekeningId,
                $subtotalProduk,
                $totalBayar,
                $ongkir,
                $fileName,
                $catatan,
                $totalBeratGram,
                $nomorPesanan,
            ) {
                $pesanan = Pesanan::create([
                    'user_id' => $user->id,
                    'alamat' => $alamat->alamat,
                    'kabupaten_tujuan' => $alamat->kabupaten,
                    'ongkir' => $ongkir,
                    'subtotal_produk' => $subtotalProduk,
                    'total_bayar' => $totalBayar,
                    'rekening_id' => $rekeningId,
                    'bukti_pembayaran' => $fileName,
                    'status' => 'Menunggu Verifikasi',
                    'catatan' => $catatan,
                    'nomor_pesanan' => $nomorPesanan,
                ]);

                foreach ($keranjangs as $keranjang) {
                    $produk = $keranjang->produk;
                    $varian = $keranjang->varian;
                    $kuantitas = (int) $keranjang->kuantitas;
                    $harga = (int) $varian->harga;
                    $beratProduk = (int) ($varian->berat ?? 1000);
                    $beratTotal = $beratProduk * $kuantitas;

                    if ($varian->stok < $kuantitas) {
                        throw new \Exception('Stok varian tidak mencukupi untuk produk: ' . $produk->nama);
                    }
                    $varian->decrement('stok', $kuantitas);

                    ItemPesanan::create([
                        'pesanan_id' => $pesanan->id,
                        'produk_id' => $produk->id,
                        'varian_id' => $varian->id,
                        'kuantitas' => $kuantitas,
                        'subtotal' => $harga * $kuantitas,
                        'berat_total' => $beratTotal,
                    ]);
                }

                // Hapus data keranjang yang sudah di-checkout
                foreach ($keranjangs as $keranjang) {
                    $keranjang->delete();
                }
            });

            $checkoutData = [
                'nomor_pesanan' => $nomorPesanan,
                'produk' => $produkCheckout,
                'rekening' => [
                    'id' => $rekeningId,
                    'nama_bank' => $rekening->nama_bank,
                    'nomor_rekening' => $rekening->nomor_rekening,
                    'atas_nama' => $rekening->atas_nama,
                ],
                'alamat_pengiriman' => $alamat->alamat,
                'kabupaten_tujuan' => $alamat->kabupaten,
                'subtotal_semua' => $subtotalProduk,
                'ongkir' => $ongkir,
                'total_bayar' => $totalBayar,
                'bukti_pembayaran' => $fileName,
                'catatan' => $catatan,
            ];

            return $this->successResponse([
                'user' => [
                    'id'   => $user->id,
                    'nama' => $user->nama,
                ],
                'pesanan' => $checkoutData,
            ], 'Berhasil melakukan checkout dan membuat pesanan');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }

    /**
     * ALAMAT PENGIRIMAN
     */
    public function alamatPengiriman(Request $request)
    {
        try {
            $user = Auth::user();

            $alamatPengirimen = AlamatPengiriman::where('user_id', $user->id)->get();

            if ($alamatPengirimen->isEmpty()) {
                return $this->successResponse([
                    'user' => [
                        'id'   => $user->id,
                        'nama' => $user->nama,
                    ],
                    'alamat_pengiriman' => [],
                ], 'Belum ada alamat pengiriman yang ditambahkan');
            }

            return $this->successResponse([
                'user' => [
                    'id'   => $user->id,
                    'nama' => $user->nama,
                ],
                'alamat_pengiriman' => $alamatPengirimen,
            ], 'Berhasil mengambil data alamat pengiriman');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }

    public function kabupatenDropdown(Request $request)
    {
        try {
            $user = Auth::user();

            $search = $request->query('search');

            $query = TarifPengiriman::select('kabupaten')->distinct();
            if ($search) {
                $query->where('kabupaten', 'like', '%' . $search . '%');
            }
            $kabupatens = $query->orderBy('kabupaten', 'asc')->get()->pluck('kabupaten');

            return $this->successResponse([
                'user' => [
                    'id'   => $user->id,
                    'nama' => $user->nama,
                ],
                'kabupaten' => $kabupatens,
            ], 'Berhasil mengambil data kabupaten untuk dropdown');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }

    public function tambahAlamatPengiriman(Request $request)
    {
        try {
            $user = Auth::user();

            // Validasi request
            $request->validate([
                'nama_penerima'  => 'required|string|max:255',
                'nomor_telepon' => 'required|string|max:20',
                'alamat'    => 'required|string|max:500',
                'kabupaten'    => 'sometimes|string|max:255',
                // 'kabupaten'    => [
                //     'required',
                //     'string',
                //     'max:255',
                //     function ($attribute, $value, $fail) {
                //         if (!preg_match('/^(Kabupaten|Kota) /i', $value)) {
                //             $fail('Kabupaten harus diawali dengan "Kabupaten" atau "Kota"');
                //         }
                //     }
                // ],
                'provinsi'    => 'required|string|in:Jawa Tengah|max:100',
                'kode_pos'    => 'required|string|max:10',
                'keterangan'    => 'nullable|string|max:1000',
                'utama'    => 'sometimes|boolean',
            ]);

            // Jika alamat utama, set semua alamat lain menjadi bukan utama
            if ($request->has('utama') && $request->utama) {
                AlamatPengiriman::where('user_id', $user->id)->update(['utama' => false]);
            }

            $alamatPengiriman = AlamatPengiriman::create([
                'user_id' => $user->id,
                'nama_penerima' => $request->nama_penerima,
                'nomor_telepon' => $request->nomor_telepon,
                'alamat' => $request->alamat,
                'kabupaten' => $request->kabupaten,
                'provinsi' => $request->provinsi,
                'kode_pos' => $request->kode_pos,
                'keterangan' => $request->keterangan,
                'utama' => $request->has('utama') ? $request->utama : false,
            ]);

            return $this->successResponse([
                'user' => [
                    'id'   => $user->id,
                    'nama' => $user->nama,
                ],
                'alamat_pengiriman' => $alamatPengiriman,
            ], 'Berhasil menambahkan alamat pengiriman');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }

    public function updateAlamatPengiriman(Request $request, $alamatId)
    {
        try {
            $user = Auth::user();

            $alamatPengiriman = AlamatPengiriman::where('user_id', $user->id)->where('id', $alamatId)->first();
            if (! $alamatPengiriman) {
                return $this->successResponse([], 'Alamat pengiriman tidak ditemukan');
            }

            // Validasi request
            $request->validate([
                'nama_penerima'  => 'sometimes|string|max:255',
                'nomor_telepon' => 'sometimes|string|max:20',
                'alamat'    => 'sometimes|string|max:500',
                'kabupaten'    => 'sometimes|string|max:255',
                // 'kabupaten'    => [
                //     'sometimes',
                //     'string',
                //     'max:255',
                //     function ($attribute, $value, $fail) {
                //         if ($value !== null && !preg_match('/^(Kabupaten|Kota) /i', $value)) {
                //             $fail('Kabupaten harus diawali dengan "Kabupaten" atau "Kota"');
                //         }
                //     }
                // ],
                'provinsi'    => 'sometimes|string|in:Jawa Tengah|max:100',
                'kode_pos'    => 'sometimes|string|max:10',
                'keterangan'    => 'nullable|string|max:1000',
                'utama'    => 'sometimes|boolean',
            ]);

            // Jika alamat utama, set semua alamat lain menjadi bukan utama
            if ($request->has('utama') && $request->utama) {
                AlamatPengiriman::where('user_id', $user->id)->update(['utama' => false]);
            }

            // Update data alamat pengiriman
            $alamatPengiriman->update($request->only([
                'nama_penerima',
                'nomor_telepon',
                'alamat',
                'kabupaten',
                'provinsi',
                'kode_pos',
                'keterangan',
                'utama',
            ]));

            return $this->successResponse([
                'user' => [
                    'id'   => $user->id,
                    'nama' => $user->nama,
                ],
                'alamat_pengiriman' => $alamatPengiriman,
            ], 'Berhasil memperbarui alamat pengiriman');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }

    public function hapusAlamatPengiriman(Request $request, $alamatId)
    {
        try {
            $user = Auth::user();

            $alamatPengiriman = AlamatPengiriman::where('user_id', $user->id)->where('id', $alamatId)->first();
            if (! $alamatPengiriman) {
                return $this->successResponse([], 'Alamat pengiriman tidak ditemukan');
            }

            $isUtama = $alamatPengiriman->utama == 1;
            $alamatPengiriman->delete();

            // Jika yang dihapus adalah utama, set alamat pertama user menjadi utama
            if ($isUtama) {
                $alamatBaruUtama = AlamatPengiriman::where('user_id', $user->id)->orderBy('id', 'asc')->first();
                if ($alamatBaruUtama) {
                    $alamatBaruUtama->update(['utama' => 1]);
                }
            }

            return $this->successResponse([
                'user' => [
                    'id'   => $user->id,
                    'nama' => $user->nama,
                ],
            ], 'Berhasil menghapus alamat pengiriman');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }

    public function pilihAlamatPengiriman(Request $request, $alamatId)
    {
        try {
            $user = Auth::user();

            $alamatPengiriman = AlamatPengiriman::where('user_id', $user->id)->where('id', $alamatId)->first();
            if (! $alamatPengiriman) {
                return $this->successResponse([], 'Alamat pengiriman tidak ditemukan');
            }

            return $this->successResponse([
                'user' => [
                    'id'   => $user->id,
                    'nama' => $user->nama,
                ],
                'alamat_pengiriman' => $alamatPengiriman,
            ], 'Berhasil memilih alamat pengiriman');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }
}
