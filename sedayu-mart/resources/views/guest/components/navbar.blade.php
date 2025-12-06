<nav class="bg-[#e9ffe6] shadow-lg fixed w-full z-20 top-0 left-0 border-b-4 border-[#d3d3d3]">
    <div class="max-w-screen-xl mx-auto px-4 py-3">
        <div class="flex items-center justify-between">

            <!-- Left: Logo -->
            <div class="flex items-center">
                <a href="#beranda" class="inline-flex items-center">
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
                        <a href="#beranda"
                            class="relative block py-2 px-2 text-black hover:text-[#4CAF50] group transition-colors">
                            Beranda
                            <span aria-hidden="true"
                                class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-[#4CAF50] origin-left transform transition-transform duration-300 scale-x-0 group-hover:scale-x-100"></span>
                        </a>
                    </li>
                    <li>
                        <a href="#tentang"
                            class="relative block py-2 px-2 text-black hover:text-[#4CAF50] group transition-colors">
                            Tentang
                            <span aria-hidden="true"
                                class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-[#4CAF50] origin-left transform transition-transform duration-300 scale-x-0 group-hover:scale-x-100"></span>
                        </a>
                    </li>
                    <li>
                        <a href="#produk"
                            class="relative block py-2 px-2 text-black hover:text-[#4CAF50] group transition-colors">
                            Produk
                            <span aria-hidden="true"
                                class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-[#4CAF50] origin-left transform transition-transform duration-300 scale-x-0 group-hover:scale-x-100"></span>
                        </a>
                    </li>
                    <li>
                        <a href="#kontak"
                            class="relative block py-2 px-2 text-black hover:text-[#4CAF50] group transition-colors">
                            Kontak
                            <span aria-hidden="true"
                                class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-[#4CAF50] origin-left transform transition-transform duration-300 scale-x-0 group-hover:scale-x-100"></span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Right: Auth Button + Mobile Menu -->
            <div class="flex items-center gap-3">
                <!-- Auth Button (visible on sm and above) -->
                <div class="hidden sm:flex sm:items-center">
                    @php
                        $role = strtolower(auth()->user()->role ?? '');
                        $dashboardRoute =
                            $role === 'admin'
                                ? route('admin.dashboard')
                                : ($role === 'user'
                                    ? route('user.beranda')
                                    : route('guest.beranda'));
                    @endphp

                    @auth
                        <a href="{{ $dashboardRoute }}"
                            class="inline-flex items-center px-3 lg:px-4 py-2 border-2 border-[#4CAF50] hover:border-transparent text-sm lg:text-base font-medium rounded-full lg:rounded-3xl text-[#4CAF50] hover:text-white hover:bg-[#4CAF50] focus:outline-none focus:ring-2 transition ease-in-out duration-150">
                            <span class="hidden sm:inline mr-1.5 lg:mr-2">Dashboard</span>
                            <svg class="w-4 h-4 lg:w-5 lg:h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center px-3 lg:px-4 py-2 border-2 border-[#4CAF50] hover:border-transparent text-sm lg:text-base font-medium rounded-full lg:rounded-3xl text-[#4CAF50] hover:text-white hover:bg-[#4CAF50] focus:outline-none focus:ring-2 transition ease-in-out duration-150">
                            <span class="hidden sm:inline mr-1.5 lg:mr-2">Masuk</span>
                            <svg class="w-4 h-4 lg:w-5 lg:h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @endauth
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
                    <a href="#beranda"
                        class="block py-2.5 px-4 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                        Beranda
                    </a>
                </li>
                <li>
                    <a href="#tentang"
                        class="block py-2.5 px-4 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                        Tentang
                    </a>
                </li>
                <li>
                    <a href="#produk"
                        class="block py-2.5 px-4 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                        Produk
                    </a>
                </li>
                <li>
                    <a href="#kontak"
                        class="block py-2.5 px-4 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                        Kontak
                    </a>
                </li>
                <!-- Auth Button for Mobile (visible only on mobile) -->
                <li class="sm:hidden border-t border-gray-200 pt-2">
                    @php
                        $role = strtolower(auth()->user()->role ?? '');
                        $dashboardRoute =
                            $role === 'admin'
                                ? route('admin.dashboard')
                                : ($role === 'user'
                                    ? route('user.beranda')
                                    : route('guest.beranda'));
                    @endphp

                    @auth
                        <a href="{{ $dashboardRoute }}"
                            class="block py-2.5 px-4 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="block py-2.5 px-4 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                            Masuk
                        </a>
                    @endauth
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
