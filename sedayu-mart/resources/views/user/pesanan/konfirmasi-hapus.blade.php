<!-- Bulk delete confirmation modal -->
<div id="bulkDeleteModal"
    class="fixed inset-0 bg-black bg-opacity-50 {{ session('error') ? 'flex' : 'hidden' }} justify-center items-center z-[999] px-4">
    <div class="bg-white w-full max-w-md p-6 sm:p-8 rounded-xl sm:rounded-2xl shadow-xl relative">
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
        <h2 class="text-xl font-bold text-green-800 mb-4">Konfirmasi Hapus</h2>

        <!-- Divider under header (full width across modal content) -->
        <div class="-mx-8 h-px bg-gray-200 mb-6"></div>

        {{-- <h3 class="text-lg font-semibold text-gray-800">Konfirmasi Hapus</h3> --}}
        <p id="bulkDeleteMessage" class="text-sm sm:text-base text-gray-600">
            Anda akan menghapus <span id="bulkDeleteCount" class="font-bold">0</span> item dari keranjang. Apakah Anda
            yakin ingin melanjutkan?
        </p>
        <div class="mt-4 flex flex-col sm:flex-row justify-end gap-2 sm:gap-3">
            <button id="bulkDeleteCancel" type="button"
                class="w-full sm:w-auto px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 text-sm sm:text-base">Batal</button>
            <button id="bulkDeleteConfirm" type="button"
                class="w-full sm:w-auto px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700 text-sm sm:text-base">Hapus</button>
        </div>

        <!-- Hidden single-delete form: action will be set dynamically by JS -->
        <form id="singleDeleteForm" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>

    </div>
</div>

<!-- Konfirmasi Hapus JavaScript -->
@vite('resources/js/user/pesanan/konfirmasi-hapus.js')
