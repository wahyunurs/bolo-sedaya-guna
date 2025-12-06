<!-- Bulk delete confirmation modal -->
<div id="bulkDeleteModal"
    class="fixed inset-0 bg-black bg-opacity-50 {{ session('error') ? 'flex' : 'hidden' }} justify-center items-center z-[999] p-4">
    <div class="bg-white w-full max-w-md p-4 sm:p-6 lg:p-8 rounded-xl sm:rounded-2xl shadow-xl relative">
        <!-- Close icon top-right -->
        <button id="btnCloseModalTop" type="button" aria-label="Tutup"
            class="absolute top-2 right-2 sm:top-3 sm:right-3 p-1.5 sm:p-2 rounded-md border border-transparent hover:border-gray-600 hover:bg-gray-50 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-600" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
        </button>

        <!-- Header -->
        <h2 class="text-lg sm:text-xl font-bold text-green-800 mb-3 sm:mb-4 pr-8">Konfirmasi Hapus</h2>

        <!-- Divider under header (full width across modal content) -->
        <div class="-mx-4 sm:-mx-6 lg:-mx-8 h-px bg-gray-200 mb-4 sm:mb-6"></div>

        {{-- <h3 class="text-lg font-semibold text-gray-800">Konfirmasi Hapus</h3> --}}
        <p id="bulkDeleteMessage" class="text-xs sm:text-sm text-gray-600">
            Anda akan menghapus <span id="bulkDeleteCount" class="font-bold">0</span> item dari keranjang. Apakah Anda
            yakin ingin melanjutkan?
        </p>
        <div class="mt-4 flex flex-col sm:flex-row justify-end gap-2 sm:gap-3">
            <button id="bulkDeleteCancel" type="button"
                class="w-full sm:w-auto px-4 py-2 rounded text-sm sm:text-base bg-gray-200 hover:bg-gray-300 order-2 sm:order-1">Batal</button>
            <button id="bulkDeleteConfirm" type="button"
                class="w-full sm:w-auto px-4 py-2 rounded text-sm sm:text-base bg-red-600 text-white hover:bg-red-700 order-1 sm:order-2">Hapus</button>
        </div>

        <!-- Hidden single-delete form: action will be set dynamically by JS -->
        <form id="singleDeleteForm" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>

    </div>
</div>

<!-- Konfirmasi Hapus JavaScript -->
@vite('resources/js/user/keranjang/konfirmasi-hapus.js')
