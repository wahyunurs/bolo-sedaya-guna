<?php

namespace App\Http\Controllers\API\Mobile;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TarifPengiriman;
use App\Models\AlamatPengiriman;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

            $profilData = [
                'profil' => [
                    'id' => $profilUser->id,
                    'nama' => $profilUser->nama,
                    'email' => $profilUser->email,
                    'alamat' => $profilUser->alamat,
                    'kabupaten' => $profilUser->kabupaten,
                    // 'provinsi' => $profilUser->provinsi,
                    'nomor_telepon' => $profilUser->nomor_telepon,
                    'avatar' => 'storage/img/profil/' . ($profilUser->avatar ? $profilUser->avatar : null),
                ],
                'statistik_pesanan' => [
                    'total_pesanan' => $pesananCount,
                    'pesanan_dikirim' => $dikirimCount,
                    'pesanan_selesai' => $selesaiCount,
                ],
            ];

            return $this->successResponse([
                'profil' => $profilData,
            ], 'Berhasil mengambil data profil pengguna');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }

    public function kabupatenDropdown(Request $request)
    {
        try {
            $user = Auth::user();

            $search = $request->query('search');

            $query = TarifPengiriman::select('kabupaten')->distinct();
            if ($search) {
                $query->where('kabupaten', 'like', '%' . $search . '%');
            }
            $kabupatens = $query->orderBy('kabupaten', 'asc')->get()->pluck('kabupaten');

            return $this->successResponse([
                'user' => [
                    'id'   => $user->id,
                    'nama' => $user->nama,
                ],
                'kabupaten' => $kabupatens,
            ], 'Berhasil mengambil data kabupaten untuk dropdown');
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

            $profilData = [
                'id' => $profil->id,
                'nama' => $profil->nama,
                'email' => $profil->email,
                'alamat' => $profil->alamat,
                'kabupaten' => $profil->kabupaten,
                // 'provinsi' => $profil->provinsi,
                'nomor_telepon' => $profil->nomor_telepon,
                'avatar' => 'storage/img/profil/' . ($profil->avatar ? $profil->avatar : null),
            ];
            return $this->successResponse($profilData, 'Berhasil mengambil data profil pengguna');
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

            if ($request->hasFile('avatar')) {
                // Hapus foto lama jika ada
                if ($profil->avatar && Storage::disk('public')->exists($profil->avatar)) {
                    Storage::disk('public')->delete($profil->avatar);
                }
                $file = $request->file('avatar');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->storeAs('img/profil', $fileName, 'public');
                $profil->avatar = 'img/profil/' . $fileName;
            }

            $profil->update([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'kabupaten' => $request->kabupaten,
                // 'provinsi' => $request->provinsi,
                'nomor_telepon' => $request->nomor_telepon,
                'avatar' => $profil->avatar,
            ]);

            return $this->successResponse($user, 'Data profil berhasil diperbarui');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }


    /**
     * Alamatan Pengiriman
     */
    public function alamatPengiriman(Request $request)
    {
        try {
            $user = Auth::user();

            $alamatPengirimen = AlamatPengiriman::where('user_id', $user->id)->get();

            if ($alamatPengirimen->isEmpty()) {
                return $this->successResponse([
                    'user' => [
                        'id'   => $user->id,
                        'nama' => $user->nama,
                    ],
                    'alamat_pengiriman' => [],
                ], 'Belum ada alamat pengiriman yang ditambahkan');
            }

            return $this->successResponse([
                'user' => [
                    'id'   => $user->id,
                    'nama' => $user->nama,
                ],
                'alamat_pengiriman' => $alamatPengirimen,
            ], 'Berhasil mengambil data alamat pengiriman');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }

    public function tambahAlamatPengiriman(Request $request)
    {
        try {
            $user = Auth::user();

            // Validasi request
            $request->validate([
                'nama_penerima'  => 'required|string|max:255',
                'nomor_telepon' => 'required|string|max:20',
                'alamat'    => 'required|string|max:500',
                'kabupaten'    => 'required|string|max:255',
                'provinsi'    => 'required|string|in:Jawa Tengah|max:100',
                'kode_pos'    => 'required|string|max:10',
                'keterangan'    => 'nullable|string|max:1000',
                'utama'    => 'sometimes|boolean',
            ]);

            // Jika alamat utama, set semua alamat lain menjadi bukan utama
            if ($request->has('utama') && $request->utama) {
                AlamatPengiriman::where('user_id', $user->id)->update(['utama' => false]);
            }

            $alamatPengiriman = AlamatPengiriman::create([
                'user_id' => $user->id,
                'nama_penerima' => $request->nama_penerima,
                'nomor_telepon' => $request->nomor_telepon,
                'alamat' => $request->alamat,
                'kabupaten' => $request->kabupaten,
                'provinsi' => $request->provinsi,
                'kode_pos' => $request->kode_pos,
                'keterangan' => $request->keterangan,
                'utama' => $request->has('utama') ? $request->utama : false,
            ]);

            return $this->successResponse([
                'user' => [
                    'id'   => $user->id,
                    'nama' => $user->nama,
                ],
                'alamat_pengiriman' => $alamatPengiriman,
            ], 'Alamat pengiriman berhasil ditambahkan');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }

    public function updateAlamatPengiriman(Request $request, $alamatId)
    {
        try {
            $user = Auth::user();

            $alamatPengiriman = AlamatPengiriman::where('user_id', $user->id)->where('id', $alamatId)->first();
            if (! $alamatPengiriman) {
                return $this->successResponse([], 'Alamat pengiriman tidak ditemukan');
            }

            // Validasi request
            $request->validate([
                'nama_penerima'  => 'sometimes|string|max:255',
                'nomor_telepon' => 'sometimes|string|max:20',
                'alamat'    => 'sometimes|string|max:500',
                'kabupaten'    => 'sometimes|string|max:255',
                'provinsi'    => 'sometimes|string|in:Jawa Tengah|max:100',
                'kode_pos'    => 'sometimes|string|max:10',
                'keterangan'    => 'nullable|string|max:1000',
                'utama'    => 'sometimes|boolean',
            ]);

            // Jika alamat utama, set semua alamat lain menjadi bukan utama
            if ($request->has('utama') && $request->utama) {
                AlamatPengiriman::where('user_id', $user->id)->update(['utama' => false]);
            }

            // Update data alamat pengiriman
            $alamatPengiriman->update($request->only([
                'nama_penerima',
                'nomor_telepon',
                'alamat',
                'kabupaten',
                'provinsi',
                'kode_pos',
                'keterangan',
                'utama',
            ]));

            return $this->successResponse([
                'user' => [
                    'id'   => $user->id,
                    'nama' => $user->nama,
                ],
                'alamat_pengiriman' => $alamatPengiriman,
            ], 'Alamat pengiriman berhasil diperbarui');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }

    public function hapusAlamatPengiriman(Request $request, $alamatId)
    {
        try {
            $user = Auth::user();

            $alamatPengiriman = AlamatPengiriman::where('user_id', $user->id)->where('id', $alamatId)->first();
            if (! $alamatPengiriman) {
                return $this->successResponse([], 'Alamat pengiriman tidak ditemukan');
            }

            $isUtama = $alamatPengiriman->utama == 1;
            $alamatPengiriman->delete();

            // Jika yang dihapus adalah utama, set alamat pertama user menjadi utama
            if ($isUtama) {
                $alamatBaruUtama = AlamatPengiriman::where('user_id', $user->id)->orderBy('id', 'asc')->first();
                if ($alamatBaruUtama) {
                    $alamatBaruUtama->update(['utama' => 1]);
                }
            }

            return $this->successResponse([
                'user' => [
                    'id'   => $user->id,
                    'nama' => $user->nama,
                ],
            ], 'Alamat pengiriman berhasil dihapus');
        } catch (\Throwable $e) {
            return $this->exceptionError($e, $e->getMessage(), 500);
        }
    }
}
