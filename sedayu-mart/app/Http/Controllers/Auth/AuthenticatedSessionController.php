<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\Auth\LoginRequest;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();
        } catch (\Throwable $e) {
            // Pastikan setiap kegagalan autentikasi mengembalikan pesan field-spesifik
            throw ValidationException::withMessages($this->loginErrorMessage($request));
        }

        $request->session()->regenerate();

        $user = Auth::user();
        $default = $this->redirectForRole($user->role ?? null);

        return redirect()->intended($default);
    }

    /**
     * Login error message based on email existence.
     */
    protected function loginErrorMessage(LoginRequest $request): array
    {
        $email = (string) $request->input('email');
        $emailExists = User::where('email', $email)->exists();

        // Jika email tidak terdaftar, tampilkan error pada field email
        if (! $emailExists) {
            return [
                'email' => 'Email tidak terdaftar.',
            ];
        }

        // Jika email ada namun autentikasi gagal, arahkan pesan ke field password
        return [
            'password' => 'Kata sandi salah.',
        ];
    }

    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback from Google and authenticate the user locally.
     */
    public function callback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google authentication failed.');
        }

        // find existing user by google_id or email, create if not found
        $user = User::where('google_id', $googleUser->id)
            ->orWhere('email', $googleUser->email)
            ->first();

        if (! $user) {
            // Note: migration requires 'alamat' and 'nomor_telepon' non-nullable.
            // Provide safe defaults here; consider making the columns nullable instead.
            $user = User::create([
                'nama' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken ?? null,
                'avatar' => $googleUser->avatar ?? null,
                'alamat' => '',
                'nomor_telepon' => '',
            ]);
        } else {
            // ensure google fields are set
            $user->google_id = $googleUser->id;
            $user->google_token = $googleUser->token;
            $user->google_refresh_token = $googleUser->refreshToken ?? null;
            // update avatar if provided by Google
            if (! empty($googleUser->avatar)) {
                $user->avatar = $googleUser->avatar;
            }
            $user->save();
        }

        Auth::login($user);

        $default = $this->redirectForRole($user->role ?? null);
        return redirect()->intended($default);
    }

    /**
     * Return default redirect path based on role.
     */
    protected function redirectForRole(?string $role): string
    {
        if ($role === 'admin') {
            return route('admin.dashboard');
        }

        return route('user.dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
