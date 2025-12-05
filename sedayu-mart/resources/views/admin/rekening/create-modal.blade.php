<div id="createModal" class="hidden fixed inset-0 z-50 items-center justify-center">
    <div id="createModalOverlay" class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative bg-white rounded-lg shadow-lg w-full max-w-md mx-4">
        <div class="flex items-center justify-between px-4 py-3 border-b">
            <h3 class="text-lg font-semibold">Tambah Rekening</h3>
            <button id="createModalClose" type="button" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 8.586L15.95 2.636a1 1 0 111.414 1.414L11.414 10l5.95 5.95a1 1 0 01-1.414 1.414L10 11.414l-5.95 5.95a1 1 0 01-1.414-1.414L8.586 10 2.636 4.05A1 1 0 014.05 2.636L10 8.586z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <form id="createRekeningForm" action="{{ route('admin.rekening.store') }}" method="POST" class="p-6"
            novalidate>
            @csrf
            <div class="space-y-3">
                <div>
                    <label for="nama_bank" class="block text-sm font-medium text-gray-700">Nama Bank</label>
                    <input id="nama_bank" name="nama_bank" type="text" required maxlength="100"
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
                </div>

                <div>
                    <label for="nomor_rekening" class="block text-sm font-medium text-gray-700">Nomor Rekening</label>
                    <input id="nomor_rekening" name="nomor_rekening" type="text" required maxlength="50"
                        inputmode="numeric" pattern="\d*" oninput="this.value = this.value.replace(/\D/g, '')"
                        onpaste="event.preventDefault(); const pasted = (event.clipboardData || window.clipboardData).getData('text').replace(/\D/g,''); document.execCommand('insertText', false, pasted);"
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
                </div>

                <div>
                    <label for="atas_nama" class="block text-sm font-medium text-gray-700">Atas Nama</label>
                    <input id="atas_nama" name="atas_nama" type="text" required maxlength="100"
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
                </div>
            </div>

            <div class="flex items-center justify-end space-x-2 mt-4">
                <button id="createModalCancel" type="button" class="px-4 py-2 bg-gray-200 rounded-md">Batal</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md">Simpan</button>
            </div>
        </form>
    </div>
</div>
