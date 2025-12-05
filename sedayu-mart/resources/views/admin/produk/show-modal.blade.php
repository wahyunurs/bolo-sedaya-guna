<!-- Produk detail modal -->
<div id="produkShowModal" data-id="{{ $produk->id }}"
    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-[1000]">
    <div class="bg-white w-[95%] max-w-4xl p-8 rounded-2xl shadow-lg relative">
        <button id="produkShowClose" type="button" aria-label="Tutup"
            class="absolute top-4 right-4 p-2 rounded-md border hover:bg-gray-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
        </button>

        <h2 class="text-2xl font-bold text-gray-800 mb-3">Detail Produk</h2>
        <div class="-mx-6 h-px bg-gray-200 mb-6"></div>

        <div class="space-y-4">
            <!-- Images row at the top: up to 5 per row -->
            <div class="mb-4">
                @if ($produk->gambarProduks && $produk->gambarProduks->count())
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2">
                        @foreach ($produk->gambarProduks as $g)
                            <img src="{{ $g->gambar ? asset('storage/img/produk/' . $g->gambar) : asset('img/card/produk1.png') }}"
                                alt="thumb" class="w-full h-28 object-cover rounded cursor-pointer">
                        @endforeach
                    </div>
                @else
                    <div class="w-full h-28 bg-gray-100 rounded-md flex items-center justify-center text-gray-500">
                        Tidak ada gambar</div>
                @endif
            </div>
            <div>
                <p class="text-sm text-gray-500">Nama</p>
                <p class="text-lg font-semibold text-gray-900">{{ $produk->nama ?? '-' }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Harga</p>
                    <p class="font-medium text-gray-800">Rp {{ number_format($produk->harga ?? 0, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Stok</p>
                    <p class="font-medium text-gray-800">{{ $produk->stok ?? 0 }} {{ $produk->satuan_produk ?? '' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Berat</p>
                    <p class="font-medium text-gray-800">{{ $produk->berat ?? 0 }} gram</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Satuan</p>
                    <p class="font-medium text-gray-800">{{ $produk->satuan_produk ?? '-' }}</p>
                </div>
            </div>

            <div>
                <p class="text-sm text-gray-500">Deskripsi</p>
                <p class="text-gray-700">{{ $produk->deskripsi ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Show Modal JavaScript -->
@vite('resources/js/admin/produk/show-modal.js')
