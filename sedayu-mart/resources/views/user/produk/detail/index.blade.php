@component('user.components.user-layout')
    @include('user.components.navbar')

    <section
        class="pt-24 pb-10 min-h-screen bg-gradient-to-br from-gray-50 via-green-50 to-emerald-50 px-4 sm:px-6 lg:px-10">

        {{-- Flash Message --}}
        @include('user.components.message-modal')

        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 mt-6">

            {{-- ================= KOLOM KIRI : GAMBAR ================= --}}
            <div>
                <div class="relative mx-auto max-w-lg">
                    <div
                        class="relative aspect-square rounded-2xl overflow-hidden bg-white shadow-xl border border-gray-100">

                        @php
                            $gambarUtama = optional($produk->gambarProduks->where('utama', true)->first())->gambar;
                            $imgUtama = $gambarUtama
                                ? asset('storage/img/produk/' . $gambarUtama)
                                : asset('img/card/produk1.png');

                            $totalGambar = $produk->gambarProduks->count();
                            $posisiGambarUtama =
                                $produk->gambarProduks->values()->search(fn($g) => $g->gambar === $gambarUtama) + 1;
                        @endphp

                        <img id="mainProductImage" src="{{ $imgUtama }}"
                            data-current-index="{{ ($posisiGambarUtama ?? 1) - 1 }}"
                            class="absolute inset-0 w-full h-full object-contain p-4 cursor-pointer transition-transform duration-300 hover:scale-105"
                            alt="{{ $produk->nama }}">

                        {{-- Click Zones (JS Compatible) --}}
                        <div id="imgPrevZone"
                            class="absolute inset-y-0 left-0 w-1/3 flex items-center justify-start cursor-pointer group">
                            <div
                                class="ml-3 w-10 h-10 rounded-full bg-white/80 backdrop-blur shadow-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                            </div>
                        </div>

                        <div id="imgNextZone"
                            class="absolute inset-y-0 right-0 w-1/3 flex items-center justify-end cursor-pointer group">
                            <div
                                class="mr-3 w-10 h-10 rounded-full bg-white/80 backdrop-blur shadow-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>



                        {{-- Counter --}}
                        <div
                            class="absolute top-3 left-3 bg-white/90 backdrop-blur px-3 py-1.5 rounded-lg shadow text-sm font-semibold text-gray-700">
                            {{ $posisiGambarUtama }} / {{ $totalGambar }}
                        </div>
                    </div>
                </div>

                {{-- Thumbnail --}}
                <div class="flex gap-3 mt-5 overflow-x-auto pb-2" id="thumbnailsContainer">

                    @foreach ($produk->gambarProduks as $g)
                        <div data-index="{{ $loop->index }}"
                            class="thumbnail-item
                   w-20 h-20 rounded-xl overflow-hidden flex-shrink-0 cursor-pointer
                   transition-all duration-300
                   {{ $loop->iteration == $posisiGambarUtama
                       ? 'border-2 border-green-500 shadow-lg'
                       : 'border border-gray-200 hover:border-green-400 hover:shadow-md' }}">

                            <img src="{{ asset('storage/img/produk/' . $g->gambar) }}"
                                class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                                alt="thumbnail">
                        </div>
                    @endforeach
                </div>


            </div>

            {{-- ================= KOLOM KANAN : DETAIL ================= --}}
            <div class="flex flex-col">

                {{-- Judul --}}
                <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-4">
                    {{ $produk->nama }}
                </h1>

                {{-- Deskripsi --}}
                <p class="text-gray-700 leading-relaxed mb-6">
                    {{ $produk->deskripsi }}
                </p>

                {{-- ================= VARIAN ================= --}}
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">
                        Varian Produk
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse ($varians as $varian)
                            <div
                                class="group bg-white rounded-2xl border border-gray-100 shadow-lg hover:shadow-xl transition-all duration-300 p-4 flex gap-4">

                                {{-- Gambar --}}
                                <div class="flex-shrink-0">
                                    @if ($varian->gambar)
                                        <img src="{{ asset('storage/img/varian/' . $varian->gambar) }}"
                                            class="w-16 h-16 rounded-xl object-cover border shadow">
                                    @else
                                        <div
                                            class="w-16 h-16 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Info --}}
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <p class="font-bold text-gray-900 truncate">
                                            {{ $varian->nama }}
                                        </p>
                                    </div>

                                    <div class="text-sm text-gray-600 space-y-0.5">
                                        <p class="font-semibold text-green-700">
                                            Rp {{ number_format($varian->harga, 0, ',', '.') }}
                                        </p>
                                        <p>Stok: <span class="font-semibold">{{ $varian->stok }}</span></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Incluede Tambah Keranjang Modal -->
                            @include('user.produk.detail.tambah-keranjang', [
                                'produk' => $produk,
                                'varian' => $varian,
                            ])

                            <!-- Include Beli Sekarang Modal -->
                            @include('user.produk.detail.beli-sekarang', [
                                'produk' => $produk,
                                'varian' => $varian,
                            ])
                        @empty
                            <div class="col-span-2 text-center py-10 bg-white rounded-2xl border border-gray-100 shadow">
                                <p class="text-gray-500 italic">
                                    Tidak ada varian tersedia.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- ================= AKSI ================= --}}
                <div class="flex flex-col sm:flex-row gap-4">

                    <button type="button" data-modal-target="tambah-keranjang-modal-{{ $produk->id }}"
                        data-modal-toggle="tambah-keranjang-modal-{{ $produk->id }}" title="Tambah Keranjang"
                        class="flex-1 flex items-center justify-center gap-2 px-6 py-3 rounded-xl
                        bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold shadow-lg
                        hover:from-orange-600 hover:to-orange-700 transition">
                        🛒 Tambah Keranjang
                    </button>

                    <button type="button" data-modal-target="beli-sekarang-modal-{{ $produk->id }}"
                        data-modal-toggle="beli-sekarang-modal-{{ $produk->id }}" title="Beli Sekarang"
                        class="flex-1 flex items-center justify-center gap-2 px-6 py-3 rounded-xl
                        bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold shadow-lg
                        hover:from-green-700 hover:to-emerald-700 transition">
                        ⚡ Beli Sekarang
                    </button>
                </div>
            </div>
        </div>
    </section>
@endcomponent
