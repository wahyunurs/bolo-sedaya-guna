@component('user.components.user-layout')
    @include('user.components.navbar')

    <section class="pt-20 sm:pt-24 pb-8 bg-[#e9ffe1] min-h-screen px-4 sm:px-6 lg:px-10">

        <!-- Modal Flash Message -->
        @include('user.components.message-modal')


        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 lg:gap-10 mt-4 sm:mt-8 lg:mt-14">

            <!-- KOLOM KIRI (GAMBAR) -->
            <div>

                {{-- Gambar Utama --}}
                <div class="relative mx-auto w-full flex justify-center">
                    <div
                        class="relative rounded-lg sm:rounded-xl overflow-hidden shadow-md w-full max-w-sm sm:max-w-md lg:max-w-lg aspect-square">

                        @php
                            $gambarUtama = optional($produk->gambarProduks->where('utama', true)->first())->gambar;
                            $imgUtama = $gambarUtama
                                ? asset('storage/img/produk/' . $gambarUtama)
                                : asset('img/card/produk1.png');

                            $totalGambar = $produk->gambarProduks->count();
                            $posisiGambarUtama =
                                $produk->gambarProduks->values()->search(function ($g) use ($gambarUtama) {
                                    return $g->gambar === $gambarUtama;
                                }) + 1;
                        @endphp

                        <img id="mainProductImage" src="{{ $imgUtama }}"
                            data-current-index="{{ ($posisiGambarUtama ?? 1) - 1 }}"
                            class="absolute inset-0 w-full h-full object-contain p-2 cursor-pointer"
                            alt="{{ $produk->nama }}">

                        <!-- Click zones: left and right transparent overlays to navigate prev/next -->
                        <div id="imgPrevZone" class="absolute inset-y-0 left-0 w-1/3 cursor-pointer" aria-hidden="true">
                        </div>
                        <div id="imgNextZone" class="absolute inset-y-0 right-0 w-1/3 cursor-pointer" aria-hidden="true">
                        </div>

                        {{-- Card posisi gambar --}}
                        <div
                            class="absolute top-2 left-2 sm:top-3 sm:left-3 bg-white px-2 sm:px-3 py-1 rounded-md sm:rounded-lg shadow text-xs sm:text-sm font-semibold text-gray-700">
                            {{ $posisiGambarUtama }} / {{ $totalGambar }}
                        </div>
                    </div>
                </div>



                {{-- Gambar Thumbnail --}}
                <div class="flex gap-2 sm:gap-3 md:gap-4 mt-3 sm:mt-4 overflow-x-auto pb-2" id="thumbnailsContainer">
                    @foreach ($produk->gambarProduks as $g)
                        <div data-index="{{ $loop->index }}"
                            class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 rounded-md sm:rounded-lg overflow-hidden flex-shrink-0 thumbnail-item cursor-pointer {{ $loop->iteration == $posisiGambarUtama ? 'border-2 border-green-500' : 'border border-gray-200' }}">
                            <img src="{{ asset('storage/img/produk/' . $g->gambar) }}" class="w-full h-full object-cover"
                                alt="gambar produk">
                        </div>
                    @endforeach
                </div>

            </div>

            <!-- KOLOM KANAN (DETAIL PRODUK) -->
            <div class="flex flex-col justify-start">

                {{-- Judul --}}
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-green-900 mb-3 sm:mb-4">
                    {{ $produk->nama }}
                </h1>

                {{-- Deskripsi --}}
                <p class="text-sm sm:text-base text-gray-700 leading-relaxed mb-4 sm:mb-6">
                    {{ $produk->deskripsi }}
                </p>

                {{-- Stok --}}
                <p class="text-gray-700 text-base sm:text-lg mb-2 sm:mb-3">
                    <span class="font-bold text-green-700">Stok:</span>
                    {{ $produk->stok }} {{ $produk->satuan_produk }}
                </p>

                {{-- Harga --}}
                <p class="text-xl sm:text-2xl font-extrabold text-green-700 mb-6 sm:mb-8">
                    Rp {{ number_format($produk->harga, 0, ',', '.') }},-
                </p>

                {{-- Tombol Aksi --}}
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">

                    {{-- Tombol Tambah Keranjang --}}
                    <button id="openTambahKeranjang" data-price="{{ $produk->harga }}"
                        class="flex items-center justify-center gap-2 bg-[#ff7700] text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg sm:rounded-xl hover:bg-[#e66a00] transition font-semibold shadow text-sm sm:text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            class="sm:w-[18px] sm:h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-shopping-cart">
                            <circle cx="8" cy="21" r="1" />
                            <circle cx="19" cy="21" r="1" />
                            <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                        </svg>
                        <span>Tambah Keranjang</span>
                    </button>

                    {{-- Tombol Beli Sekarang --}}
                    <button id="openBeliSekarang" data-price="{{ $produk->harga }}"
                        class="flex items-center justify-center gap-2 bg-[#2fca00] text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg sm:rounded-xl hover:bg-[#06b900] transition font-semibold shadow text-sm sm:text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="sm:w-6 sm:h-6"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-wallet-icon lucide-wallet">
                            <path
                                d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1" />
                            <path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4" />
                        </svg>
                        <span>Beli Sekarang</span>
                    </button>

                </div>
            </div>

        </div>

    </section>

    @include('user.produk.tambah-keranjang')
    @include('user.produk.beli-sekarang')

    <!-- Detail Produk JavaScript -->
    @vite('resources/js/user/produk/detail.js')
    @vite('resources/js/user/produk/beli-sekarang.js')
@endcomponent
