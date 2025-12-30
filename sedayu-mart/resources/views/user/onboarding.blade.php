@extends('auth.components.layout')

@section('title', 'Lengkapi Profil')

@section('content')
    <section class="min-h-screen flex items-center justify-center bg-[#e5ffda] px-4 sm:px-6 py-8 sm:py-12"
        style="background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="flex flex-col w-full max-w-md bg-white rounded-2xl sm:rounded-3xl shadow-lg overflow-hidden p-6 sm:p-8">
            <!-- Logo -->
            <div class="flex items-center justify-center mb-3 sm:mb-4 gap-2 sm:gap-3">
                <img src="{{ asset('img/logo/sedayumart.png') }}" alt="SedayuMart" class="w-8 sm:w-10 h-auto">
                <div class="text-base sm:text-lg lg:text-xl font-bold">
                    <span class="text-[#065f46]">Sedayu</span><span class="text-[#FBBF24]">Mart</span>
                </div>
            </div>

            <!-- Title -->
            <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-center text-gray-800 mb-4 sm:mb-6">
                Lengkapi Profil Anda
            </h2>

            @if ($errors->any())
                <div class="mb-4">
                    <ul class="list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('user.onboarding.store') }}" style="direction: ltr;">
                @csrf
                <!-- Nama Lengkap -->
                <div class="mb-4 sm:mb-5">
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-user-icon lucide-user">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </span>
                        <input id="nama" name="nama" type="text" value="{{ old('nama', $user->nama) }}" required
                            autofocus autocomplete="name"
                            class="block w-full pl-9 pr-3 py-2 sm:py-2.5 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 text-xs sm:text-sm"
                            placeholder="Nama Lengkap" />
                    </div>
                    <x-input-error :messages="$errors->get('nama')" class="mt-2 text-xs sm:text-sm" />
                </div>

                <!-- Alamat -->
                <div class="mb-4 sm:mb-5">
                    <div class="relative mt-1 text-gray-400 focus-within:text-green-500 transition-colors duration-200">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5 text-current"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M15 22a1 1 0 0 1-1-1v-4a1 1 0 0 1 .445-.832l3-2a1 1 0 0 1 1.11 0l3 2A1 1 0 0 1 22 17v4a1 1 0 0 1-1 1z" />
                                <path d="M18 10a8 8 0 0 0-16 0c0 4.993 5.539 10.193 7.399 11.799a1 1 0 0 0 .601.2" />
                                <path d="M18 22v-3" />
                                <circle cx="10" cy="10" r="3" />
                            </svg>
                        </span>
                        <input id="alamat" name="alamat" type="text" value="{{ old('alamat', $user->alamat) }}"
                            required
                            class="block w-full pl-9 pr-3 py-2 sm:py-2.5 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 text-xs sm:text-sm"
                            placeholder="Alamat Rumah" />
                    </div>
                    <x-input-error :messages="$errors->get('alamat')" class="mt-2 text-xs sm:text-sm" />
                </div>

                <!-- Kabupaten (Dropdown Option) -->
                <div class="mb-4 sm:mb-5">
                    <div class="relative mt-1 text-gray-400 focus-within:text-green-500 transition-colors duration-200">
                        <span id="kabupatenIconWrap" class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5 text-current"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="w-4 h-4 sm:w-5 sm:h-5 text-current">
                                    <path d="M17.97 9.304A8 8 0 0 0 2 10c0 4.69 4.887 9.562 7.022 11.468" />
                                    <path
                                        d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                                    <circle cx="10" cy="10" r="3" />
                                </svg>
                            </span>

                            <input id="kabupatenSearch" type="text" autocomplete="off"
                                class="block w-full pl-9 pr-3 py-2 sm:py-2.5 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 text-xs sm:text-sm bg-white"
                                placeholder="Pilih Kabupaten/Kota" value="{{ old('kabupaten') }}">

                            <ul id="kabupatenList"
                                class="absolute left-0 right-0 mt-1 max-h-44 overflow-auto border border-gray-200 rounded-md shadow-sm bg-white z-50 hidden">
                                @if (isset($kabupatens) && $kabupatens->count())
                                    @foreach ($kabupatens as $kabupaten)
                                        <li data-value="{{ $kabupaten }}"
                                            class="px-3 py-2 text-xs sm:text-sm text-black hover:bg-green-500 hover:text-white cursor-pointer">
                                            {{ $kabupaten }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('kabupaten')" class="mt-2 text-xs sm:text-sm" />
                </div>

                <!-- Nomor Telepon -->
                <div class="mb-4 sm:mb-5">
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-phone-icon lucide-phone">
                                <path
                                    d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" />
                            </svg>
                        </span>
                        <input id="nomor_telepon" name="nomor_telepon" type="text"
                            value="{{ old('nomor_telepon', $user->nomor_telepon) }}" required
                            class="block w-full pl-9 pr-3 py-2 sm:py-2.5 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 text-xs sm:text-sm"
                            placeholder="Nomor Telepon" />
                    </div>
                    <x-input-error :messages="$errors->get('nomor_telepon')" class="mt-2 text-xs sm:text-sm" />
                </div>

                <div class="mt-5 sm:mt-6 lg:mt-7">
                    <button type="submit"
                        class="w-full bg-green-500 hover:bg-green-600 text-white py-2 sm:py-2.5 rounded-lg sm:rounded-xl font-semibold shadow-sm transition duration-200 text-sm sm:text-base">
                        Simpan & Lanjutkan
                    </button>
                </div>
            </form>
        </div>
    </section>
    @vite('resources/js/auth/register.js')
@endsection
