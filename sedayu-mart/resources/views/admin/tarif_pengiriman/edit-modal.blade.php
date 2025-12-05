<!-- Edit Modal Tarif Pengiriman -->
<div id="editModal" data-base-url="{{ url('admin/tarif-pengiriman') }}"
    class="fixed inset-0 z-50 hidden items-center justify-center">
    <div id="editModalOverlay" class="absolute inset-0 bg-black opacity-50"></div>

    <div class="relative bg-white rounded-lg shadow-lg w-full max-w-md mx-4 z-10" role="dialog" aria-modal="true">
        <div class="flex items-center justify-between px-4 py-3 border-b">
            <h3 class="text-lg text-green-600 font-semibold">Ubah Tarif Pengiriman</h3>
            <button type="button" id="editModalClose" class="text-gray-500 hover:text-gray-700" aria-label="Tutup">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="editTarifForm" method="POST" class="p-6" action="">
            @csrf
            @method('PUT')

            <input type="hidden" id="edit_tarif_id" name="id" value="">

            <div class="mb-3">
                <label for="edit_kabupaten" class="block text-sm font-medium text-gray-700">Kabupaten</label>
                <input type="text" name="kabupaten" id="edit_kabupaten" required
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <div class="mb-3">
                <label for="edit_tarif_per_kg" class="block text-sm font-medium text-gray-700">Tarif Per Kg</label>
                <input type="number" name="tarif_per_kg" id="edit_tarif_per_kg" required min="0"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" id="editModalCancel"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Batal</button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Tarif Pengiriman Modal Javascript -->
@vite('resources/js/admin/tarif_pengiriman/edit-modal.js')
