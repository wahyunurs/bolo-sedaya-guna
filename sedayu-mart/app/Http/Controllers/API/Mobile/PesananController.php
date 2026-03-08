<?php

namespace App\Http\Controllers\API\Mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = Auth::user();

            $query = $user->pesanan()->with([
                'itemPesanan.produk.gambarUtama',
                'itemPesanan.varian',
                'rekening'
            ])->where('dihapus', false);

            // Filter by status jika ada request->status
            $statusList = [
                'menunggu_verifikasi' => 'Menunggu Verifikasi',
                'ditolak' => 'Ditolak',
                'diproses' => 'Diproses',
                'dikirim' => 'Dikirim',
                'selesai' => 'Selesai',
            ];
            if ($request->filled('status') && isset($statusList[$request->status])) {
                $query->where('status', $statusList[$request->status]);
            }

            $pesanans = $query->orderBy('created_at', 'desc')->get();

            if ($pesanans->isEmpty()) {
                return $this->successResponse([], 'Data pesanan tidak ditemukan');
            }

            $pesananData = $pesanans->map(function ($pesanan) {
                $items = $pesanan->itemPesanan->map(function ($item) {
                    return [
                        'item_pesanan_id' => $item->id,
                        'produk' => [
                            'produk_id' => $item->produk->id,
                            'nama_produk' => $item->produk->nama,
                            'varian_id' => $item->varian->id,
                            'gambar_varian' => $item->varian->gambar ? 'storage/img/varian/' . $item->varian->gambar : null,
                            'nama_varian' => $item->varian->nama,
                            'harga' => $item->varian->harga,
                            'kuantitas' => $item->kuantitas,
                            'satuan' => $item->produk->satuan_produk,
                            'subtotal' => $item->subtotal,
                        ],
                    ];
                });

                return [
                    'pesanan_id' => $pesanan->id,
                    'dihapus' => $pesanan->dihapus,
                    'nomor_pesanan' => $pesanan->nomor_pesanan,
                    'pesanan_dibuat_pada' => $pesanan->created_at->toDateTimeString(),
                    'total_bayar' => $pesanan->total_bayar,
                    'status' => $pesanan->status,
                    'catatan' => $pesanan->catatan,
                    'keterangan' => $pesanan->keterangan,
                    'item_pesanan' => $items,
                ];
            });
            return $this->successResponse($pesananData, 'Berhasil mengambil data pesanan');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }

    public function show($pesananId)
    {
        try {
            $user = Auth::user();

            $pesanan = $user->pesanan()->with([
                'itemPesanan.produk.gambarUtama',
                'itemPesanan.varian',
                'rekening',
                'informasiPengiriman'
            ])->find($pesananId);

            if (!$pesanan) {
                return $this->successResponse([], 'Data pesanan tidak ditemukan');
            }

            $items = $pesanan->itemPesanan->map(function ($item) {
                return [
                    'item' => $item->id,
                    'produk' => [
                        'produk_id' => $item->produk->id,
                        'nama_produk' => $item->produk->nama,
                        'varian_id' => $item->varian->id,
                        'gambar_varian' => $item->varian->gambar ? 'storage/img/varian/' . $item->varian->gambar : null,
                        'nama_varian' => $item->varian->nama,
                        'harga' => $item->varian->harga,
                        'kuantitas' => $item->kuantitas,
                        'satuan' => $item->produk->satuan_produk,
                        'subtotal' => $item->subtotal,
                    ],
                ];
            });



            $infoPengiriman = $pesanan->informasiPengiriman;
            $informasiPengiriman = $infoPengiriman ? [
                'nomor_pengiriman' => $infoPengiriman->nomor_pengiriman,
                'nama_ekspedisi' => $infoPengiriman->nama_ekspedisi,
                'estimasi_tiba_mulai' => $infoPengiriman->estimasi_tiba_mulai,
                'estimasi_tiba_selesai' => $infoPengiriman->estimasi_tiba_selesai,
            ] : null;

            $pesananData = [
                'pesanan_id' => $pesanan->id,
                'dihapus' => $pesanan->dihapus,
                'nomor_pesanan' => $pesanan->nomor_pesanan,
                'pesanan_dibuat_pada' => $pesanan->created_at->toDateTimeString(),
                'data_penerima' => [
                    'nama_penerima' => $pesanan->nama_penerima,
                    'nomor_telepon' => $pesanan->nomor_telepon,
                    'alamat' => $pesanan->alamat,
                    'kabupaten_tujuan' => $pesanan->kabupaten_tujuan,
                ],
                'ongkir' => $pesanan->ongkir,
                'subtotal_produk' => $pesanan->subtotal_produk,
                'total_bayar' => $pesanan->total_bayar,
                'rekening' => [
                    'id' => $pesanan->rekening->id,
                    'nama_bank' => $pesanan->rekening->nama_bank,
                    'nomor_rekening' => $pesanan->rekening->nomor_rekening,
                ],
                'bukti_pembayaran' => $pesanan->bukti_pembayaran ? 'storage/img/bukti_pembayaran/' . $pesanan->bukti_pembayaran : null,
                'status' => $pesanan->status,
                'catatan' => $pesanan->catatan,
                'keterangan' => $pesanan->keterangan,
                'items' => $items,
                'informasi_pengiriman' => $informasiPengiriman,
                'hubungi_penjual' => 'https://wa.me/6285812064255?text=Halo%20Admin%20Toko%20Online%2C%20saya%20ingin%20bertanya%20tentang%20pesanan%20dengan%20nomor%20' . $pesanan->nomor_pesanan,
            ];
            return $this->successResponse($pesananData, 'Berhasil mengambil data pesanan');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }

    public function hapus(Request $request, $pesananId)
    {
        try {
            $user = Auth::user();
            $pesanan = $user->pesanan()->find($pesananId);
            if (! $pesanan) {
                $e = new \Exception('Data pesanan tidak ditemukan');
                return $this->exceptionError($e, $e->getMessage(), 404);
            }
            if ($pesanan->status !== 'Selesai') {
                $e = new \Exception('Pesanan hanya bisa dihapus jika status sudah Selesai');
                return $this->exceptionError($e, $e->getMessage(), 400);
            }
            $pesanan->dihapus = true;
            $pesanan->save();
            return $this->successResponse([], 'Pesanan berhasil dihapus');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }

    public function update(Request $request, $pesananId) {}
}
