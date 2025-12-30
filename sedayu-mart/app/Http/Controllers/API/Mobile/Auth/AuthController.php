<?php

namespace App\Http\Controllers\API\Mobile\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Register Mobile
     */
    public function register(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
            'status'   => 'aktif',
            'is_onboarded' => true, // register manual = data cukup
        ]);

        $token = $user->createToken('mobile_auth')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Register berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'need_onboarding' => false,
            'data' => $user,
        ], 201);
    }


    /**
     * Login Mobile (Email + Password)
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email'    => 'required|email',
                'password' => 'required',
            ]);

            if (! Auth::attempt($request->only('email', 'password'))) {
                throw ValidationException::withMessages([
                    'email' => 'Email atau password salah.',
                ]);
            }

            $user = Auth::user();

            if ($user->status === 'blokir') {
                Auth::logout();
                return response()->json([
                    'success' => false,
                    'message' => 'Akun Anda diblokir.',
                ], 403);
            }

            $token = $user->createToken('mobile_auth')->plainTextToken;

            return response()->json([
                'success'      => true,
                'message'      => 'Login berhasil',
                'access_token' => $token,
                'token_type'   => 'Bearer',
                'data' => [
                    'id'    => $user->id,
                    'nama'  => $user->nama,
                    'email' => $user->email,
                    'role'  => $user->role,
                ],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Login Google (Mobile)
     */
    public function loginGoogle(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')
                ->stateless()
                ->userFromToken($request->google_token);

            $user = User::where('email', $googleUser->email)->first();

            if (! $user) {
                $user = User::create([
                    'nama'     => $googleUser->name,
                    'email'    => $googleUser->email,
                    'password' => Hash::make(Str::before($googleUser->email, '@')),
                    'google_id' => $googleUser->id,
                    'avatar'   => $googleUser->avatar,
                    'role'     => 'user',
                    'status'   => 'aktif',
                    'is_onboarded' => false, // 🔥 WAJIB onboarding
                ]);
            } else {
                $user->update([
                    'google_id' => $googleUser->id,
                    'avatar'    => $googleUser->avatar ?? $user->avatar,
                ]);
            }

            $token = $user->createToken('mobile_auth')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login Google berhasil',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'need_onboarding' => ! $user->is_onboarded, // 🔑 FLAG PENTING
                'data' => [
                    'id'    => $user->id,
                    'nama'  => $user->nama,
                    'email' => $user->email,
                    'role'  => $user->role,
                ],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Login Google gagal',
            ], 401);
        }
    }



    /**
     * Logout Mobile
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }

    /**
     * Reset Password Mobile
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = $request->user();

        if (! Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password lama salah',
            ], 403);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diperbarui',
        ]);
    }

    /**
     * Get Current User
     */
    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user(),
        ]);
    }
}
