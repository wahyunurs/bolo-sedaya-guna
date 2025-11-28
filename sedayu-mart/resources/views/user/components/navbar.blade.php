<nav class="bg-[#209416] shadow-lg fixed w-full z-20 top-0 left-0 border-b-4 border-gray-200 h-20">
    <div class="max-w-screen-xl mx-auto p-4 flex items-center">

        <!-- Left: Logo + Mobile toggle -->
        <div class="flex items-center flex-1 md:flex-none">
            <a href="{{ route('user.dashboard') }}" class="inline-flex items-center">
                <img src="{{ asset('img/logo/goloka.png') }}" class="w-20" alt="Logo">
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
                        <a href="{{ route('user.dashboard') }}"
                            class="relative block py-2 px-2 {{ request()->routeIs('user.dashboard') ? 'text-yellow-300' : 'text-white hover:text-yellow-300' }} group">
                            Beranda
                            <span aria-hidden="true"
                                class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-yellow-300 origin-left transform transition-transform duration-300 {{ request()->routeIs('user.dashboard') ? 'scale-x-100' : 'scale-x-0' }} group-hover:scale-x-100"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.produk.index') }}"
                            class="relative block py-2 px-2 text-white hover:text-yellow-300 group {{ request()->routeIs('user.produk.index') ? 'text-yellow-300' : '' }}">
                            Produk
                            <span aria-hidden="true"
                                class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-yellow-300 origin-left transform transition-transform duration-300 {{ request()->routeIs('user.produk.index') ? 'scale-x-100' : 'scale-x-0' }} group-hover:scale-x-100"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.keranjang.index') }}"
                            class="relative block py-2 px-2 text-white hover:text-yellow-300 group {{ request()->routeIs('user.keranjang.index') ? 'text-yellow-300' : '' }}">
                            Keranjang
                            <span aria-hidden="true"
                                class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-yellow-300 origin-left transform transition-transform duration-300 {{ request()->routeIs('user.keranjang.index') ? 'scale-x-100' : 'scale-x-0' }} group-hover:scale-x-100"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.pesanan.index') }}"
                            class="relative block py-2 px-2 text-white hover:text-yellow-300 group {{ request()->routeIs('user.pesanan.index') ? 'text-yellow-300' : '' }}">
                            Pesanan
                            <span aria-hidden="true"
                                class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-yellow-300 origin-left transform transition-transform duration-300 {{ request()->routeIs('user.pesanan.index') ? 'scale-x-100' : 'scale-x-0' }} group-hover:scale-x-100"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Right: Profile / Dropdown -->
        <div class="flex items-center justify-end flex-1 md:flex-none">
            <div class="hidden sm:flex sm:items-center ms-3">
                <button id="user-menu-btn" type="button" onclick="toggleUserMenu()"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                    aria-haspopup="true" aria-expanded="false">
                    <div class="text-sm font-medium">{{ Auth::user()->nama }}</div>
                    <div class="ms-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>

                <div id="user-menu"
                    class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50 overflow-hidden">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>

                    <div class="border-t"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
