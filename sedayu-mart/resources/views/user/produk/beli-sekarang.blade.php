<!-- MODAL BELI SEKARANG -->
<div id="modalBeliSekarang" data-produk-id="{{ $produk->id }}" data-price="{{ $produk->harga }}"
    data-checkout-route="{{ route('user.produk.checkout') }}"
    class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-[999]">

    <div class="bg-white w-[90%] max-w-md p-8 rounded-2xl shadow-xl relative">

        <!-- Close button -->
        <button id="btnCloseModalBeli" type="button" aria-label="Tutup"
            class="absolute top-3 right-3 p-2 rounded-md border border-transparent hover:border-gray-600 hover:bg-gray-50 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
        </button>

        <h2 class="text-xl font-bold text-green-800 mb-4">Beli Sekarang</h2>
        <div class="-mx-8 h-px bg-gray-200 mb-6"></div>

        <div class="flex items-center gap-4 mb-4">
            <img src="{{ $imgUtama }}" class="w-20 h-20 rounded-lg object-cover border">
            <div>
                <p class="font-semibold text-green-900 text-lg">{{ $produk->nama }}</p>
                <p class="text-gray-600">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Input Kuantitas -->
        <label class="font-semibold text-gray-700">Jumlah</label>
        <div class="flex items-center gap-2 mt-1 mb-4">
            <button type="button" id="btnDecreaseBeli" class="w-10 h-10 bg-gray-200 rounded-lg">-</button>

            <input id="kuantitasInputBeli" type="text" value="1"
                class="text-center w-28 border rounded-lg px-2 py-2" />

            <button type="button" id="btnIncreaseBeli" class="w-10 h-10 bg-gray-200 rounded-lg">+</button>
        </div>

        <div class="flex justify-between font-semibold text-green-800 text-lg mb-6">
            <span>Subtotal</span>
            <span id="subtotalTextBeli">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
        </div>

        <div class="flex justify-end">
            <a id="btnCheckoutBeliSekarang" href="#"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg">
                Beli Sekarang
            </a>
        </div>
    </div>
</div>

@vite('resources/js/user/produk/beli-sekarang.js')
