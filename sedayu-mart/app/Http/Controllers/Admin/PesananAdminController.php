<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class PesananAdminController extends Controller
{
    public function index(Request $request)
    {
        // Load pesanan with related user and items (including produk for each item)
        $query = Pesanan::with(['user', 'items.produk']);

        // Search by user nama or product nama
        if ($request->has('search') && $request->input('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('nama', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('items.produk', function ($produkQuery) use ($search) {
                        $produkQuery->where('nama', 'like', '%' . $search . '%');
                    });
            });
        }

        // Filter by status
        if ($request->has('status') && $request->input('status')) {
            $status = $request->input('status');
            $query->where('status', $status);
        }

        $pesanans = $query->orderBy('created_at', 'desc')->get();

        return view('admin.pesanan.index', compact('pesanans'));
    }

    public function show($id)
    {
        $pesanan = Pesanan::with(['user', 'items.produk', 'items.produk.gambarProduks'])->findOrFail($id);

        return response()->json($pesanan, 200);
    }

    public function showVerifikasi($id)
    {
        try {
            // Load dengan semua relasi yang diperlukan untuk menampilkan modal
            $pesanan = Pesanan::with([
                'user',
                'items.produk.gambarProduks'
            ])->findOrFail($id);

            // Log untuk debugging
            Log::info('ShowVerifikasi called for pesanan ID: ' . $id);
            Log::info('Pesanan data: ', $pesanan->toArray());

            return response()->json($pesanan, 200);
        } catch (\Exception $e) {
            Log::error('Error in showVerifikasi: ' . $e->getMessage());
            return response()->json(['error' => 'Pesanan tidak ditemukan'], 404);
        }
    }

    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Diterima,Ditolak',
            'keterangan' => 'required_if:status,Ditolak|nullable|string',
        ]);

        try {
            $pesanan = Pesanan::findOrFail($id);
            $pesanan->status = $request->input('status');
            // Only store keterangan when rejected
            $pesanan->keterangan = $pesanan->status === 'Ditolak' ? $request->input('keterangan') : null;
            $pesanan->save();

            Log::info('Verifikasi completed for pesanan ID: ' . $id . ' with status: ' . $request->input('status'));

            return redirect()->route('admin.pesanan.index')->with('success', 'Status pesanan berhasil diperbarui menjadi ' . $request->input('status') . '.');
        } catch (\Exception $e) {
            Log::error('Error in verifikasi: ' . $e->getMessage());
            return redirect()->route('admin.pesanan.index')->with('error', 'Terjadi kesalahan saat memverifikasi pesanan.');
        }
    }

    public function showUpdateStatus($id)
    {
        try {
            $pesanan = Pesanan::with(['user', 'items.produk.gambarProduks'])->findOrFail($id);

            Log::info('ShowUpdateStatus called for pesanan ID: ' . $id);

            return response()->json($pesanan, 200);
        } catch (\Exception $e) {
            Log::error('Error in showUpdateStatus: ' . $e->getMessage());
            return response()->json(['error' => 'Pesanan tidak ditemukan'], 404);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            Log::info('updateStatus called', [
                'id' => $id,
                'request_data' => $request->all(),
                'status_input' => $request->input('status'),
            ]);

            $request->validate([
                'status' => 'required|in:Diterima,Dalam Pengiriman,Selesai',
            ]);

            $pesanan = Pesanan::findOrFail($id);
            $oldStatus = $pesanan->status;
            $pesanan->status = $request->input('status');
            $pesanan->save();

            Log::info('UpdateStatus completed', [
                'id' => $id,
                'old_status' => $oldStatus,
                'new_status' => $pesanan->status,
            ]);

            return redirect()->route('admin.pesanan.index')->with('success', 'Status pesanan berhasil diperbarui menjadi ' . $request->input('status') . '.');
        } catch (\Exception $e) {
            Log::error('Error in updateStatus: ' . $e->getMessage(), [
                'id' => $id,
                'exception' => $e,
            ]);
            return redirect()->route('admin.pesanan.index')->with('error', 'Terjadi kesalahan saat memperbarui status pesanan.');
        }
    }
}
