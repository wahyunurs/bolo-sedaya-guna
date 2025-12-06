<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route;
use App\Models\TarifPengiriman;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $kabupatens = TarifPengiriman::orderBy('kabupaten')->pluck('kabupaten');
        return view('auth.register', compact('kabupatens'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:500'],
            'kabupaten' => ['required', 'string', 'max:255'],
            // 'provinsi' => ['required', 'string', 'max:255'],
            'nomor_telepon' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create user with the fields matching the users table (excluding avatar and google attributes)
        $user = User::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'kabupaten' => $request->kabupaten,
            // 'provinsi' => $request->provinsi,
            'nomor_telepon' => $request->nomor_telepon,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        event(new Registered($user));

        Auth::login($user);

        // redirect based on role (if admin route exists send to admin area)
        $role = $user->role ?? null;
        if ($role === 'admin') {
            if (Route::has('admin.dashboard')) {
                return redirect(route('admin.dashboard', absolute: false));
            }

            return redirect('/admin');
        }

        return redirect(route('user.beranda', absolute: false));
    }
}
