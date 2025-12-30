<!-- Edit Varian Modal -->
<div id="edit-varian-modal-{{ $varian->id }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 flex justify-center items-center">
    <div class="relative p-4 w-full max-w-2xl h-full flex items-center justify-center">
        <div class="relative bg-white rounded-2xl shadow-2xl overflow-hidden w-full max-h-[90vh] flex flex-col">
            <!-- Modal header -->
            <div
                class="relative p-6 md:p-7 bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-600 overflow-hidden flex-shrink-0">
                <div
                    class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PHBhdGggZD0iTTM2IDE2YzAtNC40MTggMy41ODItOCA4LThzOCAzLjU4MiA4IDgtMy41ODIgOC04IDgtOC0zLjU4Mi04LTh6bS0yOCAwYzAtNC40MTggMy41ODItOCA4LThzOCAzLjU4MiA4IDgtMy41ODIgOC04IDgtOC0zLjU4Mi04LTh6TTggNDhjMC00LjQxOCAzLjU4Mi04IDgtOHM4IDMuNTgyIDggOC0zLjU4MiA4LTggOC04LTMuNTgyLTgtOHptMjggMGMwLTQuNDE4IDMuNTgyLTggOC04czggMy41ODIgOCA4LTMuNTgyIDgtOCA4LTgtMy41ODItOC04eiIvPjwvZz48L2c+PC9zdmc+')] opacity-30">
                </div>

                <div class="relative flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="flex-shrink-0 w-14 h-14 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center ring-2 ring-white/30 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="text-white">
                                <path
                                    d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                <path d="m15 5 4 4" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-blue-100 uppercase tracking-wider mb-1">Edit Data</p>
                            <h3 class="text-xl md:text-2xl font-bold text-white leading-tight">Edit Varian</h3>
                        </div>
                    </div>
                    <button type="button"
                        class="flex-shrink-0 text-white/90 bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-lg text-sm w-10 h-10 inline-flex justify-center items-center transition-all duration-200 hover:scale-110"
                        data-modal-hide="edit-varian-modal-{{ $varian->id }}">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2.5" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
            </div>

            <!-- Modal body -->
            <form action="{{ route('admin.produk.varian.update', [$produk->id, $varian->id]) }}" method="POST"
                enctype="multipart/form-data" class="flex-1 flex flex-col overflow-hidden">
                @csrf
                @method('PUT')

                <div class="flex-1 overflow-y-auto p-4 md:p-6 space-y-4">
                    <!-- Gambar Upload -->
                    <div
                        class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100">
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="flex-shrink-0 w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="text-white">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                    <circle cx="9" cy="9" r="2" />
                                    <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                                </svg>
                            </div>
                            <div>
                                <label class="text-sm font-bold text-gray-900">Gambar Varian</label>
                                <p class="text-xs text-gray-500">Upload gambar baru (max 5MB)</p>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row gap-4 items-start">
                            <!-- Current Photo Preview -->
                            <div class="flex-shrink-0">
                                @if ($varian->gambar)
                                    <img id="current-foto-{{ $varian->id }}"
                                        src="{{ asset('storage/img/varian/' . $varian->gambar) }}"
                                        alt="{{ $varian->nama }}"
                                        class="w-40 h-40 object-cover rounded-xl shadow-md border-2 border-gray-200">
                                @else
                                    <div id="current-foto-{{ $varian->id }}"
                                        class="w-40 h-40 rounded-xl bg-gray-100 flex items-center justify-center border-2 border-gray-200">
                                        <svg class="w-16 h-16 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                @endif
                                <div id="edit-image-preview-varian-{{ $varian->id }}" class="hidden">
                                    <img id="edit-preview-img-varian-{{ $varian->id }}" src="" alt="Preview"
                                        class="w-40 h-40 object-cover rounded-xl shadow-md border-2 border-gray-200">
                                </div>
                            </div>

                            <!-- Upload Area -->
                            <div class="flex-1">
                                <div
                                    class="relative border-2 border-dashed border-gray-300 rounded-xl p-6 hover:border-blue-400 transition-colors duration-300">
                                    <input type="file" id="foto-varian-{{ $varian->id }}" name="gambar"
                                        accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                        onchange="previewEditImageVarian{{ $varian->id }}(event)">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                            fill="none" viewBox="0 0 48 48">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-600">
                                            <span class="font-semibold text-blue-600">Klik untuk upload</span>
                                            atau drag and drop
                                        </p>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF, SVG hingga 5MB</p>
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-500" id="file-name-varian-{{ $varian->id }}"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Nama -->
                    <div
                        class="bg-white rounded-xl p-5 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100">
                        <div class="flex items-start gap-3">
                            <div
                                class="flex-shrink-0 w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="text-white">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <label for="nama-{{ $varian->id }}"
                                    class="block text-xs font-medium text-gray-900 uppercase tracking-wide mb-2">Nama
                                    Varian</label>
                                <input type="text" id="nama-{{ $varian->id }}" name="nama"
                                    value="{{ $varian->nama }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Masukkan nama varian..." required>
                            </div>
                        </div>
                    </div>

                    <!-- Harga -->
                    <div
                        class="bg-white rounded-xl p-5 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100">
                        <div class="flex items-start gap-3">
                            <div
                                class="flex-shrink-0 w-10 h-10 rounded-lg bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="text-white">
                                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <label for="harga-{{ $varian->id }}"
                                    class="block text-xs font-medium text-gray-900 uppercase tracking-wide mb-2">Harga</label>
                                <input type="text" id="harga-{{ $varian->id }}" name="harga"
                                    value="{{ $varian->harga }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Contoh: 10000" pattern="[0-9]*" inputmode="numeric"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                            </div>
                        </div>
                    </div>

                    <!-- Berat -->
                    <div
                        class="bg-white rounded-xl p-5 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100">
                        <div class="flex items-start gap-3">
                            <div
                                class="flex-shrink-0 w-10 h-10 rounded-lg bg-gradient-to-br from-teal-500 to-teal-600 flex items-center justify-center shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="text-white">
                                    <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                                    <path d="M6 12v5c3 3 9 3 12 0v-5" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <label for="berat-{{ $varian->id }}"
                                    class="block text-xs font-medium text-gray-900 uppercase tracking-wide mb-2">Berat
                                    (gram)</label>
                                <input type="text" id="berat-{{ $varian->id }}" name="berat"
                                    value="{{ $varian->berat }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Contoh: 100" pattern="[0-9]*" inputmode="numeric"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                            </div>
                        </div>
                    </div>

                    <!-- Stok -->
                    <div
                        class="bg-white rounded-xl p-5 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100">
                        <div class="flex items-start gap-3">
                            <div
                                class="flex-shrink-0 w-10 h-10 rounded-lg bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="text-white">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <label for="stok-{{ $varian->id }}"
                                    class="block text-xs font-medium text-gray-900 uppercase tracking-wide mb-2">Stok</label>
                                <input type="text" id="stok-{{ $varian->id }}" name="stok"
                                    value="{{ $varian->stok }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Contoh: 100" pattern="[0-9]*" inputmode="numeric"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                            </div>
                        </div>
                    </div>

                    <!-- Default -->
                    <div
                        class="bg-white rounded-xl p-5 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex-shrink-0 w-10 h-10 rounded-lg bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="text-white">
                                    <path
                                        d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z" />
                                    <path d="M13 5v2" />
                                    <path d="M13 17v2" />
                                    <path d="M13 11v2" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <label for="default-{{ $varian->id }}"
                                    class="block text-xs font-medium text-gray-900 uppercase tracking-wide mb-2">Atur
                                    Seagai Default</label>
                                <div class="flex items-center gap-4">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="radio" name="is_default" value="1"
                                            {{ $varian->is_default == 1 ? 'checked' : '' }}
                                            class="w-4 h-4 text-blue-600 focus:ring-2 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-700">Ya</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer">
                                        <input type="radio" name="is_default" value="0"
                                            {{ $varian->is_default == 0 ? 'checked' : '' }}
                                            class="w-4 h-4 text-blue-600 focus:ring-2 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-700">Tidak</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div
                    class="flex items-center justify-end gap-3 p-4 md:p-6 border-t border-gray-200 bg-gray-50 flex-shrink-0">
                    <button type="button" data-modal-hide="edit-varian-modal-{{ $varian->id }}"
                        class="text-gray-700 bg-white hover:bg-gray-100 border border-gray-300 font-semibold rounded-lg text-sm px-5 py-2.5 transition-all duration-200 hover:shadow-md">
                        Batal
                    </button>
                    <button type="submit"
                        class="text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 font-semibold rounded-lg text-sm px-6 py-2.5 transition-all duration-200 shadow-lg hover:shadow-xl">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewEditImageVarian{{ $varian->id }}(event) {
        const input = event.target;
        const preview = document.getElementById('edit-preview-img-varian-{{ $varian->id }}');
        const imagePreview = document.getElementById('edit-image-preview-varian-{{ $varian->id }}');
        const currentFoto = document.getElementById('current-foto-{{ $varian->id }}');
        const fileName = document.getElementById('file-name-varian-{{ $varian->id }}');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                imagePreview.classList.remove('hidden');
                if (currentFoto) {
                    currentFoto.classList.add('hidden');
                }
            }

            reader.readAsDataURL(input.files[0]);
            fileName.textContent = 'File dipilih: ' + input.files[0].name;
        } else {
            imagePreview.classList.add('hidden');
            if (currentFoto) {
                currentFoto.classList.remove('hidden');
            }
            fileName.textContent = '';
        }
    }
</script>
