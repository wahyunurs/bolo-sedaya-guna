<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AlamatPengiriman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilUserController extends Controller
{
    /**
     * PROFIL MENU
     */
    public function index()
    {
        $user = Auth::user();
        return view('user.profil.index', [
            'user' => $user,
        ]);
    }

    /**
     * ALAMAT PENGIRIMAN
     */
    public function alamatPengiriman()
    {
        $user = Auth::user();
        $alamatPengirimans = AlamatPengiriman::where('user_id', $user->id)->get();

        return view('user.profil.alamat-pengiriman.index', [
            'user' => $user,
            'alamatPengirimans' => $alamatPengirimans,
        ]);
    }

    public function createAlamatPengiriman()
    {
        $user = Auth::user();
        return view('user.profil.alamat-pengiriman.create', [
            'user' => $user,
        ]);
    }

    public function storeAlamatPengiriman(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'kabupaten' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kode_pos' => 'required|string|max:10',
            'keterangan' => 'nullable|string|max:500',
            'utama' => 'nullable|boolean',
        ]);

        $validatedData['user_id'] = $user->id;

        // Only one address can be utama (main)
        if (isset($validatedData['utama']) && $validatedData['utama']) {
            AlamatPengiriman::where('user_id', $user->id)->update(['utama' => 0]);
            $validatedData['utama'] = 1;
        } else {
            $validatedData['utama'] = 0;
        }

        AlamatPengiriman::create($validatedData);

        return redirect()->route('user.profil.alamatPengiriman')->with('success', 'Alamat pengiriman berhasil ditambahkan.');
    }

    public function editAlamatPengiriman($id)
    {
        $user = Auth::user();
        $alamatPengiriman = AlamatPengiriman::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        return view('user.profil.alamat-pengiriman.edit', [
            'user' => $user,
            'alamatPengiriman' => $alamatPengiriman,
        ]);
    }

    public function updateAlamatPengiriman(Request $request, $id)
    {
        $user = Auth::user();
        $alamatPengiriman = AlamatPengiriman::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $validatedData = $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'kabupaten' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kode_pos' => 'required|string|max:10',
            'keterangan' => 'nullable|string|max:500',
            'utama' => 'nullable|boolean',
        ]);

        // Only one address can be utama (main)
        if (isset($validatedData['utama']) && $validatedData['utama']) {
            AlamatPengiriman::where('user_id', $user->id)->update(['utama' => 0]);
            $validatedData['utama'] = 1;
        } else {
            $validatedData['utama'] = 0;
        }

        $alamatPengiriman->update($validatedData);

        return redirect()->route('user.profil.alamatPengiriman')->with('success', 'Alamat pengiriman berhasil diperbarui.');
    }

    public function destroyAlamatPengiriman($id)
    {
        $user = Auth::user();
        $alamatPengiriman = AlamatPengiriman::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $alamatPengiriman->delete();

        return redirect()->route('user.profil.alamatPengiriman')->with('success', 'Alamat pengiriman berhasil dihapus.');
    }

    /**
     * DATA DIRI
     */
    public function dataDiri()
    {
        $user = Auth::user();

        return view('user.profil.data-diri.index', [
            'user' => $user,
        ]);
    }

    public function editDataDiri()
    {
        $user = Auth::user();

        return view('user.profil.data-diri.edit', [
            'user' => $user,
        ]);
    }

    public function updateDataDiri(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'kabupaten' => 'required|string|max:100',
            'nomor_telepon' => 'required|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);
        if ($request->hasFile('avatar')) {
            $avatarFile = $request->file('avatar');
            $newFileName = 'avatar_' . time() . '.' . $avatarFile->getClientOriginalExtension();

            // store in storage/app/public/img/avatars
            $path = 'img/avatars/' . $newFileName;
            Storage::disk('public')->putFileAs('img/avatars', $avatarFile, $newFileName);

            // Delete old avatar file if exists
            if ($user->avatar) {
                $oldPath = 'img/avatars/' . $user->avatar;
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $validatedData['avatar'] = $newFileName;
        }

        $user->update($validatedData);

        return redirect()->route('user.profil.dataDiri')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * GANTI PASSWORD
     */
    public function gantiPassword()
    {
        $user = Auth::user();
        return view('user.profil.ganti-password.index', [
            'user' => $user,
        ]);
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Cek kecocokan password saat ini
        if (!password_verify($validatedData['current_password'], $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        // Update password
        $user->password = bcrypt($validatedData['new_password']);
        $user->save();

        return redirect()->route('user.profil.gantiPassword')->with('success', 'Password berhasil diperbarui.');
    }
}
