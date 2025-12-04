<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\TarifPengiriman;
use App\Models\Produk;

class KeranjangUserController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'user') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $user = Auth::user();

        $search = $request->input('search');

        $query = Keranjang::with([
            'produk' => function ($q) {
                $q->with(['gambarProduks' => function ($q2) {
                    $q2->where('utama', 1)->limit(1);
                }]);
            }
        ])->where('user_id', $user->id);

        if ($search) {
            $query->whereHas('produk', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%');
            });
        }

        $keranjangs = $query->get();

        return view('user.keranjang.index', [
            'keranjangs' => $keranjangs,
            'user' => $user,
            'search' => $search,
        ]);
    }

    public function selectDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer',
        ]);

        $user = Auth::user();
        $ids = $request->input('ids', []);

        $keranjangs = Keranjang::with('produk')
            ->whereIn('id', $ids)
            ->where('user_id', $user->id)
            ->get();

        if ($keranjangs->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada item keranjang yang ditemukan untuk dihapus.');
        }

        DB::transaction(function () use ($keranjangs) {
            foreach ($keranjangs as $k) {
                $produk = $k->produk;
                $qty = $k->kuantitas ?? $k->jumlah ?? 0;
                if ($produk && $qty > 0) {
                    // kembalikan stok produk
                    $produk->increment('stok', $qty);
                }
                $k->delete();
            }
        });

        return redirect()->back()->with('success', 'Item keranjang berhasil dihapus.');
    }

    public function destroy($id)
    {
        $user = Auth::user();

        $keranjang = Keranjang::with('produk')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (! $keranjang) {
            return redirect()->back()->with('error', 'Item keranjang tidak ditemukan.');
        }

        DB::transaction(function () use ($keranjang) {
            $produk = $keranjang->produk;
            $qty = $keranjang->kuantitas ?? $keranjang->jumlah ?? 0;
            if ($produk && $qty > 0) {
                $produk->increment('stok', $qty);
            }
            $keranjang->delete();
        });

        return redirect()->back()->with('success', 'Item keranjang berhasil dihapus.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'keranjang_id' => 'required|integer',
            'kuantitas' => 'required|integer|min:1',
        ]);

        $user = Auth::user();

        $keranjang = Keranjang::with('produk')
            ->where('id', $request->keranjang_id)
            ->where('user_id', $user->id)
            ->first();

        if (! $keranjang) {
            return response()->json(['success' => false, 'message' => 'Item keranjang tidak ditemukan.'], 404);
        }

        $produk = $keranjang->produk;
        if (! $produk) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan.'], 404);
        }

        $newQty = (int) $request->kuantitas;
        $oldQty = (int) ($keranjang->kuantitas ?? $keranjang->jumlah ?? 0);

        // Perform stock adjustment with row lock
        try {
            DB::transaction(function () use ($produk, $keranjang, $oldQty, $newQty) {
                // lock product row
                $p = Produk::where('id', $produk->id)->lockForUpdate()->first();
                $delta = $newQty - $oldQty;

                if ($delta > 0) {
                    if ($p->stok < $delta) {
                        return redirect()->back()->with('error', 'Stok produk tidak mencukupi untuk penambahan jumlah.');
                    }
                    $p->decrement('stok', $delta);
                } elseif ($delta < 0) {
                    $p->increment('stok', -$delta);
                }

                $keranjang->kuantitas = $newQty;
                $keranjang->subtotal = $p->harga * $newQty;
                $keranjang->save();
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }

        return response()->json([
            'success' => true,
            'subtotal' => $keranjang->subtotal,
            'kuantitas' => $keranjang->kuantitas,
        ]);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'keranjang_id' => 'required|integer',
        ]);

        $user = Auth::user();
        $keranjang = Keranjang::with('produk')->where('id', $request->keranjang_id)
            ->where('user_id', $user->id)
            ->first();

        if (! $keranjang) {
            return redirect()->back()->with('error', 'Item keranjang tidak ditemukan.');
        }

        $produk = $keranjang->produk;
        if (! $produk) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        // prepare same variables as ProdukUserController::checkout
        $kuantitas = (int) ($keranjang->kuantitas ?? $keranjang->jumlah ?? 1);
        $harga_saat_pemesanan = (int) ($produk->harga);
        $harga_pemesanan = $harga_saat_pemesanan;
        $subtotal = $harga_saat_pemesanan * $kuantitas;

        $kabupaten = $request->input('kabupaten_tujuan') ?? $user->kabupaten;

        $totalBeratGram = ($produk->berat ?? 1000) * $kuantitas;
        $totalBeratKg = $totalBeratGram / 1000;

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

        return view('user.keranjang.checkout', [
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
            'keranjang_id' => $keranjang->id,
        ]);
    }
}
