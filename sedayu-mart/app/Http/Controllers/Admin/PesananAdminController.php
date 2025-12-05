<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PesananAdminController extends Controller
{
    public function index()
    {
        // Load pesanan with related user and items (including produk for each item)
        $pesanans = \App\Models\Pesanan::with(['user', 'items.produk'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pesanan.index', compact('pesanans'));
    }

    public function show($id)
    {
        $pesanan = Pesanan::with(['user', 'items.produk'])->findOrFail($id);

        return view('admin.pesanan.show', compact('pesanan'));
    }

    public function showVerifikasi($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        return view('admin.pesanan.verifikasi', compact('pesanan'));
    }

    public function verifikasi(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // Logic to verify payment proof
        $pesanan->status = 'Diterima';
        $pesanan->save();

        return redirect()->route('admin.pesanan.index')->with('success', 'Pembayaran pesanan berhasil diverifikasi.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Processing,Shipped,Delivered,Canceled',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status = $request->input('status');
        $pesanan->save();

        return redirect()->route('admin.pesanan.index')->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
