<?php

namespace App\Http\Controllers\User;

use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\Rekening;
use App\Models\Keranjang;
use App\Models\ItemPesanan;
use Illuminate\Http\Request;
use App\Models\TarifPengiriman;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\AlamatPengiriman;
use App\Models\Varian;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukUserController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'user') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $user = Auth::user();

        $search = $request->input('search');

        $query = Produk::with([
            'gambarProduks' => function ($q) {
                $q->where('utama', 1)->limit(1);
            },
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

        $produks = $query->get();

        $varians = Varian::whereIn('produk_id', $produks->pluck('id'))->get()->groupBy('produk_id');

        return view('user.produk.index', [
            'produks' => $produks,
            'varians' => $varians,
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

        $varians = $produk->varians()->get();

        $user = Auth::user();

        return view('user.produk.detail.index', [
            'produk' => $produk,
            'user' => $user,
            'varians' => $varians,
        ]);
    }

    public function tambahKeranjang(Request $request)
    {
        $request->validate([
            'produk_id' => 'required',
            'varian_id' => 'required',
            'jumlah' => 'required|integer|min:1',
            'subtotal' => 'required|integer|min:0',
        ]);

        $userId = Auth::id();
        $produkId = $request->produk_id;
        $varianId = $request->varian_id;
        $jumlah = (int) $request->jumlah;
        $subtotal = (int) $request->subtotal;

        try {
            DB::transaction(function () use ($userId, $produkId, $varianId, $jumlah, $subtotal) {
                // Lock produk row for update to avoid race conditions
                $produk = Produk::where('id', $produkId)->lockForUpdate()->first();
                $varian = Varian::where('id', $varianId)->lockForUpdate()->first();

                if (! $produk) {
                    throw new \Exception('Produk tidak ditemukan.');
                }
                if (! $varian) {
                    throw new \Exception('Varian tidak ditemukan.');
                }

                if ($varian->stok < $jumlah) {
                    throw new \Exception('Stok varian tidak mencukupi.');
                }

                $keranjang = Keranjang::where('user_id', $userId)
                    ->where('produk_id', $produkId)
                    ->where('varian_id', $varianId)
                    ->first();

                if ($keranjang) {
                    $keranjang->kuantitas = $keranjang->kuantitas + $jumlah;
                    $keranjang->subtotal = $keranjang->subtotal + $subtotal;
                    $keranjang->save();
                } else {
                    Keranjang::create([
                        'user_id' => $userId,
                        'produk_id' => $produkId,
                        'varian_id' => $varianId,
                        'kuantitas' => $jumlah,
                        'subtotal' => $subtotal,
                    ]);
                }

                // Kurangi stok varian
                $varian->stok = max(0, $varian->stok - $jumlah);
                $varian->save();
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
            'varian_id' => 'required',
            'jumlah' => 'required|integer|min:1',
            'subtotal' => 'required|integer|min:0',
        ]);

        // Ambil data input
        $produkId = $request->produk_id;
        $varianId = $request->varian_id;
        $kuantitas = (int)$request->jumlah;
        $subtotal = (int)$request->subtotal;

        // Pastikan produk ada
        Produk::findOrFail($produkId);
        Varian::findOrFail($varianId);

        // Redirect ke checkout sambil membawa data input
        return redirect()->route('user.produk.checkout', [
            'produk_id' => $produkId,
            'varian_id' => $varianId,
            'kuantitas' => $kuantitas,
            'subtotal' => $subtotal,
        ]);
    }


    public function checkout(Request $request)
    {
        $user = Auth::user();

        $produk = Produk::findOrFail($request->produk_id);
        $varian = Varian::findOrFail($request->varian_id);

        $alamatPengirimans = AlamatPengiriman::where('user_id', $user->id)->get();
        $tarifPengirimans  = TarifPengiriman::all();
        $rekenings         = Rekening::all();

        // ================= QTY =================
        $kuantitas = max(1, (int) $request->input('kuantitas', 1));

        // ================= SUBTOTAL =================
        $harga    = (int) $varian->harga;
        $subtotal = $harga * $kuantitas;

        // ================= ALAMAT TERPILIH =================
        if ($request->filled('alamat_id')) {
            $alamatTerpilih = $alamatPengirimans->where('id', $request->alamat_id)->first();
        } else {
            $alamatTerpilih = $alamatPengirimans->where('utama', 1)->first()
                ?? $alamatPengirimans->first();
        }

        // ================= KABUPATEN =================
        $kabupatenTujuan = $alamatTerpilih->kabupaten ?? null;

        // ================= BERAT (GRAM → KG EKSPEDISI) =================
        $beratVarianGram = (float) ($varian->berat ?? 0); // GRAM
        $totalBeratGram = $beratVarianGram * $kuantitas;

        // ✅ ATURAN EKSPEDISI
        $totalBeratKg = max(1, (int) ceil($totalBeratGram / 1000));

        // ================= ONGKIR =================
        $tarif_per_kg = 0;
        $ongkir = 0;

        if ($kabupatenTujuan) {
            $tarif = TarifPengiriman::whereRaw(
                'LOWER(TRIM(kabupaten)) = ?',
                [mb_strtolower(trim($kabupatenTujuan))]
            )->first();

            if ($tarif) {
                $tarif_per_kg = (int) $tarif->tarif_per_kg;
                $ongkir = $tarif_per_kg * $totalBeratKg;
            }
        }

        $totalBayar = $subtotal + $ongkir;

        return view('user.produk.checkout', [
            'produk'            => $produk,
            'varian'            => $varian,
            'alamatPengirimans' => $alamatPengirimans,
            'tarifPengirimans'  => $tarifPengirimans,
            'rekenings'         => $rekenings,

            'alamatUtama'       => $alamatTerpilih,

            'kuantitas'         => $kuantitas,
            'subtotal'          => $subtotal,

            'ongkir'            => $ongkir,
            'tarif_per_kg'      => $tarif_per_kg,
            'totalBeratGram'    => $totalBeratGram,
            'totalBeratKg'      => $totalBeratKg,
            'totalBayar'        => $totalBayar,
        ]);
    }



    /**
     * ALAMAT PENGIRIMAN
     */
    public function alamatPengiriman(Request $request)
    {
        $user = Auth::user();

        $alamatPengirimans = AlamatPengiriman::where('user_id', $user->id)->get();

        return view('user.produk.alamat-pengiriman.index', [
            'user' => $user,
            'alamatPengirimans' => $alamatPengirimans,
        ]);
    }

    public function createAlamatPengiriman(Request $request)
    {
        $user = Auth::user();

        $kabupatens = TarifPengiriman::orderBy('kabupaten', 'asc')->get()->pluck('kabupaten');

        return view('user.produk.alamat-pengiriman.create', [
            'user' => $user,
            'kabupatens' => $kabupatens,
        ]);
    }

    public function storeAlamatPengiriman(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'kabupaten' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kode_pos' => 'required|string|max:10',
            'keterangan' => 'nullable|string|max:1000',
            'utama' => 'nullable|boolean',
        ]);

        if ($request->utama) {
            // Set all other addresses to not utama
            AlamatPengiriman::where('user_id', $user->id)->update(['utama' => false]);
        }

        AlamatPengiriman::create([
            'user_id' => $user->id,
            'nama_penerima' => $request->nama_penerima,
            'nomor_telepon' => $request->nomor_telepon,
            'alamat' => $request->alamat,
            'kabupaten' => $request->kabupaten,
            'provinsi' => $request->provinsi,
            'kode_pos' => $request->kode_pos,
            'keterangan' => $request->keterangan,
            'utama' => $request->utama ? true : false,
        ]);

        return redirect()->route('user.produk.alamatPengiriman')->with('success', 'Alamat pengiriman berhasil ditambahkan.');
    }

    public function editAlamatPengiriman($id)
    {
        $user = Auth::user();

        $alamatPengiriman = AlamatPengiriman::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        return view('user.produk.alamat-pengiriman.edit', [
            'user' => $user,
            'alamatPengiriman' => $alamatPengiriman,
        ]);
    }

    public function updateAlamatPengiriman(Request $request, $id)
    {
        $user = Auth::user();

        $alamatPengiriman = AlamatPengiriman::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'kabupaten' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kode_pos' => 'required|string|max:10',
            'keterangan' => 'nullable|string|max:1000',
            'utama' => 'nullable|boolean',
        ]);

        if ($request->utama) {
            // Set all other addresses to not utama
            AlamatPengiriman::where('user_id', $user->id)->update(['utama' => false]);
        }

        $alamatPengiriman->update([
            'nama_penerima' => $request->nama_penerima,
            'nomor_telepon' => $request->nomor_telepon,
            'alamat' => $request->alamat,
            'kabupaten' => $request->kabupaten,
            'provinsi' => $request->provinsi,
            'kode_pos' => $request->kode_pos,
            'keterangan' => $request->keterangan,
            'utama' => $request->utama ? true : false,
        ]);

        return redirect()->route('user.produk.alamatPengiriman')->with('success', 'Alamat pengiriman berhasil diperbarui.');
    }

    public function destroyAlamatPengiriman($id)
    {
        $user = Auth::user();

        $alamatPengiriman = AlamatPengiriman::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $alamatPengiriman->delete();

        return redirect()->back()->with('success', 'Alamat pengiriman berhasil dihapus.');
    }

    public function pilihAlamatPengiriman(Request $request)
    {
        $request->validate([
            'alamat_id' => 'required|exists:alamat_pengiriman,id',
        ]);

        // Data WAJIB checkout
        $checkoutData = [
            'produk_id' => $request->produk_id,
            'varian_id' => $request->varian_id,
            'kuantitas' => $request->kuantitas,
            'subtotal'  => $request->subtotal,
        ];

        // Data alamat
        $alamatData = [
            'alamat_id' => $request->alamat_id,
            'nama_penerima' => $request->nama_penerima,
            'alamat' => $request->alamat,
            'kabupaten_tujuan' => $request->kabupaten_tujuan,
            'provinsi' => $request->provinsi,
            'kode_pos' => $request->kode_pos,
            'nomor_telepon' => $request->nomor_telepon,
            'keterangan' => $request->keterangan,
            'utama' => $request->utama,
        ];

        // Gabungkan → jadi query string
        return redirect()->route(
            'user.produk.checkout',
            array_merge($checkoutData, $alamatData)
        );
    }

    public function bayarSekarang(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'varian_id' => 'required|exists:varian,id',
            'kuantitas' => 'required|integer|min:1',

            'alamat' => 'required|string|max:255',
            'kabupaten_tujuan' => 'required|string|max:255',

            'rekening_id' => 'required|exists:rekening,id',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:5120',

            'catatan' => 'nullable|string|max:1000',
        ]);

        $produk = Produk::findOrFail($request->produk_id);
        $varian = Varian::findOrFail($request->varian_id);

        $qty = (int) $request->kuantitas;
        $harga = (int) $varian->harga;

        // ================= SUBTOTAL =================
        $subtotalProduk = $harga * $qty;

        // ================= BERAT =================
        $beratProduk = (int) ($produk->berat ?? 1000);
        $totalBeratGram = $beratProduk * $qty;
        $totalBeratKg = (int) ceil($totalBeratGram / 1000);

        // ================= ONGKIR =================
        $tarif = TarifPengiriman::whereRaw(
            'LOWER(TRIM(kabupaten)) = ?',
            [mb_strtolower(trim($request->kabupaten_tujuan))]
        )->first();

        if (! $tarif) {
            return back()->withInput()->with('error', 'Tarif pengiriman tidak tersedia.');
        }

        $ongkir = (int) ($tarif->tarif_per_kg * $totalBeratKg);
        $totalBayar = $subtotalProduk + $ongkir;

        // ================= UPLOAD BUKTI =================
        $fileName = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $fileName = time() . '_' . $file->getClientOriginalName();

            Storage::disk('public')->put(
                'img/bukti_pembayaran/' . $fileName,
                file_get_contents($file)
            );
        }

        DB::transaction(function () use (
            $user,
            $request,
            $produk,
            $varian,
            $qty,
            $subtotalProduk,
            $totalBayar,
            $ongkir,
            $fileName,
            $totalBeratGram
        ) {
            if ($varian->stok < $qty) {
                throw new \Exception('Stok varian tidak mencukupi');
            }

            $varian->decrement('stok', $qty);

            $pesanan = Pesanan::create([
                'user_id' => $user->id,
                'alamat' => $request->alamat,
                'kabupaten_tujuan' => $request->kabupaten_tujuan,
                'ongkir' => $ongkir,
                'subtotal_produk' => $subtotalProduk,
                'total_bayar' => $totalBayar,
                'rekening_id' => $request->rekening_id,
                'bukti_pembayaran' => $fileName,
                'status' => 'Menunggu Verifikasi',
                'catatan' => $request->catatan,
            ]);

            ItemPesanan::create([
                'pesanan_id' => $pesanan->id,
                'produk_id' => $request->produk_id,
                'varian_id' => $request->varian_id,
                'kuantitas' => $qty,
                'subtotal' => $subtotalProduk,
                'berat_total' => $totalBeratGram,
            ]);
        });

        return redirect()
            ->route('user.produk.index')
            ->with('success', 'Pesanan berhasil dibuat, menunggu verifikasi pembayaran.');
    }
}
