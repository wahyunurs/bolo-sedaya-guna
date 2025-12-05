<div id="editModal" class="hidden fixed inset-0 z-50 items-center justify-center">
    <div id="editModalOverlay" class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative bg-white rounded-lg shadow-lg w-full max-w-md mx-4">
        <div class="flex items-center justify-between px-4 py-3 border-b">
            <h3 class="text-lg font-semibold">Edit Rekening</h3>
            <button id="editModalClose" type="button" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 8.586L15.95 2.636a1 1 0 111.414 1.414L11.414 10l5.95 5.95a1 1 0 01-1.414 1.414L10 11.414l-5.95 5.95a1 1 0 01-1.414-1.414L8.586 10 2.636 4.05A1 1 0 014.05 2.636L10 8.586z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <form id="editRekeningForm" action="" method="POST" class="p-6" novalidate>
            @csrf
            @method('PUT')
            <div class="space-y-3">
                <div>
                    <label for="edit_nama_bank" class="block text-sm font-medium text-gray-700">Nama Bank</label>
                    <input id="edit_nama_bank" name="nama_bank" type="text" required maxlength="100"
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
                </div>

                <div>
                    <label for="edit_nomor_rekening" class="block text-sm font-medium text-gray-700">Nomor
                        Rekening</label>
                    <input id="edit_nomor_rekening" name="nomor_rekening" type="text" required maxlength="50"
                        inputmode="numeric" pattern="\d+" title="Hanya boleh berisi angka"
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
                </div>

                <div>
                    <label for="edit_atas_nama" class="block text-sm font-medium text-gray-700">Atas Nama</label>
                    <input id="edit_atas_nama" name="atas_nama" type="text" required maxlength="100"
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
                </div>
            </div>

            <div class="flex items-center justify-end space-x-2 mt-4">
                <button id="editModalCancel" type="button" class="px-4 py-2 bg-gray-200 rounded-md">Batal</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md">Perbarui</button>
            </div>
        </form>
    </div>
</div>
