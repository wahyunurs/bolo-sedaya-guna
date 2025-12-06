<nav class="bg-[#e9ffe6] shadow-lg fixed w-full z-20 top-0 left-0 border-b-4 border-[#d3d3d3]">
    <div class="max-w-screen-xl mx-auto px-4 py-3">
        <div class="flex items-center justify-between">

            <!-- Left: Logo -->
            <div class="flex items-center">
                <a href="{{ route('user.beranda') }}" class="inline-flex items-center">
                    <img src="{{ asset('img/logo/sedayumart.png') }}" class="w-8 sm:w-10" alt="Logo">
                    <div class="ml-2 text-base sm:text-lg font-semibold">
                        <span class="text-[#065f46]">Sedayu</span><span class="text-[#FBBF24]">Mart</span>
                    </div>
                </a>
            </div>

            <!-- Center: Navigation (Desktop & Tablet) -->
            <div class="hidden lg:flex flex-1 justify-center">
                <ul class="flex space-x-6 xl:space-x-8">
                    <li>
                        <a href="{{ route('user.beranda') }}"
                            class="relative block py-2 px-2 {{ request()->routeIs('user.beranda') ? 'text-[#4CAF50]' : 'text-black hover:text-[#4CAF50]' }} group transition-colors">
                            Beranda
                            <span aria-hidden="true"
                                class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-[#4CAF50] origin-left transform transition-transform duration-300 {{ request()->routeIs('user.beranda') ? 'scale-x-100' : 'scale-x-0' }} group-hover:scale-x-100"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.produk.index') }}"
                            class="relative block py-2 px-2 {{ request()->routeIs('user.produk.*') ? 'text-[#4CAF50]' : 'text-black hover:text-[#4CAF50]' }} group transition-colors">
                            Produk
                            <span aria-hidden="true"
                                class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-[#4CAF50] origin-left transform transition-transform duration-300 {{ request()->routeIs('user.produk.*') ? 'scale-x-100' : 'scale-x-0' }} group-hover:scale-x-100"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.keranjang.index') }}"
                            class="relative block py-2 px-2 {{ request()->routeIs('user.keranjang.*') ? 'text-[#4CAF50]' : 'text-black hover:text-[#4CAF50]' }} group transition-colors">
                            Keranjang
                            <span aria-hidden="true"
                                class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-[#4CAF50] origin-left transform transition-transform duration-300 {{ request()->routeIs('user.keranjang.*') ? 'scale-x-100' : 'scale-x-0' }} group-hover:scale-x-100"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.pesanan.index') }}"
                            class="relative block py-2 px-2 {{ request()->routeIs('user.pesanan.*') ? 'text-[#4CAF50]' : 'text-black hover:text-[#4CAF50]' }} group transition-colors">
                            Pesanan
                            <span aria-hidden="true"
                                class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-[#4CAF50] origin-left transform transition-transform duration-300 {{ request()->routeIs('user.pesanan.*') ? 'scale-x-100' : 'scale-x-0' }} group-hover:scale-x-100"></span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Right: Profile & Mobile Menu -->
            <div class="flex items-center gap-3">
                <!-- Profile Dropdown (Desktop & Tablet) -->
                <div class="hidden sm:flex items-center relative">

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
                            class="peer flex items-center p-0 border-2 border-[#065f46] rounded-full transition-all duration-200 ease-in-out focus:outline-none focus:border-4 hover:border-[#4CAF50]">
                            @if (!empty($profilePhoto))
                                <img src="{{ $profilePhoto }}"
                                    class="w-9 h-9 sm:w-10 sm:h-10 rounded-full object-cover cursor-pointer"
                                    alt="Avatar">
                            @else
                                <span
                                    class="inline-flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-gray-100 text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-user-round-icon lucide-user-round w-5 h-5 sm:w-6 sm:h-6">
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

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-toggle" type="button"
                    class="lg:hidden inline-flex items-center p-2 w-10 h-10 justify-center text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#4CAF50]"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
            </div>

        </div>

        <!-- Mobile Menu (Hidden by default) -->
        <div id="mobile-menu" class="hidden lg:hidden mt-3 pb-2">
            <ul class="flex flex-col space-y-2">
                <li>
                    <a href="{{ route('user.beranda') }}"
                        class="block py-2.5 px-4 rounded-lg {{ request()->routeIs('user.beranda') ? 'bg-[#4CAF50] text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
                        Beranda
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.produk.index') }}"
                        class="block py-2.5 px-4 rounded-lg {{ request()->routeIs('user.produk.*') ? 'bg-[#4CAF50] text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
                        Produk
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.keranjang.index') }}"
                        class="block py-2.5 px-4 rounded-lg {{ request()->routeIs('user.keranjang.*') ? 'bg-[#4CAF50] text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
                        Keranjang
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.pesanan.index') }}"
                        class="block py-2.5 px-4 rounded-lg {{ request()->routeIs('user.pesanan.*') ? 'bg-[#4CAF50] text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
                        Pesanan
                    </a>
                </li>
                <!-- Mobile Profile Links (only on small screens) -->
                <li class="sm:hidden border-t border-gray-200 pt-2">
                    <a href="{{ route('user.profil.index') }}"
                        class="block py-2.5 px-4 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                        Profil
                    </a>
                </li>
                <li class="sm:hidden">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left py-2.5 px-4 rounded-lg text-red-600 hover:bg-red-50 transition-colors">
                            Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>

    </div>
</nav>

<!-- JavaScript untuk Toggle Mobile Menu -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
                const isExpanded = !mobileMenu.classList.contains('hidden');
                mobileMenuToggle.setAttribute('aria-expanded', isExpanded);
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                const isClickInsideMenu = mobileMenu.contains(event.target);
                const isClickOnToggle = mobileMenuToggle.contains(event.target);

                if (!isClickInsideMenu && !isClickOnToggle && !mobileMenu.classList.contains(
                    'hidden')) {
                    mobileMenu.classList.add('hidden');
                    mobileMenuToggle.setAttribute('aria-expanded', 'false');
                }
            });
        }
    });
</script>
