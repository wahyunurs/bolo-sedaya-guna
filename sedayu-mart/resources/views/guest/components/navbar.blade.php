<nav class="bg-[#e9ffe6] shadow-lg fixed w-full z-20 top-0 left-0 border-b-4 border-[#d3d3d3] h-20">
    <div class="max-w-screen-xl mx-auto p-4 flex items-center">

        <!-- Left: Logo + Mobile toggle -->
        <div class="flex items-center flex-1 md:flex-none">
            <a href="#beranda" class="inline-flex items-center">
                <img src="{{ asset('img/logo/sedayumart.png') }}" class="w-10" alt="Logo">
                <div class="ml-2 text-lg font-semibold">
                    <span class="text-[#065f46]">Sedayu</span><span class="text-[#FBBF24]">Mart</span>
                </div>
            </a>

            <!-- Mobile menu button -->
            <button data-collapse-toggle="navbar-default" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-black rounded-lg md:hidden hover:bg-gray-100 focus:outline-none ms-3"
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
                        <a href="#beranda" class="relative block py-2 px-2 text-black hover:text-[#4CAF50] group">
                            Beranda
                            <span aria-hidden="true"
                                class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-[#4CAF50] origin-left transform transition-transform duration-300 scale-x-0 group-hover:scale-x-100"></span>
                        </a>
                    </li>
                    <li>
                        <a href="#tentang" class="relative block py-2 px-2 text-black hover:text-[#4CAF50] group">
                            Tentang
                            <span aria-hidden="true"
                                class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-[#4CAF50] origin-left transform transition-transform duration-300 scale-x-0 group-hover:scale-x-100"></span>
                        </a>
                    </li>
                    <li>
                        <a href="#produk" class="relative block py-2 px-2 text-black hover:text-[#4CAF50] group">
                            Produk
                            <span aria-hidden="true"
                                class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-[#4CAF50] origin-left transform transition-transform duration-300 scale-x-0 group-hover:scale-x-100"></span>
                        </a>
                    </li>
                    <li>
                        <a href="#kontak" class="relative block py-2 px-2 text-black hover:text-[#4CAF50] group">
                            Kontak
                            <span aria-hidden="true"
                                class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-[#4CAF50] origin-left transform transition-transform duration-300 scale-x-0 group-hover:scale-x-100"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Right: Login button with right arrow icon -->
        <div class="flex items-center justify-end flex-1 md:flex-none">
            <div class="hidden sm:flex sm:items-center ms-3">
                <a href="{{ route('login') }}"
                    class="inline-flex items-center px-3 py-2 border-2 border-[#4CAF50] hover:border-transparent text-md font-medium rounded-3xl text-[#4CAF50] hover:text-white hover:bg-[#4CAF50] focus:outline-none focus:ring-2 transition ease-in-out duration-150">
                    <span class="mr-2">Masuk</span>
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Navbar JavaScript -->
@vite('resources/js/guest/navbar.js')
