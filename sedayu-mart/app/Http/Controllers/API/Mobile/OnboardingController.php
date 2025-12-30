<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    /**
     * Get onboarding data (old value)
     */
    public function index(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data' => [
                'nama'           => $user->nama,
                'email'          => $user->email,
                'nomor_telepon'  => $user->nomor_telepon,
                'alamat'         => $user->alamat,
                'kabupaten'      => $user->kabupaten,
                'avatar'         => $user->avatar,
                'onboarded'      => $user->onboarded,
            ],
        ]);
    }
    /**
     * Submit onboarding data
     */
    public function store(Request $request)
    {
        $user = $request->user();

        // Jika sudah onboarding, tidak perlu ulang
        if ($user->onboarded ?? false) {
            return response()->json([
                'success' => true,
                'message' => 'User already onboarded',
                'data' => $user,
            ]);
        }

        $validated = $request->validate([
            'nama'            => 'required|string|max:255',
            'nomor_telepon'   => 'required|string|max:20',
            'alamat'          => 'required|string',
            'kabupaten'       => 'required|string|max:100',
        ]);

        $user->update([
            'nama'            => $validated['nama'],
            'nomor_telepon'   => $validated['nomor_telepon'],
            'alamat'          => $validated['alamat'],
            'kabupaten'       => $validated['kabupaten'],
            'onboarded'       => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Onboarding berhasil',
            'data' => [
                'id'              => $user->id,
                'nama'            => $user->nama,
                'email'           => $user->email,
                'nomor_telepon'   => $user->nomor_telepon,
                'alamat'          => $user->alamat,
                'kabupaten'       => $user->kabupaten,
                'role'            => $user->role,
                'onboarded'       => true,
            ],
        ]);
    }
}
