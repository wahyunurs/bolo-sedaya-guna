<!-- Auth Layout -->
@extends('auth.components.layout')
@section('content')
    <!-- Wrapper -->
    <section class="min-h-screen flex items-center justify-center bg-[#e5ffda]"
        style="background-size: cover; background-position: center; background-repeat: no-repeat;">
        <!-- Main container -->
        <div class="flex w-full max-w-4xl bg-[#ffffff] rounded-3xl shadow-lg overflow-hidden">
            <!-- Right side (image) - moved to first column -->
            <div class="w-1/2 flex items-center justify-center p-8">
                <div class="relative w-full h-full flex items-center justify-center">

                    <div class="relative">
                        <img src="{{ asset('img/card/auth.png') }}" alt="Login Illustration"
                            class="rounded-3xl w-[400px] h-auto object-contain animate-blink-slow">
                    </div>
                </div>
            </div>

            <!-- Left side (form) - moved to second column -->
            <div class="w-1/2 p-10">
                <!-- Logo -->
                <div class="flex items-center justify-center mb-4 gap-3">
                    <img src="{{ asset('img/logo/sedayumart.png') }}" alt="SedayuMart" class="w-10 h-auto">
                    <div class="text-xl font-bold">
                        <span class="text-[#065f46]">Sedayu</span><span class="text-[#FBBF24]">Mart</span>
                    </div>
                </div>

                <!-- Title -->
                <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Masuk ke Akun Anda</h2>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <!-- Email Address -->
                    <div class="mb-5">
                        <div class="relative mt-1">
                            <span id="emailIconWrap"
                                class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 transition-colors duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-mail-icon lucide-mail">
                                    <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7" />
                                    <rect x="2" y="4" width="20" height="16" rx="2" />
                                </svg>
                            </span>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                autofocus autocomplete="username"
                                class="block w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
                                placeholder="Alamat Email" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <div class="relative mt-1">
                            <!-- Icon kiri (lock) -->
                            <span id="passwordIconWrap"
                                class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-lock-keyhole-icon lucide-lock-keyhole">
                                    <circle cx="12" cy="16" r="1" />
                                    <rect x="3" y="10" width="18" height="12" rx="2" />
                                    <path d="M7 10V7a5 5 0 0 1 10 0v3" />
                                </svg>
                            </span>

                            <!-- Input password -->
                            <input id="password" name="password" type="password" required autocomplete="current-password"
                                class="block w-full pl-9 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
                                placeholder="Kata Sandi" />

                            <!-- Icon kanan (toggle visibility) -->
                            <button type="button" id="togglePassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 focus:outline-none">
                                <!-- Eye (default visible) -->
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye">
                                    <path
                                        d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>

                                <!-- Eye Closed (hidden by default) -->
                                <svg id="eyeClosedIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-closed hidden">
                                    <path d="m15 18-.722-3.25" />
                                    <path d="M2 8a10.645 10.645 0 0 0 20 0" />
                                    <path d="m20 15-1.726-2.05" />
                                    <path d="m4 15 1.726-2.05" />
                                    <path d="m9 18 .722-3.25" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Forgot Password Link -->
                    @if (Route::has('password.request'))
                        <div class="text-right mb-3">
                            <a href="{{ route('password.request') }}"
                                class="text-sm text-green-500 hover:text-green-800 font-medium">
                                Lupa Kata Sandi?
                            </a>
                        </div>
                    @endif

                    <!-- Login Button -->
                    <div class="mt-6">
                        <button type="submit"
                            class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg font-semibold shadow-sm transition duration-200">
                            Masuk
                        </button>
                    </div>

                    <!-- Login with Others -->
                    <div class="my-4 flex items-center">
                        <div class="flex-1 h-px bg-gray-300"></div>
                        <div class="px-4 text-center text-gray-500 text-sm">Atau masuk dengan</div>
                        <div class="flex-1 h-px bg-gray-300"></div>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ route('auth.redirect') }}"
                            class="w-full flex items-center justify-center gap-2 border border-gray-300 rounded-lg py-2 hover:bg-gray-50 transition">
                            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5"
                                alt="google">
                            <span class="text-sm text-gray-700">Masuk dengan Google</span>
                        </a>
                    </div>

                    <div class="text-center mt-10 text-sm text-gray-600">
                        Belum memiliki Akun? <a href="{{ route('register') }}"
                            class="text-green-600 hover:underline font-medium">Daftar</a>
                    </div>
                </form>
            </div>

            @vite('resources/js/auth/login.js')
        </div>
    </section>
@endsection
