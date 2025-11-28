<x-app-layout>
    @include('user.components.navbar')

    <section class="py-20 bg-[#CBF5BA] min-h-screen">

        {{-- Judul --}}
        <h1 class="text-center text-4xl font-extrabold text-green-800 mb-6 mt-6">
            SEMUA PRODUK
        </h1>

        {{-- Search Bar --}}
        <div class="flex justify-center mb-12 px-4">
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
        </div>

        {{-- Grid Produk --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 px-6 md:px-12">

            {{-- Card Produk --}}
            @for ($i = 0; $i < 10; $i++)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="relative w-full aspect-square overflow-hidden">
                        <img src="{{ asset('img/card/produk1.png') }}" class="absolute inset-0 w-full h-full object-cover" alt="Produk">
                    </div>
                    <div class="p-4">
                        <h3 class="font-extrabold text-gray-800">Olahan Jagung</h3>
                    </div>
                    <div class="px-4 pb-4">
                        <div class="grid grid-cols-2 items-center">
                            <div>
                                <p class="text-green-600 font-semibold">Rp 20.000,-</p>
                            </div>
                            <div class="flex justify-end">
                                <button aria-label="Tambah ke keranjang"
                                    class="text-green-600 border border-green-600 px-3 py-2 rounded-lg hover:bg-green-600 hover:text-white transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
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
                </div>
            @endfor

        </div>
    </section>

</x-app-layout>
