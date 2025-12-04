<!-- Product Quick Modal -->
<div id="modalProductQuick" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-[999]">
    <div class="bg-white w-[90%] max-w-md p-8 rounded-2xl shadow-xl relative">
        <button id="modalProductClose" type="button" aria-label="Tutup"
            class="absolute top-3 right-3 p-2 rounded-md border border-transparent hover:border-gray-600 hover:bg-gray-50 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
        </button>

        <div class="flex items-center gap-4 mb-4">
            {{-- static placeholder — JS will replace src when opening the modal --}}
            <img src="{{ asset('img/card/produk1.png') }}" id="modalProductImg"
                class="w-20 h-20 rounded-lg object-cover border" alt="Produk">
            <div>
                <p id="modalProductName" class="font-semibold text-green-900 text-lg">Produk</p>
                <p id="modalProductPrice" class="text-gray-600">Rp 0</p>
            </div>
        </div>

        <label class="font-semibold text-gray-700">Jumlah</label>
        <div class="flex items-center gap-2 mt-1 mb-4">
            <button type="button" id="modalDecrease" aria-label="Kurangi jumlah"
                class="w-10 h-10 flex items-center justify-center bg-gray-200 hover:bg-gray-300 rounded-lg text-lg font-semibold">-</button>

            <input id="modalJumlahInput" type="text" value="1"
                class="text-center w-28 border rounded-lg px-2 py-2 focus:ring-2 focus:ring-green-500" />

            <button type="button" id="modalIncrease" aria-label="Tambah jumlah"
                class="w-10 h-10 flex items-center justify-center bg-gray-200 hover:bg-gray-300 rounded-lg text-lg font-semibold">+</button>
        </div>

        <div class="flex justify-between font-semibold text-green-800 text-lg mb-4">
            <span>Subtotal</span>
            <span id="modalSubtotalText">Rp 0</span>
        </div>

        <div class="flex gap-3 justify-center mt-6 items-center">
            <form id="formTambahKeranjang" method="POST" action="{{ route('user.produk.tambahKeranjang') }}">
                @csrf
                <input type="hidden" name="produk_id" id="formTambahProdukId" value="">
                <input type="hidden" name="jumlah" id="formTambahJumlah" value="1">
                <button type="submit" style="display:inline-flex; align-items:center; gap:8px; white-space:nowrap;"
                    class="px-4 py-2 rounded-lg bg-[#ff7700] hover:bg-[#e66a00] text-white font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-shopping-cart">
                        <circle cx="8" cy="21" r="1" />
                        <circle cx="19" cy="21" r="1" />
                        <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                    </svg>
                    Tambah Keranjang</button>
            </form>

            <form id="formBeliSekarang" method="POST" action="{{ route('user.produk.beliSekarang') }}">
                @csrf
                <input type="hidden" name="produk_id" id="formBeliProdukId" value="">
                <input type="hidden" name="kuantitas" id="formBeliKuantitas" value="1">
                <button type="submit" style="display:inline-flex; align-items:center; gap:8px; white-space:nowrap;"
                    class="px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-wallet-icon lucide-wallet">
                        <path
                            d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1" />
                        <path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4" />
                    </svg>
                    Beli Sekarang</button>
            </form>
        </div>
    </div>
</div>

<!-- Show modal script -->
@vite('resources/js/user/produk/show-modal.js')
