<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilUserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('user.profil.index', [
            'user' => $user,
        ]);
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.profil.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request)
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

        return redirect()->route('user.profil.index')->with('success', 'Profil berhasil diperbarui.');
    }
}
