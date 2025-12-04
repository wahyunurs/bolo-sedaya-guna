<x-app-layout>
    @include('user.components.navbar')

    <!-- SECTION KERANJANG BELANJA -->
    <section class="py-20 bg-[#e9ffe1] min-h-screen">
        <!-- Modal Flash Message -->
        @include('user.components.message-modal')

        <!-- JUDUL -->
        <h1 class="text-center text-4xl md:text-5xl font-extrabold tracking-wide text-green-800 mb-8 mt-8">
            KERANJANG BELANJA
        </h1>

        <!-- SEARCH + TRASH + CART -->
        <div class="flex items-center justify-center gap-3 px-6 mb-10">

            <!-- SEARCH BAR -->
            <div class="flex items-center rounded-xl w-full max-w-3xl overflow-hidden">
                <form id="searchForm" method="GET" role="search" class="w-full max-w-3xl">
                    <div class="flex items-center rounded-xl w-full overflow-hidden bg-white shadow-sm">
                        <div class="relative w-full">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35M11 19a8 8 0 1 1 0-16 8 8 0 0 1 0 16z" />
                            </svg>

                            <input id="searchInput" name="search" type="search"
                                placeholder="Cari keranjang belanja..."
                                value="{{ isset($search) ? $search : request('search') }}"
                                class="w-full pl-11 pr-4 py-3 text-gray-600 border-0 focus:outline-none focus:ring-0"
                                aria-label="Cari produk" />
                            <button type="button" id="clearSearchBtn" aria-label="Clear search"
                                class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <button type="submit"
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
                </form>
            </div>

            <!-- TOMBOL TRASH (opens confirmation modal) -->
            <button type="button" id="openBulkDeleteModalBtn"
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
            {{-- <button
                class="bg-green-600 hover:bg-green-700 text-white h-12 w-12 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-shopping-cart-icon lucide-shopping-cart">
                    <circle cx="8" cy="21" r="1" />
                    <circle cx="19" cy="21" r="1" />
                    <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                </svg>
            </button> --}}
        </div>

        <!-- LIST PRODUK -->
        <form id="bulkDeleteForm" method="POST" action="{{ route('user.keranjang.selectDestroy') }}">
            @csrf
            <div class="px-28 space-y-8">
                @forelse ($keranjangs as $keranjang)
                    <!-- ITEM -->
                    <div class="bg-white rounded-2xl shadow px-10 py-5 flex items-center justify-between">
                        <!-- KIRI -->
                        <div class="flex items-start gap-8 px-4 py-2">

                            <!-- CHECKBOX -->
                            <input type="checkbox" name="ids[]" value="{{ $keranjang->id }}"
                                class="bulk-check self-center w-7 h-7 rounded-lg">

                            <!-- FOTO -->
                            <img src="{{ asset('/storage/img/produk/' . $keranjang->produk->gambarProduks->first()->gambar) }}"
                                class="h-24 w-24 rounded-xl object-cover"
                                alt="{{ $keranjang->produk->nama ?? 'Produk' }}">
                            <!-- NAMA + JUMLAH -->
                            <div class="pt-1">
                                <p class="font-bold text-2xl text-gray-800">
                                    {{ $keranjang->produk->nama ?? 'Produk' }}</p>
                                <div class="flex items-center gap-4 mt-3">
                                    <div class="flex items-center gap-1">
                                        <span class="text-sm text-gray-700">Jumlah : </span>

                                        <button type="button" data-id="{{ $keranjang->id }}"
                                            class="decreaseBtn w-6 h-6 flex items-center justify-center bg-gray-100 rounded-sm text-green-700 hover:bg-gray-200 text-xs">-</button>

                                        <input type="text" value="{{ $keranjang->kuantitas }}"
                                            class="kuantitasInput w-12 text-center p-0.5 border rounded-sm text-sm"
                                            data-id="{{ $keranjang->id }}"
                                            data-price="{{ $keranjang->produk->harga }}" />

                                        <button type="button" data-id="{{ $keranjang->id }}"
                                            class="increaseBtn w-6 h-6 flex items-center justify-center bg-gray-100 rounded-sm text-green-700 hover:bg-gray-200 text-xs">+</button>

                                        <span
                                            class="ml-2 text-sm text-gray-600">{{ $keranjang->produk->satuan_produk ?? '' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- KANAN -->
                        <div class="flex items-center gap-7">
                            <div class="flex items-center gap-4 mr-3">

                                <!-- SUBTOTAL -->
                                <p class="text-green-700 font-bold text-2xl whitespace-nowrap subtotalText"
                                    data-id="{{ $keranjang->id }}">
                                    Rp {{ number_format($keranjang->subtotal, 0, ',', '.') }},-
                                </p>
                                <input type="hidden" name="subtotal[{{ $keranjang->id }}]"
                                    id="hiddenSubtotal-{{ $keranjang->id }}" value="{{ $keranjang->subtotal }}">

                            </div>

                            <!-- ICON DELETE (single-item delete form) -->
                            <button type="button"
                                class="single-delete-btn p-2 rounded-lg text-red-600 border border-red-600 hover:bg-red-600 hover:text-white transition"
                                data-id="{{ $keranjang->id }}" aria-label="Hapus item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-trash-icon lucide-trash">
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                    <path d="M3 6h18" />
                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                </svg>
                            </button>

                            <!-- ICON KERANJANG -->
                            <button
                                class="p-2 rounded-lg text-green-700 border border-green-700 hover:bg-green-700 hover:text-white transition">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-shopping-cart-icon lucide-shopping-cart">
                                    <circle cx="8" cy="21" r="1" />
                                    <circle cx="19" cy="21" r="1" />
                                    <path
                                        d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-600">Tidak ada keranjang yang ditemukan.</p>
                    </div>
                @endforelse
            </div>
        </form>

        <div class="mt-8 flex justify-center">
            @if (isset($produks))
                {{ $produks->appends(['search' => $search ?? request('search')])->links() }}
            @endif
        </div>

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

        <!-- KONFIRMASI HAPUS MODAL -->
        @include('user.keranjang.konfirmasi-hapus')

</x-app-layout>
