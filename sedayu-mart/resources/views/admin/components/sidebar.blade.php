<!-- Sidebar -->
<aside
    class="w-64 bg-white h-screen shadow-md fixed left-0 top-0 flex flex-col transform transition-transform duration-300 -translate-x-full md:translate-x-0 peer-checked:translate-x-0 md:peer-checked:-translate-x-full z-40">
    <!-- Logo -->
    <div class="flex items-center justify-center gap-2 px-6 py-4 border-b">
        <a href="{{ route('user.beranda') }}" class="inline-flex items-center">
            <img src="{{ asset('img/logo/sedayumart.png') }}" class="w-10" alt="Logo">
            <div class="ml-2 text-lg font-semibold">
                <span class="text-[#065f46]">Sedayu</span><span class="text-[#FBBF24]">Mart</span>
            </div>
        </a>
    </div>

    <!-- Menu -->
    <nav class="flex-1 mt-4">
        <ul class="space-y-3">
            <li class="relative">
                @if (request()->routeIs('admin.dashboard'))
                    <span class="absolute left-0 top-0 bottom-0 w-1 bg-green-600 rounded-r-lg"></span>
                @endif
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center mx-6 p-3 rounded-lg group {{ request()->routeIs('admin.dashboard') ? 'bg-green-500 text-white' : 'hover:bg-green-100' }}">
                    <svg class="shrink-0 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path
                            d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                    </svg>
                    <span class="flex-1 ms-4 font-medium">Dashboard</span>
                </a>
            </li>
            <li class="relative">
                @if (request()->routeIs('admin.pengguna.index'))
                    <span class="absolute left-0 top-0 bottom-0 w-1 bg-green-600 rounded-r-lg"></span>
                @endif
                <a href="{{ route('admin.pengguna.index') }}"
                    class="flex mx-6 items-center p-2 rounded-lg group {{ request()->routeIs('admin.pengguna.index') ? 'bg-green-500 text-white' : 'hover:bg-green-100' }}">
                    <svg class="shrink-0 w-5 h-5 transition duration-75" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 18">
                        <path
                            d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                    </svg>
                    <span class="flex-1 ms-4 font-medium">Pengguna</span>
                </a>
            </li>
            <li class="relative">
                @if (request()->routeIs('admin.produk.index'))
                    <span class="absolute left-0 top-0 bottom-0 w-1 bg-green-600 rounded-r-lg"></span>
                @endif
                <a href="{{ route('admin.produk.index') }}"
                    class="flex items-center mx-6 p-2 rounded-lg group {{ request()->routeIs('admin.produk.index') ? 'bg-green-500 text-white' : 'hover:bg-green-100' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="shrink-0 w-5 h-5 transition duration-75"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                        <path d="M3 9h18M9 21V9" />
                    </svg>
                    <span class="flex-1 ms-4 font-medium">Produk</span>
                </a>
            </li>
            <li class="relative">
                @if (request()->routeIs('admin.tarifPengiriman.index'))
                    <span class="absolute left-0 top-0 bottom-0 w-1 bg-green-600 rounded-r-lg"></span>
                @endif
                <a href="{{ route('admin.tarifPengiriman.index') }}"
                    class="flex items-center mx-6 p-2 rounded-lg group {{ request()->routeIs('admin.tarifPengiriman.index') ? 'bg-green-500 text-white' : 'hover:bg-green-100' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="shrink-0 w-5 h-5 transition duration-75"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="1" y="3" width="15" height="13" rx="2" ry="2" />
                        <path d="M16 8h4l3 3v5a2 2 0 0 1-2 2h-1.5a2 2 0 0 1-2-2v-1H16V8z" />
                        <circle cx="5.5" cy="18.5" r="1.5" />
                        <circle cx="18.5" cy="18.5" r="1.5" />
                    </svg>
                    <span class="flex-1 ms-4 font-medium">Tarif Pengiriman</span>
                </a>
            </li>
            <li class="relative">
                @if (request()->routeIs('admin.pesanan.index'))
                    <span class="absolute left-0 top-0 bottom-0 w-1 bg-green-600 rounded-r-lg"></span>
                @endif
                <a href="{{ route('admin.pesanan.index') }}"
                    class="flex items-center mx-6 p-2 rounded-lg group {{ request()->routeIs('admin.pesanan.index') ? 'bg-green-500 text-white' : 'hover:bg-green-100' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="shrink-0 w-5 h-5 transition duration-75"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <circle cx="9" cy="21" r="1" />
                        <circle cx="20" cy="21" r="1" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 001.99-1.73L23 6H6" />
                    </svg>
                    <span class="flex-1 ms-4 font-medium">Pesanan</span>
                </a>
            </li>
            <li class="relative">
                @if (request()->routeIs('admin.rekening.index'))
                    <span class="absolute left-0 top-0 bottom-0 w-1 bg-green-600 rounded-r-lg"></span>
                @endif
                <a href="{{ route('admin.rekening.index') }}"
                    class="flex items-center mx-6 p-2 rounded-lg group {{ request()->routeIs('admin.rekening.index') ? 'bg-green-500 text-white' : 'hover:bg-green-100' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 w-5 h-5 transition duration-75 lucide lucide-wallet-minimal-icon lucide-wallet-minimal">
                        <path d="M17 14h.01"/>
                        <path d="M7 7h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14"/>
                    </svg>
                    <span class="flex-1 ms-4 font-medium">Rekening</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>
