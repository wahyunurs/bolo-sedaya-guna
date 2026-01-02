<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\TarifPengiriman;
use App\Models\AlamatPengiriman;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OnboardingController extends Controller
{
    /**
     * Show onboarding form (old data included)
     */
    public function index()
    {
        $user = Auth::user();

        // Kalau sudah onboarded, jangan boleh masuk lagi
        if ($user->onboarded) {
            return redirect()->route('user.beranda');
        }


        $kabupatens = TarifPengiriman::orderBy('kabupaten')->pluck('kabupaten');

        return view('user.onboarding', compact('user', 'kabupatens'));
    }

    /**
     * Store onboarding data
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->onboarded) {
            return redirect()->route('user.beranda');
        }

        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'alamat'        => 'required|string',
            'kabupaten'     => 'required|string|max:100',
        ]);

        $user->update(array_merge($validated, [
            'onboarded' => true,
        ]));

        // Buat alamat pengiriman utama
        AlamatPengiriman::create([
            'user_id' => $user->id,
            'nama_penerima' => $validated['nama'],
            'nomor_telepon' => $validated['nomor_telepon'],
            'alamat' => $validated['alamat'],
            'kabupaten' => $validated['kabupaten'],
            'provinsi' => 'Jawa Tengah',
            'kode_pos' => '',
            'keterangan' => null,
            'utama' => 1,
        ]);

        return redirect()
            ->route('user.beranda')
            ->with('success', 'Profil berhasil dilengkapi');
    }
}
