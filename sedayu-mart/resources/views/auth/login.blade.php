<!-- Auth Layout -->
@extends('auth.components.layout')

@section('content')
    <!-- Wrapper -->
    <div class="min-h-screen h-screen flex items-center justify-center bg-[#e5ffda] overflow-hidden px-4 sm:px-6">

        <!-- Main container -->
        <div class="flex w-[900px] max-w-[95%] h-[80vh] bg-white rounded-3xl shadow-lg overflow-hidden">
            <!-- Left side (image) - hidden on mobile, visible on lg -->
            <div
                class="hidden lg:flex lg:w-1/2 min-h-full items-stretch justify-center p-0 bg-gradient-to-br from-green-50 to-green-100">
                <div class="relative w-full h-full flex items-center justify-center">
                    <img src="{{ asset('img/card/auth.png') }}" alt="Login Illustration"
                        class="w-full h-full object-cover rounded-l-2xl sm:rounded-l-3xl rounded-tr-none rounded-br-none animate-blink-slow">
                </div>
            </div>

            <!-- Right side (form) - full width on mobile, half on lg -->
            <div class="w-full lg:w-1/2 p-4 sm:p-6 lg:p-8 overflow-y-auto min-h-full flex flex-col justify-center"
                style="direction: rtl;">
                <!-- Logo -->
                <div class="flex items-center justify-center mb-3 sm:mb-4 gap-2 sm:gap-3">
                    <img src="{{ asset('img/logo/sedayumart.png') }}" alt="SedayuMart" class="w-8 sm:w-10 h-auto">
                    <div class="text-base sm:text-lg lg:text-xl font-bold">
                        <span class="text-[#065f46]">Sedayu</span><span class="text-[#FBBF24]">Mart</span>
                    </div>
                </div>

                <!-- Title -->
                <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-center text-gray-800 mb-4 sm:mb-6">Masuk ke Akun
                    Anda</h2>

                <!-- Session Status -->
                <x-auth-session-status class="mb-3 sm:mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" style="direction: ltr;">
                    @csrf
                    <!-- Email Address -->
                    <div class="mb-4 sm:mb-5">
                        <div class="relative mt-1">
                            <span id="emailIconWrap"
                                class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 transition-colors duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-mail-icon lucide-mail">
                                    <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7" />
                                    <rect x="2" y="4" width="20" height="16" rx="2" />
                                </svg>
                            </span>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                autofocus autocomplete="username"
                                class="block w-full pl-9 pr-3 py-2 sm:py-2.5 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 text-xs sm:text-sm"
                                placeholder="Alamat Email" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs sm:text-sm" />
                    </div>

                    <!-- Password -->
                    <div class="mb-3 sm:mb-4">
                        <div class="relative mt-1">
                            <!-- Icon kiri (lock) -->
                            <span id="passwordIconWrap"
                                class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-lock-keyhole-icon lucide-lock-keyhole">
                                    <circle cx="12" cy="16" r="1" />
                                    <rect x="3" y="10" width="18" height="12" rx="2" />
                                    <path d="M7 10V7a5 5 0 0 1 10 0v3" />
                                </svg>
                            </span>

                            <!-- Input password -->
                            <input id="password" name="password" type="password" required autocomplete="current-password"
                                class="block w-full pl-9 pr-10 py-2 sm:py-2.5 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 text-xs sm:text-sm"
                                placeholder="Kata Sandi" />

                            <!-- Icon kanan (toggle visibility) -->
                            <button type="button" id="togglePassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 focus:outline-none hover:text-gray-600">
                                <!-- Eye (default visible) -->
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye">
                                    <path
                                        d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>

                                <!-- Eye Closed (hidden by default) -->
                                <svg id="eyeClosedIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
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
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs sm:text-sm" />
                    </div>

                    <!-- Forgot Password Link -->
                    {{-- @if (Route::has('password.request'))
                        <div class="text-right mb-3 sm:mb-4">
                            <a href="{{ route('password.request') }}"
                                class="text-xs sm:text-sm text-green-500 hover:text-green-800 font-medium">
                                Lupa Kata Sandi?
                            </a>
                        </div>
                    @endif --}}

                    <!-- Login Button -->
                    <div class="mt-5 sm:mt-6 lg:mt-7">
                        <button type="submit"
                            class="w-full bg-green-500 hover:bg-green-600 text-white py-2 sm:py-2.5 rounded-lg sm:rounded-xl font-semibold shadow-sm transition duration-200 text-sm sm:text-base">
                            Masuk
                        </button>
                    </div>

                    <!-- GOOGLE -->
                    <div class="my-3 sm:my-4 flex items-center gap-2 sm:gap-3">
                        <div class="flex-1 h-px bg-gray-300"></div>
                        <div class="text-center text-gray-500 text-xs sm:text-sm px-2">Atau masuk dengan</div>
                        <div class="flex-1 h-px bg-gray-300"></div>
                    </div>

                    <div class="space-y-2 sm:space-y-3">
                        <a href="{{ route('auth.redirect') }}"
                            class="w-full flex items-center justify-center gap-2 border border-gray-300 rounded-lg sm:rounded-xl py-2 sm:py-2.5 hover:bg-gray-50 transition">
                            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-4 sm:w-5 h-4 sm:h-5"
                                alt="google">
                            <span class="text-xs sm:text-sm text-gray-700">Masuk dengan Google</span>
                        </a>
                    </div>

                    <div class="text-center mt-6 sm:mt-8 text-xs sm:text-sm text-gray-600">
                        Belum memiliki Akun? <a href="{{ route('register') }}"
                            class="text-green-600 hover:underline font-medium">Daftar</a>
                    </div>
                </form>
            </div>

            @vite('resources/js/auth/login.js')

        </div>
        </section>
    @endsection
