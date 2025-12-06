<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
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
    public function store(Request $request): RedirectResponse
    {
        // Inline validate request
        $validated = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $email = (string) $validated['email'];
        $password = (string) $validated['password'];
        $remember = $request->boolean('remember');

        // Check email existence first for specific error placement
        $user = User::where('email', $email)->first();
        if (! $user) {
            throw ValidationException::withMessages([
                'email' => 'Email tidak terdaftar.',
            ]);
        }

        if (! Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            throw ValidationException::withMessages([
                'password' => 'Kata sandi salah.',
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();
        $destination = $this->redirectForRole($user);

        // Selalu arahkan sesuai role; abaikan intended URL yang bisa mengarah ke '/'
        $request->session()->forget('url.intended');

        return redirect()->to($destination);
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

        $destination = $this->redirectForRole($user);
        // Selalu arahkan sesuai role; abaikan intended URL yang bisa mengarah ke '/'
        $request->session()->forget('url.intended');

        return redirect()->to($destination);
    }

    /**
     * Return default redirect path based on role.
     */
    protected function redirectForRole(User $user): string
    {
        $role = strtolower((string) $user->role);

        if ($role === 'admin') {
            return route('admin.dashboard');
        }

        if ($role === 'user') {
            return route('user.beranda');
        }

        // fallback ke halaman guest jika role tidak dikenal
        return route('guest.beranda');
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
