<?php

namespace App\Http\Controllers\User;

use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\Keranjang;
use App\Models\ItemPesanan;
use Illuminate\Http\Request;
use App\Models\TarifPengiriman;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProdukUserController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'user') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $user = Auth::user();

        $search = $request->input('search');

        $query = Produk::with(['gambarProduks' => function ($q) {
            $q->where('utama', 1)->limit(1);
        }]);

        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        }

        $produks = $query->get();

        return view('user.produk.index', [
            'produks' => $produks,
            'user' => $user,
            'search' => $search,
        ]);
    }

    public function detail($id)
    {
        if (Auth::user()->role !== 'user') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $produk = Produk::with('gambarProduks')->findOrFail($id);

        $user = Auth::user();

        return view('user.produk.detail', [
            'produk' => $produk,
            'user' => $user,
        ]);
    }

    public function tambahKeranjang(Request $request)
    {
        $request->validate([
            'produk_id' => 'required',
            'jumlah' => 'required|integer|min:1',
        ]);

        if (Auth::user()->role !== 'user') {
            return redirect('/')->with('error', 'Akses ditolak.');
        }

        $userId = Auth::id();
        $produkId = $request->produk_id;
        $jumlah = (int) $request->jumlah;

        try {
            DB::transaction(function () use ($userId, $produkId, $jumlah) {
                // Lock produk row for update to avoid race conditions
                $produk = Produk::where('id', $produkId)->lockForUpdate()->first();

                if (! $produk) {
                    throw new \Exception('Produk tidak ditemukan.');
                }

                if ($produk->stok < $jumlah) {
                    throw new \Exception('Stok produk tidak mencukupi.');
                }

                $subtotal = $produk->harga * $jumlah;

                $keranjang = Keranjang::where('user_id', $userId)
                    ->where('produk_id', $produkId)
                    ->first();

                if ($keranjang) {
                    $keranjang->kuantitas = $keranjang->kuantitas + $jumlah;
                    $keranjang->subtotal = $keranjang->subtotal + $subtotal;
                    $keranjang->save();
                } else {
                    Keranjang::create([
                        'user_id' => $userId,
                        'produk_id' => $produkId,
                        'kuantitas' => $jumlah,
                        'subtotal' => $subtotal,
                    ]);
                }

                // Kurangi stok produk
                $produk->stok = max(0, $produk->stok - $jumlah);
                $produk->save();
            });

            return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput(['produk_id' => $produkId])->with('error', $e->getMessage());
        }
    }

    public function beliSekarang(Request $request)
    {
        // Validasi input
        $request->validate([
            'produk_id' => 'required',
            'kuantitas' => 'required|integer|min:1',
        ]);

        // Cek role
        if (Auth::user()->role !== 'user') {
            return redirect('/')->with('error', 'Akses ditolak.');
        }

        // Ambil data input
        $produkId = $request->produk_id;
        $kuantitas = (int)$request->kuantitas;

        // Pastikan produk ada
        Produk::findOrFail($produkId);

        // Redirect ke checkout sambil membawa data input
        return redirect()->route('user.produk.checkout', [
            'produk_id' => $produkId,
            'kuantitas' => $kuantitas,
        ]);
    }


    public function checkout(Request $request)
    {
        $produk = Produk::findOrFail($request->produk_id);
        $user = Auth::user();

        // request values with sensible defaults
        $kuantitas = (int) $request->input('kuantitas', 1);
        $harga_saat_pemesanan = (int) $request->input('harga_saat_pemesanan', $produk->harga);
        $harga_pemesanan = $harga_saat_pemesanan;
        $subtotal = $harga_saat_pemesanan * $kuantitas;

        // Kabupaten tujuan: request -> user
        $kabupaten = $request->input('kabupaten_tujuan') ?? $user->kabupaten;

        // Berat total (gram) dan konversi ke kg
        $totalBeratGram = ($produk->berat ?? 1000) * $kuantitas;
        $totalBeratKg = $totalBeratGram / 1000;

        // Cari tarif pengiriman: normalisasi lalu fallback ke LIKE
        $ongkir = 0;
        $tarif_per_kg = 0;
        if ($kabupaten) {
            $kabupatenNormalized = trim(mb_strtolower($kabupaten));
            $tarif = TarifPengiriman::whereRaw('LOWER(TRIM(kabupaten)) = ?', [$kabupatenNormalized])->first();
            if (! $tarif) {
                $tarif = TarifPengiriman::where('kabupaten', 'like', '%' . trim($kabupaten) . '%')->first();
            }

            if ($tarif) {
                $tarif_per_kg = (int) $tarif->tarif_per_kg;
                $ongkir = (int) round($tarif_per_kg * $totalBeratKg);
            }
        }

        $semua_kabupaten = TarifPengiriman::all();
        $alamat_tujuan = $request->input('alamat') ?? $user->alamat ?? '';
        $kabupaten_tujuan = $request->input('kabupaten_tujuan') ?? $kabupaten ?? '';

        return view('user.produk.checkout', [
            'produk' => $produk,
            'kuantitas' => $kuantitas,
            'harga_saat_pemesanan' => $harga_saat_pemesanan,
            'harga_pemesanan' => $harga_pemesanan,
            'subtotal' => $subtotal,

            'kabupaten' => $kabupaten,
            'kabupaten_tujuan' => $kabupaten_tujuan,
            'alamat_tujuan' => $alamat_tujuan,
            'semua_kabupaten' => $semua_kabupaten,

            'ongkir' => $ongkir,
            'tarif_per_kg' => $tarif_per_kg,
            'totalBeratGram' => $totalBeratGram,
            'berat_gram' => $produk->berat ?? 0,
        ]);
    }


    public function bayarSekarang(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            // Pesanan
            'alamat' => 'required|string|max:255',
            'kabupaten_tujuan' => 'required|string|max:255',
            'total_jumlah' => 'required|integer|min:1',
            'total_berat' => 'required|integer|min:0',
            'ongkir' => 'nullable|integer|min:0',
            'subtotal_produk' => 'required|integer|min:0',
            'total_bayar' => 'required|integer|min:0',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'catatan' => 'nullable|string|max:1000',

            // Item Pesanan
            'produk_id' => 'required|integer',
            'kuantitas' => 'required|integer|min:1',
            'harga_saat_pemesanan' => 'required|integer',
            'berat_total' => 'required|integer|min:0',
        ]);

        // Simpan file bukti pembayaran jika ada
        $fileName = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $fileName = date('Y-m-d-') . '_' . $file->getClientOriginalName();
            $path = 'img/bukti_pembayaran/' . $fileName;

            Storage::disk('public')->put($path, file_get_contents($file));
        }

        $produk = Produk::findOrFail($request->produk_id);

        // Find a related keranjang if provided
        $keranjang = null;
        if ($request->filled('keranjang_id')) {
            $keranjang = Keranjang::where('id', $request->keranjang_id)
                ->where('user_id', $user->id)
                ->first();
        }

        try {
            DB::transaction(function () use ($request, $user, $produk, $keranjang, $fileName) {
                // Stock adjustments:
                // - If checkout from cart: the cart already reserved stock when added.
                //   We compute delta = buyQty - cartQty and adjust the product stock by that delta.
                // - If not from cart: decrement full buy quantity.

                $buyQty = (int) $request->kuantitas;

                if ($keranjang) {
                    $cartQty = (int) ($keranjang->kuantitas ?? $keranjang->jumlah ?? 0);
                    $delta = $buyQty - $cartQty;

                    if ($delta > 0) {
                        if ($produk->stok < $delta) {
                            throw new \Exception('Stok produk tidak mencukupi');
                        }
                        $produk->decrement('stok', $delta);
                    } elseif ($delta < 0) {
                        $produk->increment('stok', -$delta);
                    }
                } else {
                    if ($produk->stok < $buyQty) {
                        throw new \Exception('Stok produk tidak mencukupi');
                    }
                    $produk->decrement('stok', $buyQty);
                }

                $pesanan = Pesanan::create([
                    'user_id' => $user->id,
                    'alamat' => $request->alamat,
                    'kabupaten_tujuan' => $request->kabupaten_tujuan,
                    'ongkir' => $request->ongkir ?? 0,
                    'subtotal_produk' => $request->subtotal_produk,
                    'total_bayar' => $request->total_bayar,
                    'bukti_pembayaran' => $fileName,
                    'status' => 'Menunggu Verifikasi',
                    'catatan' => $request->catatan,
                ]);

                ItemPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'produk_id' => $request->produk_id,
                    'kuantitas' => $request->kuantitas,
                    'harga_saat_pemesanan' => $request->harga_saat_pemesanan,
                    'berat_total' => $request->berat_total,
                ]);

                // If checkout came from a cart item, remove that cart row now
                if ($keranjang) {
                    $keranjang->delete();
                }
            });

            return redirect()
                ->route('user.produk.index')
                ->with('success', 'Pesanan berhasil dibuat, menunggu verifikasi pembayaran.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
