@component('user.components.user-layout')
    @include('user.components.navbar')

    <section class="pt-20 sm:pt-24 pb-8 bg-[#e9ffe1] min-h-screen px-4 sm:px-6 lg:px-10">

        <!-- Modal Flash Message -->
        @include('user.components.message-modal')

        {{-- Judul --}}
        <h1
            class="text-center text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-wide text-green-800 mb-6 sm:mb-8 mt-4 sm:mt-8">
            SEMUA PRODUK
        </h1>

        {{-- Search Bar --}}
        <div class="flex justify-center mb-8 sm:mb-12 px-2 sm:px-4">
            <form id="searchForm" method="GET" role="search" class="w-full max-w-3xl">
                <div class="flex items-center rounded-lg sm:rounded-xl w-full overflow-hidden bg-white shadow-sm">
                    <div class="relative w-full">
                        <svg class="absolute left-2 sm:left-3 top-1/2 -translate-y-1/2 text-gray-400 w-4 h-4 sm:w-5 sm:h-5"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M11 19a8 8 0 1 1 0-16 8 8 0 0 1 0 16z" />
                        </svg>

                        <input id="searchInput" name="search" type="search" placeholder="Cari produk..."
                            value="{{ isset($search) ? $search : request('search') }}"
                            class="w-full pl-8 sm:pl-11 pr-10 sm:pr-4 py-2 sm:py-3 text-sm sm:text-base text-gray-600 border-0 focus:outline-none focus:ring-0"
                            aria-label="Cari produk" />
                        <button type="button" id="clearSearchBtn" aria-label="Clear search"
                            class="hidden absolute right-2 sm:right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <button type="submit"
                        class="bg-[#4CD137] px-3 sm:px-5 md:px-6 py-2 sm:py-3 text-white hover:bg-green-600 transition flex items-center gap-2 sm:gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-search-icon">
                            <path d="m21 21-4.34-4.34" />
                            <circle cx="11" cy="11" r="8" />
                        </svg>
                        <span class="font-semibold text-sm sm:text-base">Cari</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- Grid Produk --}}
        <div
            class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4 md:gap-6 lg:gap-8 px-2 sm:px-6 md:px-12">

            {{-- Card Produk --}}
            @forelse ($produks as $produk)
                <div class="bg-white rounded-lg sm:rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
                    <a href="{{ route('user.produk.detail', $produk->id) }}" class="block">
                        <div class="relative w-full" style="padding-top: 100%;">
                            <img src="{{ asset('/storage/img/produk/' . $produk->gambarProduks->first()->gambar) }}"
                                class="absolute inset-0 w-full h-full object-cover"
                                alt="{{ $produk->nama ?? ($produk->nama_produk ?? 'Produk') }}">
                        </div>
                        <div class="px-2 sm:px-3 md:px-4 mt-2">
                            <h3 class="font-bold sm:font-extrabold text-gray-800 text-sm sm:text-base line-clamp-2">
                                {{ $produk->nama ?? ($produk->nama_produk ?? 'Produk') }}
                            </h3>
                        </div>
                    </a>
                    <div class="mt-2 px-2 sm:px-3 md:px-4 pb-3 sm:pb-4">
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex-1">
                                <a href="{{ route('user.produk.detail', $produk->id) }}"
                                    class="text-green-600 font-semibold text-xs sm:text-sm md:text-base">Rp
                                    {{ number_format($produk->harga ?? 0, 0, ',', '.') }},-</a>
                            </div>
                            <div>
                                <button aria-label="show-modal" type="button"
                                    class="show-modal-btn text-green-600 border border-green-600 px-2 sm:px-3 py-1.5 sm:py-2 rounded-md sm:rounded-lg hover:bg-green-600 hover:text-white transition"
                                    data-id="{{ $produk->id }}" data-price="{{ $produk->harga }}"
                                    data-name="{{ $produk->nama }}"
                                    data-img="{{ optional($produk->gambarProduks->first())->gambar ? asset('storage/img/produk/' . $produk->gambarProduks->first()->gambar) : asset('img/card/produk1.png') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                        class="sm:w-4 sm:h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-shopping-cart-icon lucide-shopping-cart">
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
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-600">Tidak ada produk yang ditemukan.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Include Show Modal -->
    @include('user.produk.show-modal')

    <!-- Produk JavaScript -->
    @vite('resources/js/user/produk/index.js')

    <style>
        /* Hide native search clear/cancel icon so only our custom clear button shows */
        #searchInput::-webkit-search-cancel-button,
        #searchInput::-webkit-search-decoration {
            -webkit-appearance: none;
        }

        #searchInput::-ms-clear {
            display: none;
            width: 0;
            height: 0;
        }
    </style>
@endcomponent
