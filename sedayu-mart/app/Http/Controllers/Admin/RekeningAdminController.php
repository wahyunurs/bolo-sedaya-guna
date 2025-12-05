<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rekening;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RekeningAdminController extends Controller
{
    public function index()
    {
        $rekening = Rekening::all();

        return view('admin.rekening.index', compact('rekening'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bank' => 'required|string|max:100',
            'nomor_rekening' => 'required|string|max:50',
            'atas_nama' => 'required|string|max:100',
        ]);

        Rekening::create([
            'nama_bank' => $request->input('nama_bank'),
            'nomor_rekening' => $request->input('nomor_rekening'),
            'atas_nama' => $request->input('atas_nama'),
        ]);

        return redirect()->route('admin.rekening.index')->with('success', 'Rekening berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $rekening = Rekening::findOrFail($id);

        return response()->json($rekening);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_bank' => 'required|string|max:100',
            'nomor_rekening' => 'required|string|max:50',
            'atas_nama' => 'required|string|max:100',
        ]);

        $rekening = Rekening::findOrFail($id);
        $rekening->update([
            'nama_bank' => $request->input('nama_bank'),
            'nomor_rekening' => $request->input('nomor_rekening'),
            'atas_nama' => $request->input('atas_nama'),
        ]);

        return redirect()->route('admin.rekening.index')->with('success', 'Rekening berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $rekening = Rekening::findOrFail($id);
        $rekening->delete();

        return redirect()->route('admin.rekening.index')->with('success', 'Rekening berhasil dihapus.');
    }
}
