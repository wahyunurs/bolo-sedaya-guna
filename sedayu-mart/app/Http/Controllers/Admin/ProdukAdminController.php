<?php

namespace App\Http\Controllers\Admin;

use App\Models\Produk;
use App\Models\Varian;
use Illuminate\Support\Str;
use App\Models\GambarProduk;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukAdminController extends Controller
{
    /**
     * PRODUK
     */
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
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

        return view('admin.produk.index', [
            'produks' => $produks,
            'user' => $user,
            'search' => $search,
        ]);
    }

    public function show($id)
    {
        $produk = Produk::with('gambarProduks')->findOrFail($id);

        return view('admin.produk.show-modal', [
            'produk' => $produk,
        ]);
    }

    public function create()
    {

        return view('admin.produk.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'satuan_produk' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'gambar.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'utama_gambar' => 'nullable',
            // Validasi varian
            'varian' => 'required|array|min:1',
            'varian.*.nama' => 'required|string|max:255',
            'varian.*.harga' => 'required|integer|min:0',
            'varian.*.berat' => 'required|integer|min:0',
            'varian.*.stok' => 'required|integer|min:0',
            'varian.*.is_default' => 'required|boolean',
            'varian_gambar.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
        ], [
            'varian.*.is_default.required' => 'Setiap varian harus dipilih salah satu sebagai default.',
        ]);

        DB::beginTransaction();
        try {
            $produk = Produk::create([
                'nama' => $validated['nama'],
                'satuan_produk' => $validated['satuan_produk'],
                'deskripsi' => $validated['deskripsi'] ?? null,
            ]);

            // Validasi hanya satu is_default
            $defaultCount = 0;
            $defaultIdx = null;
            foreach ($validated['varian'] as $idx => $varian) {
                if (isset($varian['is_default']) && $varian['is_default']) {
                    $defaultCount++;
                    $defaultIdx = $idx;
                }
            }
            if ($defaultCount !== 1) {
                DB::rollBack();
                return back()->withInput()->withErrors(['varian' => 'Hanya boleh satu varian default untuk setiap produk.']);
            }

            // Create multiple varian
            $varianFiles = $request->file('varian_gambar', []);
            foreach ($validated['varian'] as $idx => $varian) {
                $varianGambarName = null;
                if (isset($varianFiles[$idx]) && $varianFiles[$idx] instanceof UploadedFile) {
                    $orig = $varianFiles[$idx]->getClientOriginalName();
                    $varianGambarName = time() . '_varian_' . $idx . '_' . preg_replace('/[^A-Za-z0-9\._-]/', '_', $orig);
                    $path = 'img/varian/' . $varianGambarName;
                    Storage::disk('public')->put($path, file_get_contents($varianFiles[$idx]));
                }
                Varian::create([
                    'produk_id' => $produk->id,
                    'nama' => $varian['nama'],
                    'harga' => $varian['harga'],
                    'berat' => $varian['berat'],
                    'stok' => $varian['stok'],
                    'is_default' => ($idx === $defaultIdx) ? 1 : 0,
                    'gambar' => $varianGambarName,
                ]);
            }

            $files = $request->file('gambar', []);
            $utamaIndexRaw = $request->input('utama_gambar');
            $utamaIndex = null;
            if (is_string($utamaIndexRaw) && str_starts_with($utamaIndexRaw, 'new_')) {
                $utamaIndex = (int) substr($utamaIndexRaw, 4);
            } elseif (is_numeric($utamaIndexRaw)) {
                $utamaIndex = (int) $utamaIndexRaw;
            }

            if (is_array($files) && count($files)) {
                foreach ($files as $idx => $file) {
                    if (!$file) continue;
                    if (!($file instanceof UploadedFile)) continue;

                    $orig = $file->getClientOriginalName();
                    $name = time() . '_' . $idx . '_' . preg_replace('/[^A-Za-z0-9\._-]/', '_', $orig);
                    $path = 'img/produk/' . $name;

                    Storage::disk('public')->put($path, file_get_contents($file));

                    GambarProduk::create([
                        'produk_id' => $produk->id,
                        'gambar' => $name,
                        'utama' => ($utamaIndex !== null && (int)$idx === (int)$utamaIndex) ? 1 : 0,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.produk.index')->with('success', 'Produk & varian berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan produk.');
        }
    }

    public function edit($id)
    {
        $produk = Produk::with('gambarProduks')->findOrFail($id);

        return view('admin.produk.edit', [
            'produk' => $produk,
        ]);
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'satuan_produk' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'gambar.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'utama_gambar' => 'nullable',
        ]);

        DB::beginTransaction();
        try {
            $produk->update([
                'nama' => $validated['nama'],
                'satuan_produk' => $validated['satuan_produk'],
                'deskripsi' => $validated['deskripsi'] ?? null,
            ]);

            // Per-slot handling: preserve old images unless admin explicitly deleted them
            $slotExisting = $request->input('slot_existing_id', []); // may be missing for removed slots
            $deleteSlot = $request->input('delete_slot', []);
            $files = $request->file('gambar', []);

            // snapshot current images in the same order the edit view uses
            $existingCollection = $produk->gambarProduks()->get()->values();

            $createdIds = []; // map slot => new created id
            $preservedIds = []; // map slot => existing id kept

            for ($i = 0; $i < 5; $i++) {
                $providedExisting = isset($slotExisting[$i]) && $slotExisting[$i] ? (int)$slotExisting[$i] : null;
                // if admin removed the hidden input, fall back to collection index to guess existing id
                $fallbackExisting = isset($existingCollection[$i]) ? $existingCollection[$i]->id : null;
                $existingId = $providedExisting ?? $fallbackExisting;

                $file = isset($files[$i]) ? $files[$i] : null;
                $toDelete = isset($deleteSlot[$i]) && ($deleteSlot[$i] == '1' || $deleteSlot[$i] === 1 || $deleteSlot[$i] === 'true');

                if ($file && $file instanceof \Illuminate\Http\UploadedFile) {
                    // store new upload
                    $orig = $file->getClientOriginalName();
                    $name = time() . '_' . $i . '_' . preg_replace('/[^A-Za-z0-9\._-]/', '_', $orig);
                    $path = 'img/produk/' . $name;
                    Storage::disk('public')->put($path, file_get_contents($file));

                    if ($existingId) {
                        $g = GambarProduk::where('id', $existingId)->where('produk_id', $produk->id)->first();
                        if ($g) {
                            // delete old file
                            if ($g->gambar) {
                                $oldPath = 'img/produk/' . $g->gambar;
                                if (Storage::disk('public')->exists($oldPath)) {
                                    Storage::disk('public')->delete($oldPath);
                                }
                            }
                            $g->update(['gambar' => $name]);
                            $preservedIds[$i] = $g->id;
                        } else {
                            $new = GambarProduk::create(['produk_id' => $produk->id, 'gambar' => $name, 'utama' => 0]);
                            $createdIds[$i] = $new->id;
                        }
                    } else {
                        $new = GambarProduk::create(['produk_id' => $produk->id, 'gambar' => $name, 'utama' => 0]);
                        $createdIds[$i] = $new->id;
                    }
                } else {
                    if ($toDelete) {
                        // delete existing if any
                        if ($existingId) {
                            $g = GambarProduk::where('id', $existingId)->where('produk_id', $produk->id)->first();
                            if ($g) {
                                if ($g->gambar) {
                                    $oldPath = 'img/produk/' . $g->gambar;
                                    if (Storage::disk('public')->exists($oldPath)) {
                                        Storage::disk('public')->delete($oldPath);
                                    }
                                }
                                $g->delete();
                            }
                        }
                        // nothing to preserve for this slot
                        $preservedIds[$i] = null;
                    } else {
                        // keep existing if present
                        if ($existingId) {
                            $preservedIds[$i] = $existingId;
                        } else {
                            $preservedIds[$i] = null;
                        }
                    }
                }
            }

            // set utama: reset all then apply
            GambarProduk::where('produk_id', $produk->id)->update(['utama' => 0]);
            $utama = $request->input('utama_gambar');
            if ($utama !== null) {
                if (is_string($utama)) {
                    if (str_starts_with($utama, 'existing_')) {
                        $parts = explode('_', $utama, 2);
                        $id = isset($parts[1]) ? (int)$parts[1] : null;
                        if ($id) {
                            GambarProduk::where('id', $id)->where('produk_id', $produk->id)->update(['utama' => 1]);
                        }
                    } elseif (str_starts_with($utama, 'new_')) {
                        $parts = explode('_', $utama, 2);
                        $slotIndex = isset($parts[1]) ? (int)$parts[1] : null;
                        if ($slotIndex !== null) {
                            if (isset($createdIds[$slotIndex]) && $createdIds[$slotIndex]) {
                                GambarProduk::where('id', $createdIds[$slotIndex])->where('produk_id', $produk->id)->update(['utama' => 1]);
                            } elseif (isset($preservedIds[$slotIndex]) && $preservedIds[$slotIndex]) {
                                GambarProduk::where('id', $preservedIds[$slotIndex])->where('produk_id', $produk->id)->update(['utama' => 1]);
                            }
                        }
                    } elseif (is_numeric($utama)) {
                        GambarProduk::where('id', (int)$utama)->where('produk_id', $produk->id)->update(['utama' => 1]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui produk.');
        }
    }

    public function destroy($id)
    {
        $produk = Produk::with('gambarProduks')->findOrFail($id);

        // If product exists in any cart, prevent deletion
        if ($produk->keranjang()->exists()) {
            return redirect()->route('admin.produk.index')->with('error', 'Produk ada dalam keranjang pengguna.');
        }

        DB::beginTransaction();
        try {
            // delete files from storage
            foreach ($produk->gambarProduks as $g) {
                if ($g->gambar) {
                    $path = 'img/produk/' . $g->gambar;
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
            }

            // delete all varian for this produk
            Varian::where('produk_id', $produk->id)->delete();

            // delete produk (gambar_produk rows will cascade)
            $produk->delete();

            DB::commit();
            return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return back()->with('error', 'Terjadi kesalahan saat menghapus produk.');
        }
    }

    /**
     * VARIAN
     */
    public function indexVarian($produkId)
    {
        $produk = Produk::findOrFail($produkId);
        $gambarProduks = $produk->gambarProduks()->where('utama', 1)->first();
        $varians = Varian::where('produk_id', $produkId)->get();

        return view('admin.produk.varian.index', [
            'produk' => $produk,
            'varians' => $varians,
            'gambarProduks' => $gambarProduks,
        ]);
    }

    public function storeVarian(Request $request, $produkId)
    {
        $produk = Produk::findOrFail($produkId);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'berat' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'is_default' => 'required|boolean',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
        ]);

        DB::beginTransaction();
        try {
            if ($validated['is_default']) {
                // reset existing default
                Varian::where('produk_id', $produk->id)->update(['is_default' => 0]);
            }

            $varianGambarName = null;
            if (isset($validated['gambar']) && $validated['gambar'] instanceof UploadedFile) {
                $orig = $validated['gambar']->getClientOriginalName();
                $varianGambarName = time() . '_varian_' . preg_replace('/[^A-Za-z0-9\._-]/', '_', $orig);
                $path = 'img/varian/' . $varianGambarName;
                Storage::disk('public')->put($path, file_get_contents($validated['gambar']));
            }

            Varian::create([
                'produk_id' => $produk->id,
                'nama' => $validated['nama'],
                'harga' => $validated['harga'],
                'berat' => $validated['berat'],
                'stok' => $validated['stok'],
                'is_default' => $validated['is_default'] ? 1 : 0,
                'gambar' => $varianGambarName,
            ]);

            DB::commit();

            return redirect()->route('admin.produk.varian.index', $produk->id)->with('success', 'Varian berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan varian.');
        }
    }

    public function updateVarian(Request $request, $produkId, $varianId)
    {
        $varian = Varian::findOrFail($varianId);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'berat' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'is_default' => 'required|boolean',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
        ]);

        DB::beginTransaction();
        try {
            // Validasi: jika varian ini default dan admin ingin ubah jadi non-default, tolak
            if ($varian->is_default == 1 && $validated['is_default'] == 0) {
                DB::rollBack();
                return back()->with('error', 'Varian default tidak boleh diubah menjadi non-default. Silakan pilih varian lain sebagai default terlebih dahulu.');
            }

            if ($validated['is_default']) {
                // reset existing default
                Varian::where('produk_id', $produkId)->update(['is_default' => 0]);
            }

            if (isset($validated['gambar']) && $validated['gambar'] instanceof UploadedFile) {
                // delete old file
                if ($varian->gambar) {
                    $oldPath = 'img/varian/' . $varian->gambar;
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                // store new file
                $orig = $validated['gambar']->getClientOriginalName();
                $varianGambarName = time() . '_varian_' . preg_replace('/[^A-Za-z0-9\._-]/', '_', $orig);
                $path = 'img/varian/' . $varianGambarName;
                Storage::disk('public')->put($path, file_get_contents($validated['gambar']));
                $varian->gambar = $varianGambarName;
            }

            $varian->update([
                'nama' => $validated['nama'],
                'harga' => $validated['harga'],
                'berat' => $validated['berat'],
                'stok' => $validated['stok'],
                'is_default' => $validated['is_default'] ? 1 : 0,
            ]);

            DB::commit();

            return redirect()->route('admin.produk.varian.index', $varian->produk_id)->with('success', 'Varian berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui varian.');
        }
    }

    public function destroyVarian($produkId, $varianId)
    {
        $varian = Varian::where('id', $varianId)->firstOrFail();

        DB::beginTransaction();
        try {
            // delete varian image file
            if ($varian->gambar) {
                $path = 'img/varian/' . $varian->gambar;
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }

            $varian->delete();

            DB::commit();
            return redirect()->route('admin.produk.varian.index', $produkId)->with('success', 'Varian berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return back()->with('error', 'Terjadi kesalahan saat menghapus varian.');
        }
    }
}
