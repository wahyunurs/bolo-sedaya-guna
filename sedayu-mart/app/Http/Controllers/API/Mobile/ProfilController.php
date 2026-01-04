<?php

namespace App\Http\Controllers\API\Mobile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            $profilUser = User::where('id', $user->id)->first();

            $pesananCount = $profilUser->pesanan()->count();
            $dikirimCount = $profilUser->pesanan()->where('status', 'Dalam Pengiriman')->count();
            $selesaiCount = $profilUser->pesanan()->where('status', 'Selesai')->count();

            $statistikPesanan = [
                'total_pesanan' => $pesananCount,
                'pesanan_dikirim' => $dikirimCount,
                'pesanan_selesai' => $selesaiCount,
            ];

            return $this->successResponse([
                'user' => $user,
                'statistik_pesanan' => $statistikPesanan,
            ], 'Berhasil mengambil data profil pengguna');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }

    /**
     * Edit Profil
     */
    public function profil(Request $request)
    {
        try {
            $user = Auth::user();

            $profil = User::where('id', $user->id)->first();

            return $this->successResponse($profil, 'Berhasil mengambil data profil pengguna');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }

    public function updateProfil(Request $request)
    {
        try {
            $user = Auth::user();
            $profil = User::where('id', $user->id)->first();

            $request->validate([
                'nama' => 'required|string|max:255',
                'alamat' => 'required|string|max:500',
                'kabupaten' => 'required|string|max:255',
                // 'provinsi' => 'required|string|max:255',
                'nomor_telepon' => 'required|string|max:50',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            ]);

            // Handle foto upload
            if ($request->hasFile('avatar')) {
                // Delete old photo if exists
                $oldPhotoPath = public_path('storage/img/profil/' . $profil->avatar);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }

                // Upload new photo
                $imageName = time() . '-' . $request->file('avatar')->getClientOriginalName();
                $request->file('avatar')->move(public_path('storage/img/profil'), $imageName);
                $validatedData['avatar'] = $imageName;
            } else {
                // Keep old photo if no new photo uploaded
                unset($validatedData['avatar']);
            }

            $profil->update([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'kabupaten' => $request->kabupaten,
                // 'provinsi' => $request->provinsi,
                'nomor_telepon' => $request->nomor_telepon,
            ]);

            return $this->successResponse($user, 'Berhasil memperbarui data profil pengguna');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }
}
