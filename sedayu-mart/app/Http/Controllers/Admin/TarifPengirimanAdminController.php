<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TarifPengiriman;

class TarifPengirimanAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = TarifPengiriman::query();

        if ($search = $request->input('search')) {
            $query->where('kabupaten', 'like', '%' . $search . '%');
        }

        $tarifPengiriman = $query->orderBy('kabupaten')->get();

        return view('admin.tarif_pengiriman.index', compact('tarifPengiriman'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'kabupaten' => 'required|string|max:100',
            'tarif_per_kg' => 'required|numeric|min:0',
        ]);

        $tarif = new TarifPengiriman();
        $tarif->kabupaten = $request->input('kabupaten');
        $tarif->tarif_per_kg = $request->input('tarif_per_kg');
        $tarif->save();

        return redirect()->route('admin.tarifPengiriman.index')->with('success', 'Tarif pengiriman berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $tarif = TarifPengiriman::findOrFail($id);

        return view('admin.tarif_pengiriman.edit', compact('tarif'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kabupaten' => 'required|string|max:100',
            'tarif_per_kg' => 'required|numeric|min:0',
        ]);

        $tarif = TarifPengiriman::findOrFail($id);
        $tarif->kabupaten = $request->input('kabupaten');
        $tarif->tarif_per_kg = $request->input('tarif_per_kg');
        $tarif->save();

        return redirect()->route('admin.tarifPengiriman.index')->with('success', 'Tarif pengiriman berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $tarif = TarifPengiriman::findOrFail($id);
        $tarif->delete();

        return redirect()->route('admin.tarifPengiriman.index')->with('success', 'Tarif pengiriman berhasil dihapus.');
    }
}
