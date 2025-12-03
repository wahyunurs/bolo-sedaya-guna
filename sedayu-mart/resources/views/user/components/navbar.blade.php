<nav class="bg-[#e9ffe6] shadow-lg fixed w-full z-20 top-0 left-0 border-b-4 border-[#d3d3d3] h-20">
    <div class="max-w-screen-xl mx-auto p-4 flex items-center">

        <!-- Left: Logo + Mobile toggle -->
        <div class="flex items-center flex-1 md:flex-none">
            <a href="{{ route('user.beranda') }}" class="inline-flex items-center">
                <img src="{{ asset('img/logo/sedayumart.png') }}" class="w-10" alt="Logo">
                <div class="ml-2 text-lg font-semibold">
                    <span class="text-[#065f46]">Sedayu</span><span class="text-[#FBBF24]">Mart</span>
                </div>
            </a>

            <!-- Mobile menu button -->
            <button data-collapse-toggle="navbar-default" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none ms-3"
                aria-controls="navbar-default" aria-expanded="false">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>

        <!-- Center: Navigation -->
        <div class="flex-1 flex justify-center">
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul
                    class="font-small flex flex-col p-3 md:p-0 mt-4 border rounded-lg  md:flex-row md:space-x-4 md:mt-0 md:border-0">
                    <li>
                        <a href="{{ route('user.beranda') }}"
                            class="relative block py-2 px-2 {{ request()->routeIs('user.beranda') ? 'text-[#4CAF50]' : 'text-black hover:text-[#4CAF50]' }} group">
                            Beranda
                            <span aria-hidden="true"
                                class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-[#4CAF50] origin-left transform transition-transform duration-300 {{ request()->routeIs('user.beranda') ? 'scale-x-100' : 'scale-x-0' }} group-hover:scale-x-100"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.produk.index') }}"
                            class="relative block py-2 px-2 hover:text-[#4CAF50] group {{ request()->routeIs('user.produk.index') ? 'text-[#4CAF50]' : '' }}">
                            Produk
                            <span aria-hidden="true"
                                class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-[#4CAF50] origin-left transform transition-transform duration-300 {{ request()->routeIs('user.produk.index') ? 'scale-x-100' : 'scale-x-0' }} group-hover:scale-x-100"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.keranjang.index') }}"
                            class="relative block py-2 px-2 hover:text-[#4CAF50] group {{ request()->routeIs('user.keranjang.index') ? 'text-[#4CAF50]' : '' }}">
                            Keranjang
                            <span aria-hidden="true"
                                class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-[#4CAF50] origin-left transform transition-transform duration-300 {{ request()->routeIs('user.keranjang.index') ? 'scale-x-100' : 'scale-x-0' }} group-hover:scale-x-100"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.pesanan.index') }}"
                            class="relative block py-2 px-2 hover:text-[#4CAF50] group {{ request()->routeIs('user.pesanan.index') ? 'text-[#4CAF50]' : '' }}">
                            Pesanan
                            <span aria-hidden="true"
                                class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-[#4CAF50] origin-left transform transition-transform duration-300 {{ request()->routeIs('user.pesanan.index') ? 'scale-x-100' : 'scale-x-0' }} group-hover:scale-x-100"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Right: Profile / Dropdown -->
        <div class="flex items-center justify-end flex-1 md:flex-none">
            <div class="hidden sm:flex sm:items-center ms-3 relative">

                <!-- Wrapper untuk menggunakan focus-within -->
                <div class="relative group focus-within:block">

                    @php
                        $user = Auth::user();
                        $avatar = $user->avatar ?? null;
                        if ($avatar) {
                            $profilePhoto = \Illuminate\Support\Str::startsWith($avatar, ['http://', 'https://'])
                                ? $avatar
                                : asset($avatar);
                        } elseif (!empty($user->profile_photo_url)) {
                            $profilePhoto = $user->profile_photo_url;
                        } else {
                            // no avatar available, render inline SVG instead of default image
                            $profilePhoto = null;
                        }
                    @endphp

                    <!-- Tombol Foto Profil -->
                    <button
                        class="peer flex items-center p-0 border-2 border-[#065f46] rounded-full transition-all duration-200 ease-in-out focus:outline-none peer-focus:border-4">
                        @if (!empty($profilePhoto))
                            <img src="{{ $profilePhoto }}" class="w-10 h-10 rounded-full object-cover cursor-pointer"
                                alt="Avatar">
                        @else
                            <span
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-user-round-icon lucide-user-round w-6 h-6">
                                    <circle cx="12" cy="8" r="5" />
                                    <path d="M20 21a8 8 0 0 0-16 0" />
                                </svg>
                            </span>
                        @endif
                    </button>

                    <!-- Dropdown (muncul saat foto profil di klik/focus) -->
                    <div
                        class="absolute right-0 mt-2 w-56 z-50 hidden peer-focus:block group-hover:block bg-white divide-y divide-gray-200 rounded-lg shadow-lg">

                        <div class="px-4 py-3 bg-gray-100 rounded-t-lg">
                            <span class="block text-sm font-semibold text-gray-800">
                                {{ Auth::user()->name ?? Auth::user()->nama }}
                            </span>
                            <span class="block text-sm text-gray-500 truncate">
                                {{ Auth::user()->email }}
                            </span>
                        </div>

                        <ul class="py-2 bg-white rounded-b-lg">
                            <li>
                                <a href="{{ route('user.profil.index') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                                    Profil
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-100 hover:text-red-700 transition">
                                        Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>

                    </div>
                </div>

            </div>
        </div>

    </div>
</nav>
