<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

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
     * Handle login request (secured).
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $throttleKey = Str::lower($request->input('email')) . '|' . $request->ip();

        // ⛔ Rate limit login
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            throw ValidationException::withMessages([
                'email' => __('Terlalu banyak percobaan login. Coba lagi beberapa saat.'),
            ]);
        }

        if (! Auth::attempt($request->only('email', 'password'))) {
            RateLimiter::hit($throttleKey, 60);

            throw ValidationException::withMessages([
                'email' => __('Email atau kata sandi salah.'), // unified error
            ]);
        }

        RateLimiter::clear($throttleKey);

        $request->session()->regenerate();

        $user = Auth::user();

        // ⛔ Optional: cek status user
        if ($user->status === 'blokir') {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => 'Akun Anda diblokir. Hubungi admin.',
            ]);
        }

        $request->session()->forget('url.intended');

        return redirect()->to($this->redirectForRole($user));
    }

    /**
     * Redirect to Google OAuth.
     */
    public function redirect()
    {
        return Socialite::driver('google')
            ->stateless()
            ->redirect();
    }

    /**
     * Handle Google OAuth callback.
     */
    public function callback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')
                ->stateless()
                ->user();
        } catch (\Throwable $e) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Login Google gagal.']);
        }

        $user = User::where('email', $googleUser->email)->first();

        if (! $user) {
            $user = User::create([
                'nama' => $googleUser->name,
                'email' => $googleUser->email,
                // 'password' => Hash::make(Str::random(32)), // important
                'password' => Hash::make(Str::before($googleUser->email, '@')),
                'role' => 'user',
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                'status' => 'aktif',
            ]);
        } else {
            $user->update([
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar ?? $user->avatar,
            ]);
        }

        Auth::login($user, true);

        $request->session()->regenerate();
        $request->session()->forget('url.intended');

        return redirect()->to($this->redirectForRole($user));
    }

    /**
     * Role-based redirect.
     */
    protected function redirectForRole(User $user): string
    {
        return match ($user->role) {
            'admin' => route('admin.dashboard'),
            'user' => route('user.beranda'),
            default => route('guest.beranda'),
        };
    }

    /**
     * Logout.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
