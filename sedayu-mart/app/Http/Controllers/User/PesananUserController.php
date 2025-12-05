<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Produk;
use App\Models\TarifPengiriman;
use App\Models\ItemPesanan;
use Illuminate\Validation\ValidationException;

class PesananUserController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $q = $request->query('q');
        $status = $request->query('status');

        $query = Pesanan::with(['items.produk.gambarProduks'])
            ->where('user_id', $user->id)
            ->where('dihapus', false);

        if (!empty($q)) {
            $search = trim($q);
            $query->where(function ($sub) use ($search) {
                $sub->where('id', 'like', "%{$search}%")
                    ->orWhereHas('items.produk', function ($p) use ($search) {
                        $p->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        if (!empty($status)) {
            $query->whereRaw('LOWER(status) = ?', [strtolower($status)]);
        }

        $pesanans = $query->orderBy('created_at', 'desc')->get();

        return view('user.pesanan.index', [
            'pesanans' => $pesanans,
            'user' => $user,
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

        // Only update pesanan that belong to the authenticated user
        Pesanan::whereIn('id', $ids)
            ->where('user_id', $user->id)
            ->update(['dihapus' => true]);

        return redirect()->route('user.pesanan.index')->with('success', 'Riwayat pesanan berhasil dihapus.');
    }

    public function destroy(Request $request, $id)
    {
        $user = Auth::user();

        $pesanan = Pesanan::where('id', $id)->where('user_id', $user->id)->first();
        if (!$pesanan) {
            return redirect()->route('user.pesanan.index')->with('error', 'Pesanan tidak ditemukan.');
        }

        $pesanan->dihapus = true;
        $pesanan->save();

        return redirect()->route('user.pesanan.index')->with('success', 'Pesanan berhasil dipindahkan ke sampah.');
    }

    public function show(Request $request, $id)
    {
        $user = Auth::user();

        $pesanan = Pesanan::with(['items.produk.gambarProduks'])
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->where('dihapus', false)
            ->first();

        if (!$pesanan) {
            abort(404);
        }

        return view('user.pesanan.show-modal', ['pesanan' => $pesanan]);
    }

    public function edit(Request $request, $id)
    {
        $user = Auth::user();
        $pesanan = Pesanan::with(['items.produk.gambarProduks'])
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->where('dihapus', false)
            ->first();

        if (!$pesanan) {
            return redirect()->route('user.pesanan.index')->with('error', 'Pesanan tidak ditemukan.');
        }

        $tarif = TarifPengiriman::first();
        $tarif_per_kg = $tarif ? $tarif->tarif_per_kg : 0;

        return view('user.pesanan.edit-pesanan', [
            'pesanan' => $pesanan,
            'tarif_per_kg' => $tarif_per_kg,
        ]);
    }


    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:item_pesanan,id',
            'items.*.kuantitas' => 'required|integer|min:1',
            'items.*.harga_saat_pemesanan' => 'required|integer|min:0',

            'alamat' => 'required|string|max:255',
            'kabupaten_tujuan' => 'required|string|max:255',
            'ongkir' => 'nullable|integer|min:0',
            'berat_gram' => 'nullable|integer|min:0',
            'total_bayar' => 'nullable|integer|min:0',
            'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $pesanan = Pesanan::with('items')->where('id', $id)
            ->where('user_id', $user->id)
            ->where('dihapus', false)
            ->first();

        if (! $pesanan) {
            return redirect()->route('user.pesanan.index')->with('error', 'Pesanan tidak ditemukan.');
        }

        // Handle file upload (if provided)
        $newFileName = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $newFileName = date('Y-m-d-') . '_' . $file->getClientOriginalName();
            $path = 'img/bukti_pembayaran/' . $newFileName;
            Storage::disk('public')->put($path, file_get_contents($file));
        }

        try {
            DB::transaction(function () use ($request, $pesanan, $newFileName) {
                $itemsInput = $request->input('items', []);

                $subtotalProduk = 0;

                foreach ($itemsInput as $itemData) {
                    $itemId = (int) ($itemData['id'] ?? 0);
                    $newQty = (int) ($itemData['kuantitas'] ?? 0);
                    $newHarga = (int) ($itemData['harga_saat_pemesanan'] ?? 0);

                    $item = ItemPesanan::where('id', $itemId)
                        ->where('pesanan_id', $pesanan->id)
                        ->first();

                    if (! $item) {
                        throw ValidationException::withMessages(['items' => 'Item pesanan tidak valid.']);
                    }

                    $produk = Produk::where('id', $item->produk_id)->lockForUpdate()->first();
                    if (! $produk) {
                        throw new \Exception('Produk terkait tidak ditemukan.');
                    }

                    $oldQty = (int) $item->kuantitas;

                    // Adjust product stock according to quantity change
                    if ($newQty !== $oldQty) {
                        $delta = $newQty - $oldQty;
                        if ($delta > 0) {
                            // need to reserve more stock
                            if ($produk->stok < $delta) {
                                throw ValidationException::withMessages(['items' => "Stok produk '{$produk->nama}' tidak mencukupi."]);
                            }
                            $produk->decrement('stok', $delta);
                        } elseif ($delta < 0) {
                            // user decreased quantity => return stock
                            $produk->increment('stok', -$delta);
                        }
                    }

                    // Update item data
                    $item->kuantitas = $newQty;
                    $item->harga_saat_pemesanan = $newHarga;
                    $item->berat_total = (int) (($produk->berat ?? 0) * $newQty);
                    $item->save();

                    $subtotalProduk += (int) $item->harga_saat_pemesanan * (int) $item->kuantitas;
                }

                // Update pesanan fields
                $ongkir = (int) $request->input('ongkir', 0);
                // total_bayar should always be ongkir + subtotal_produk
                $totalBayar = (int) ($ongkir + $subtotalProduk);

                // If new file uploaded, delete old file (if exists) and set new filename
                if ($newFileName) {
                    if ($pesanan->bukti_pembayaran) {
                        $oldPath = 'img/bukti_pembayaran/' . $pesanan->bukti_pembayaran;
                        if (Storage::disk('public')->exists($oldPath)) {
                            Storage::disk('public')->delete($oldPath);
                        }
                    }
                    $pesanan->bukti_pembayaran = $newFileName;
                }

                $pesanan->alamat = $request->input('alamat');
                $pesanan->kabupaten_tujuan = $request->input('kabupaten_tujuan');
                $pesanan->ongkir = $ongkir;
                $pesanan->subtotal_produk = $subtotalProduk;
                $pesanan->total_bayar = $totalBayar;
                $pesanan->catatan = $request->input('catatan');
                $pesanan->status = 'Menunggu Verifikasi';
                $pesanan->keterangan = null;
                $pesanan->save();
            });

            return redirect()->route('user.pesanan.index')->with('success', 'Pesanan berhasil diperbarui.');
        } catch (ValidationException $ve) {
            return redirect()->back()->withInput()->withErrors($ve->errors());
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
