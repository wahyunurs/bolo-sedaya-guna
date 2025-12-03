<!-- MODAL TAMBAH KERANJANG -->
<div id="modalTambahKeranjang"
    class="fixed inset-0 bg-black bg-opacity-50 {{ session('error') ? 'flex' : 'hidden' }} justify-center items-center z-[999]">

    <div class="bg-white w-[90%] max-w-md p-8 rounded-2xl shadow-xl relative">

        <!-- Close icon top-right -->
        <button id="btnCloseModalTop" type="button" aria-label="Tutup"
            class="absolute top-3 right-3 p-2 rounded-md border border-transparent hover:border-gray-600 hover:bg-gray-50 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
        </button>

        <!-- Header -->
        <h2 class="text-xl font-bold text-green-800 mb-4">Tambah ke Keranjang</h2>

        <!-- Divider under header (full width across modal content) -->
        <div class="-mx-8 h-px bg-gray-200 mb-6"></div>

        <!-- Produk -->
        <div class="flex items-center gap-4 mb-4">
            <img src="{{ $imgUtama }}" class="w-20 h-20 rounded-lg object-cover border">
            <div>
                <p class="font-semibold text-green-900 text-lg">{{ $produk->nama }}</p>
                <p class="text-gray-600">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Input Jumlah -->
        <label class="font-semibold text-gray-700">Jumlah</label>
        <div class="flex items-center gap-2 mt-1 mb-4">
            <button type="button" id="btnDecrease" aria-label="Kurangi jumlah"
                class="w-10 h-10 flex items-center justify-center bg-gray-200 hover:bg-gray-300 rounded-lg text-lg font-semibold">-</button>

            <input id="jumlahInput" type="text" value="1"
                class="text-center w-28 border rounded-lg px-2 py-2 focus:ring-2 focus:ring-green-500" />

            <button type="button" id="btnIncrease" aria-label="Tambah jumlah"
                class="w-10 h-10 flex items-center justify-center bg-gray-200 hover:bg-gray-300 rounded-lg text-lg font-semibold">+</button>
        </div>

        {{-- Error message shown under jumlah when stok tidak mencukupi or other modal errors --}}
        @if (session('error'))
            <p id="modalErrorMessage" class="text-red-600 text-sm mt-1 mb-3">{{ session('error') }}</p>
        @endif

        <!-- Subtotal -->
        <div class="flex justify-between font-semibold text-green-800 text-lg mb-6">
            <span>Subtotal</span>
            <span id="subtotalText">
                Rp {{ number_format($produk->harga, 0, ',', '.') }}
            </span>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end gap-4">
            <form action="{{ route('user.produk.tambahKeranjang') }}" method="POST">
                @csrf
                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                <input type="hidden" name="jumlah" id="jumlahHidden">

                <button type="submit"
                    class="px-5 py-2 rounded-lg bg-[#ff7700] hover:bg-[#e66a00] text-white font-semibold">
                    Tambah
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Tambah Produk JavaScript -->
@vite('resources/js/user/produk/tambah-keranjang.js')
