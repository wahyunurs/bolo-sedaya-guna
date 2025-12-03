<x-app-layout>
    @include('user.components.navbar')

    <!-- SECTION KERANJANG BELANJA -->
    <section class="py-20 bg-[#e9ffe1] min-h-screen">
        <!-- JUDUL -->
        <h1 class="text-center text-4xl md:text-5xl font-extrabold tracking-wide text-green-800 mb-8 mt-8">
            KERANJANG BELANJA
        </h1>

        <!-- SEARCH + TRASH + CART -->
        <div class="flex items-center justify-center gap-3 px-6 mb-10">

            <!-- SEARCH BAR -->
            <div class="flex items-center rounded-xl w-full max-w-3xl overflow-hidden">
                <div class="relative w-full">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35M11 19a8 8 0 1 1 0-16 8 8 0 0 1 0 16z" />
                    </svg>
                    <input type="text" placeholder="Cari produk..."
                        class="w-full pl-11 pr-4 py-3 text-gray-600 border-0 focus:outline-none focus:ring-0" />
                </div>
                <button
                    class="bg-[#4CD137] px-5 md:px-6 py-3 text-white hover:bg-green-600 transition flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-search-icon">
                        <path d="m21 21-4.34-4.34" />
                        <circle cx="11" cy="11" r="8" />
                    </svg>
                    <span class="font-semibold">Cari</span>
                </button>
            </div>

            <!-- TOMBOL TRASH -->
            <button
                class="bg-red-500 hover:bg-red-600 text-white h-12 w-12 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-trash2-icon lucide-trash-2">
                    <path d="M10 11v6" />
                    <path d="M14 11v6" />
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                    <path d="M3 6h18" />
                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                </svg>
            </button>

            <!-- TOMBOL CART -->
            <button
                class="bg-green-600 hover:bg-green-700 text-white h-12 w-12 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-shopping-cart-icon lucide-shopping-cart">
                    <circle cx="8" cy="21" r="1" />
                    <circle cx="19" cy="21" r="1" />
                    <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                </svg>
            </button>
        </div>

        <!-- LIST PRODUK -->
        <div class="px-28 space-y-8">

            <!-- ITEM -->
            <div class="bg-white rounded-2xl shadow px-10 py-5 flex items-center justify-between">
                <!-- KIRI -->
                <div class="flex items-start gap-8 px-4 py-2">

                    <!-- CHECKBOX -->
                    <input type="checkbox" class="self-center w-7 h-7 rounded-lg">

                    <!-- FOTO -->
                    <img src="{{ asset('img/card/produk1.png') }}" class="h-24 w-24 rounded-xl object-cover">

                    <!-- NAMA + QTY -->
                    <div class="pt-1">
                        <p class="font-bold text-2xl text-gray-800">Olahan Jagung</p>

                        <div class="flex items-center gap-4 mt-3">

                            <p class="text-green-700 font-bold text-xl">Rp 20.000,-</p>

                        </div>
                    </div>
                </div>

                <!-- KANAN -->
                <div class="flex items-center gap-7">
                    <div class="flex items-center gap-4 mr-3">

                        <!-- - -->
                        <button class="px-3 py-1 font-bold">-</button>

                        <!-- FIELD ANGKA -->
                        <div class="px-6 py-1 border border-black rounded-md text-md font-semibold">
                            10
                        </div>
                        <!-- + -->
                        <button class="px-3 py-1 font-bold">+</button>

                    </div>

                    <!-- ICON DELETE -->
                    <button
                        class="p-2 rounded-lg text-red-600 border border-red-600 hover:bg-red-600 hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-trash-icon lucide-trash">
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                            <path d="M3 6h18" />
                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                        </svg>
                    </button>

                    <!-- ICON KERANJANG -->
                    <button
                        class="p-2 rounded-lg text-green-700 border border-green-700 hover:bg-green-700 hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-shopping-cart-icon lucide-shopping-cart">
                            <circle cx="8" cy="21" r="1" />
                            <circle cx="19" cy="21" r="1" />
                            <path
                                d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>
