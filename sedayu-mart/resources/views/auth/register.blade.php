@extends('auth.components.layout')
@section('content')
    <!-- Wrapper -->
    <section class="min-h-screen flex items-center justify-center bg-[#e5ffda]"
        style="background-size: cover; background-position: center; background-repeat: no-repeat;">
        <!-- Main container -->
        <div class="flex w-full max-w-4xl bg-[#ffffff] rounded-3xl shadow-lg overflow-hidden h-[560px]">
            <!-- Right side (image) - moved to first column -->
            <div class="w-1/2 flex items-center justify-center p-8">
                <div class="relative w-full h-full flex items-center justify-center">

                    <div class="relative">
                        <img src="{{ asset('img/card/auth.png') }}" alt="Register Illustration"
                            class="rounded-3xl w-[400px] h-auto object-contain animate-blink-slow">
                    </div>
                </div>
            </div>

            <!-- Left side (form) - moved to second column -->
            <div class="w-1/2 p-10 overflow-y-auto" style="direction: rtl;">
                <!-- Logo -->
                <div class="flex items-center justify-center mb-4 gap-3">
                    <div class="text-xl font-bold">
                        <span class="text-[#065f46]">Sedayu</span><span class="text-[#FBBF24]">Mart</span>
                    </div>
                    <img src="{{ asset('img/logo/sedayumart.png') }}" alt="SedayuMart" class="w-10 h-auto">
                </div>

                <!-- Title -->
                <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Buat Akun Baru</h2>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('register') }}" style="direction: ltr;">
                    @csrf

                    <!-- Name -->
                    <div class="mb-5">
                        <div class="relative mt-1">
                            <span id="nameIconWrap" class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-user-icon lucide-user">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                            </span>
                            <input id="nama" name="nama" type="text" value="{{ old('nama') }}" required
                                autofocus autocomplete="name"
                                class="block w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
                                placeholder="Nama Lengkap" />
                        </div>
                        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                    </div>

                    <!-- Alamat -->
                    <div class="mb-5">
                        <div class="relative mt-1 text-gray-400 focus-within:text-green-500 transition-colors duration-200">
                            <span id="alamatIconWrap" class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-current" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M15 22a1 1 0 0 1-1-1v-4a1 1 0 0 1 .445-.832l3-2a1 1 0 0 1 1.11 0l3 2A1 1 0 0 1 22 17v4a1 1 0 0 1-1 1z" />
                                    <path d="M18 10a8 8 0 0 0-16 0c0 4.993 5.539 10.193 7.399 11.799a1 1 0 0 0 .601.2" />
                                    <path d="M18 22v-3" />
                                    <circle cx="10" cy="10" r="3" />
                                </svg>
                            </span>
                            <input id="alamat" name="alamat" type="text" value="{{ old('alamat') }}" required
                                class="block w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
                                placeholder="Alamat Rumah" />
                        </div>
                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                    </div>

                    <!-- Kabupaten & Provinsi -->
                    <div class="mb-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <div
                                class="relative mt-1 text-gray-400 focus-within:text-green-500 transition-colors duration-200">
                                <span id="kabupatenIconWrap" class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-current" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M19.914 11.105A7.298 7.298 0 0 0 20 10a8 8 0 0 0-16 0c0 4.993 5.539 10.193 7.399 11.799a1 1 0 0 0 1.202 0 32 32 0 0 0 .824-.738" />
                                        <circle cx="12" cy="10" r="3" />
                                        <path d="M16 18h6" />
                                        <path d="M19 15v6" />
                                    </svg>
                                </span>
                                <!-- Custom searchable dropdown for kabupaten -->
                                <div class="relative">
                                    <input type="hidden" id="kabupaten" name="kabupaten" value="{{ old('kabupaten') }}">

                                    <span id="kabupatenIconWrap"
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-current">
                                            <path d="M17.97 9.304A8 8 0 0 0 2 10c0 4.69 4.887 9.562 7.022 11.468" />
                                            <path
                                                d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                                            <circle cx="10" cy="10" r="3" />
                                        </svg>
                                    </span>

                                    <input id="kabupatenSearch" type="text" autocomplete="off"
                                        class="block w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm bg-white"
                                        placeholder="Pilih Kabupaten/Kota" value="{{ old('kabupaten') }}">

                                    <ul id="kabupatenList"
                                        class="absolute left-0 right-0 mt-1 max-h-44 overflow-auto border border-gray-200 rounded-md shadow-sm bg-white z-50 hidden">
                                        @if (isset($kabupatens) && $kabupatens->count())
                                            @foreach ($kabupatens as $kabupaten)
                                                <li data-value="{{ $kabupaten }}"
                                                    class="px-3 py-2 text-sm text-black hover:bg-green-500 hover:text-white cursor-pointer">
                                                    {{ $kabupaten }}</li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('kabupaten')" class="mt-2" />
                        </div>

                        <!-- Provinsi -->
                        <div>
                            <div
                                class="relative mt-1 text-gray-400 focus-within:text-green-500 transition-colors duration-200">
                                <span id="provinsiIconWrap" class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-current"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M18 8c0 3.613-3.869 7.429-5.393 8.795a1 1 0 0 1-1.214 0C9.87 15.429 6 11.613 6 8a6 6 0 0 1 12 0" />
                                        <circle cx="12" cy="8" r="2" />
                                        <path
                                            d="M8.714 14h-3.71a1 1 0 0 0-.948.683l-2.004 6A1 1 0 0 0 3 22h18a1 1 0 0 0 .948-1.316l-2-6a1 1 0 0 0-.949-.684h-3.712" />
                                    </svg>
                                </span>
                                <input id="provinsi" name="provinsi" type="text" value="{{ old('provinsi') }}"
                                    required
                                    class="block w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
                                    placeholder="Provinsi" />
                            </div>
                            <x-input-error :messages="$errors->get('provinsi')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="mb-5">
                        <div class="relative mt-1">
                            <span id="nomorTeleponIconWrap"
                                class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-phone-icon lucide-phone">
                                    <path
                                        d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" />
                                </svg>
                            </span>
                            <input id="nomor_telepon" name="nomor_telepon" type="text"
                                value="{{ old('nomor_telepon') }}" required
                                class="block w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
                                placeholder="Nomor Telepon" />
                        </div>
                        <x-input-error :messages="$errors->get('nomor_telepon')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mb-5">
                        <div class="relative mt-1">
                            <span id="emailIconWrap"
                                class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 transition-colors duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-mail-icon lucide-mail">
                                    <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7" />
                                    <rect x="2" y="4" width="20" height="16" rx="2" />
                                </svg>
                            </span>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                autocomplete="username"
                                class="block w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
                                placeholder="Alamat Email" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <div class="relative mt-1">
                            <span id="passwordIconWrap"
                                class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-lock-keyhole-icon lucide-lock-keyhole">
                                    <circle cx="12" cy="16" r="1" />
                                    <rect x="3" y="10" width="18" height="12" rx="2" />
                                    <path d="M7 10V7a5 5 0 0 1 10 0v3" />
                                </svg>
                            </span>

                            <input id="password" name="password" type="password" required autocomplete="new-password"
                                class="block w-full pl-9 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
                                placeholder="Kata Sandi" />

                            <!-- Icon kanan (toggle visibility) -->
                            <button type="button" id="togglePassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 focus:outline-none">
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye">
                                    <path
                                        d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                                <svg id="eyeClosedIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-eye-closed hidden">
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

                    <!-- Confirm Password -->
                    <div class="mb-5">
                        <div class="relative mt-1">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-lock-keyhole-icon lucide-lock-keyhole">
                                    <circle cx="12" cy="16" r="1" />
                                    <rect x="3" y="10" width="18" height="12" rx="2" />
                                    <path d="M7 10V7a5 5 0 0 1 10 0v3" />
                                </svg>
                            </span>
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                autocomplete="new-password"
                                class="block w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
                                placeholder="Konfirmasi Kata Sandi" />
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                            class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg font-semibold shadow-sm transition duration-200">
                            Daftar
                        </button>
                    </div>

                    <div class="my-4 flex items-center">
                        <div class="flex-1 h-px bg-gray-300"></div>
                        <div class="px-4 text-center text-gray-500 text-sm">Atau mendaftar dengan</div>
                        <div class="flex-1 h-px bg-gray-300"></div>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ route('auth.redirect') }}"
                            class="w-full flex items-center justify-center gap-2 border border-gray-300 rounded-lg py-2 hover:bg-gray-50 transition">
                            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5"
                                alt="google">
                            <span class="text-sm text-gray-700">Daftar dengan Google</span>
                        </a>
                    </div>

                    <div class="text-center mt-6 text-sm text-gray-600">
                        Sudah memiliki Akun? <a href="{{ route('login') }}"
                            class="text-green-600 hover:underline font-medium">Masuk</a>
                    </div>
                </form>
            </div>

            @vite('resources/js/auth/register.js')
            <script>
            </script>
        </div>
    </section>
@endsection
