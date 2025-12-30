<x-app-layout>

    <!-- Sidebar toggle controller (peer) -->
    <input id="menu-toggle" type="checkbox" class="peer sr-only" />

    <!-- Sidebar Admin -->
    @include('admin.components.sidebar')

    <!-- Navbar Admin -->
    @include('admin.components.navbar')

    <!-- Main Content -->
    <main class="ml-0 md:ml-64 peer-checked:md:ml-0 mt-16 transition-all duration-300">
        <section class="py-16 bg-[#f0ffeb] min-h-screen">
            <!-- Flash Message -->
            @include('admin.components.message-modal')

            <div class="max-w-5xl mx-auto px-6">
                <!-- Heading dan Breadcrumb -->
                <div class="mb-6">
                    <nav class="text-sm text-gray-500">
                        <ol class="list-reset flex items-center space-x-2">
                            <li><a href="{{ route('admin.dashboard') }}" class="hover:underline text-green-600">Admin</a>
                            </li>
                            <li><span class="text-green-400">></span></li>
                            <li><a href="{{ route('admin.produk.index') }}"
                                    class="text-green-600 font-semibold">Produk</a></li>
                            <li><span class="text-green-400">></span></li>
                            <li class="text-green-700">Buat</li>
                        </ol>
                        <h1 class="text-3xl font-bold text-gray-800 mt-2">Buat Produk</h1>
                    </nav>
                </div>

                <!-- Form Tambah / Edit Produk -->
                <div class="p-6 rounded-lg bg-white shadow-lg border border-gray-200">
                    @if (isset($produk))
                        <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST"
                            enctype="multipart/form-data" class="space-y-6">
                            @method('PUT')
                        @else
                            <form action="{{ route('admin.produk.store') }}" method="POST"
                                enctype="multipart/form-data" class="space-y-6">
                    @endif
                    @csrf

                    <!-- Nama -->
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                        <input type="text" name="nama" id="nama" required
                            value="{{ old('nama', $produk->nama ?? '') }}"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Masukkan nama produk">
                    </div>

                    <!-- Satuan -->
                    <div>
                        <label for="satuan_produk" class="block text-sm font-medium text-gray-700">Satuan</label>
                        <select name="satuan_produk" id="satuan_produk" required
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @php
                                $satuanOptions = ['Pcs', 'Kg', 'Gram', 'Liter', 'Ml'];
                                $selectedSatuan = old('satuan_produk', $produk->satuan_produk ?? '');
                            @endphp
                            <option value="" disabled {{ $selectedSatuan == '' ? 'selected' : '' }}>Pilih satuan
                            </option>
                            @foreach ($satuanOptions as $opt)
                                <option value="{{ $opt }}" {{ $selectedSatuan == $opt ? 'selected' : '' }}>
                                    {{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Deskripsi produk">{{ old('deskripsi', $produk->deskripsi ?? '') }}</textarea>
                    </div>

                    <!-- Gambar Produk (maks 5) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gambar Produk (maks 5)</label>
                        <p class="text-sm italic text-gray-500 mt-1">Unggah maksimal 5 gambar. Pilih salah satu
                            sebagai gambar utama.</p>

                        <div class="grid grid-cols-5 gap-3 mt-3">
                            @for ($i = 0; $i < 5; $i++)
                                <div class="border rounded p-2 text-center">
                                    <div
                                        class="w-full h-24 bg-gray-100 rounded mb-2 overflow-hidden flex items-center justify-center">
                                        <img id="preview-{{ $i }}" src="" alt="preview"
                                            class="object-cover w-full h-full hidden">
                                        <div id="placeholder-{{ $i }}"
                                            class="flex items-center justify-center w-full h-full text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-upload">
                                                <path d="M12 3v12" />
                                                <path d="m17 8-5-5-5 5" />
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                            </svg>
                                        </div>
                                    </div>

                                    <input type="file" name="gambar[]" accept="image/*"
                                        data-index="{{ $i }}" class="gambar-input text-sm w-full" />

                                    <div class="text-sm mt-2">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="utama_gambar" value="new_{{ $i }}"
                                                class="mr-2" {{ $i === 0 ? 'checked' : '' }}>
                                            Utama
                                        </label>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    @if (isset($produk) && $produk->gambarProduks->count())
                        <div>
                            <p class="text-sm font-medium text-gray-700">Gambar Saat Ini</p>
                            <div class="grid grid-cols-3 gap-3 mt-3">
                                @foreach ($produk->gambarProduks as $gambar)
                                    <div class="border rounded p-2 text-center">
                                        @php $img = $gambar->gambar; @endphp
                                        <img src="{{ $img ? asset('storage/img/produk/' . $img) : asset('img/card/produk1.png') }}"
                                            class="mx-auto mb-2 h-24 w-24 object-cover rounded" />
                                        <div class="text-sm">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="utama_gambar" value="{{ $gambar->id }}"
                                                    {{ $gambar->utama ? 'checked' : '' }} class="mr-2">
                                                Utama
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Varian Produk (dinamis) -->
                    <div id="varian-section">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Varian Produk</label>
                        <!-- varian error removed -->
                        <div id="varian-list">
                            <!-- Varian form items will be inserted here by JS -->
                        </div>
                        <button type="button" id="add-varian-btn"
                            class="mt-2 px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-sm">+ Tambah
                            Varian</button>
                        <p class="text-xs text-gray-500 mt-1">Setiap produk harus memiliki minimal 1 varian.</p>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="flex justify-end space-x-4 mt-6">
                        <a href="{{ route('admin.produk.index') }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200">Batal</a>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition duration-200">{{ isset($produk) ? 'Perbarui' : 'Simpan' }}</button>
                    </div>

                    </form>
                </div>
            </div>
            </div>
        </section>
    </main>
</x-app-layout>

<!-- Create Produk JavaScript -->
@vite('resources/js/admin/produk/create.js')
<script>
    // Dynamic varian form logic
    document.addEventListener('DOMContentLoaded', function() {
        const varianList = document.getElementById('varian-list');
        const addBtn = document.getElementById('add-varian-btn');

        // Template for a varian form group
        function varianForm(idx, data = {}) {
            // First varian: checked by default if not set
            const checked = (typeof data.is_default !== 'undefined') ? data.is_default : (idx === 0);
            return `
                <div class="varian-item border rounded p-3 mb-3 relative bg-gray-50" data-index="${idx}">
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-2">
                        <div>
                            <label class="block text-xs font-medium text-gray-600">Nama Varian</label>
                            <input type="text" name="varian[${idx}][nama]" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm" placeholder="Contoh: Original" value="${data.nama || ''}">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600">Harga</label>
                            <input type="number" name="varian[${idx}][harga]" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm" placeholder="Harga" value="${data.harga || ''}">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600">Berat (gram)</label>
                            <input type="number" name="varian[${idx}][berat]" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm" placeholder="Berat" value="${data.berat || ''}">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600">Stok</label>
                            <input type="number" name="varian[${idx}][stok]" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-sm" placeholder="Stok" value="${data.stok || ''}">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600">Gambar Varian</label>
                            <input type="file" name="varian_gambar[${idx}]" accept="image/*" class="mt-1 block w-full text-sm border border-gray-300 rounded-md">
                        </div>
                        <div class="flex flex-col items-center justify-center">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Default?</label>
                            <input type="hidden" name="varian[${idx}][is_default]" value="0">
                            <input type="checkbox" class="is-default-checkbox" name="varian[${idx}][is_default]" value="1" ${checked ? 'checked' : ''}>
                            <button type="button" class="remove-varian-btn mt-2 px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs" title="Hapus Varian">-</button>
                        </div>
                    </div>
                </div>
            `;
        }

        // State: list of varian data
        let varianData = [];

        // Helper: get all current input values from DOM, and preserve file input nodes
        function collectVarianInputs() {
            const items = document.querySelectorAll('.varian-item');
            let arr = [];
            let fileInputs = [];
            items.forEach((item, idx) => {
                arr.push({
                    nama: item.querySelector(`[name="varian[${idx}][nama]"]`)?.value || '',
                    harga: item.querySelector(`[name="varian[${idx}][harga]"]`)?.value || '',
                    berat: item.querySelector(`[name="varian[${idx}][berat]"]`)?.value || '',
                    stok: item.querySelector(`[name="varian[${idx}][stok]"]`)?.value || '',
                    is_default: item.querySelector(`[name="varian[${idx}][is_default]"]`)
                        ?.checked || false
                });
                // Save file input node for this varian
                const fileInput = item.querySelector(
                    `[name="varian_gambar[${idx}]"], [name='varian_gambar[${idx}]']`);
                fileInputs.push(fileInput ? fileInput : null);
            });
            return {
                arr,
                fileInputs
            };
        }

        // Add a new varian form, preserving current input values and file inputs
        function addVarian(data = {}) {
            const {
                arr,
                fileInputs
            } = collectVarianInputs();
            varianData = arr;
            varianFileInputs = fileInputs;
            varianData.push(data);
            varianFileInputs.push(null); // new varian, no file input yet
            renderVarian();
        }

        // Remove a varian form by index, preserving current input values and file inputs
        function removeVarian(idx) {
            const {
                arr,
                fileInputs
            } = collectVarianInputs();
            varianData = arr;
            varianFileInputs = fileInputs;
            if (varianData.length <= 1) return; // minimal 1 varian
            varianData.splice(idx, 1);
            varianFileInputs.splice(idx, 1);
            renderVarian();
        }

        // Render all varian forms, reattaching file input nodes
        let varianFileInputs = [];

        function renderVarian() {
            varianList.innerHTML = '';
            varianData.forEach((data, idx) => {
                // Insert HTML for varian
                varianList.insertAdjacentHTML('beforeend', varianForm(idx, data));
            });
            // Reattach file input nodes
            varianData.forEach((data, idx) => {
                if (varianFileInputs[idx]) {
                    const wrapper = varianList.querySelector(
                        `.varian-item[data-index='${idx}'] [name="varian_gambar[${idx}]"], .varian-item[data-index='${idx}'] [name='varian_gambar[${idx}]']`
                    );
                    if (wrapper && wrapper.parentNode) {
                        wrapper.parentNode.replaceChild(varianFileInputs[idx], wrapper);
                    }
                }
            });
            // Attach remove event
            document.querySelectorAll('.remove-varian-btn').forEach((btn, i) => {
                btn.onclick = function() {
                    removeVarian(i);
                };
            });
            // Attach single-check logic for is_default checkboxes
            varianList.querySelectorAll('.is-default-checkbox').forEach((cb, i, arr) => {
                cb.onchange = function() {
                    if (cb.checked) {
                        arr.forEach((other, j) => {
                            if (other !== cb) other.checked = false;
                        });
                    }
                };
            });
        }

        // Initial: at least 1 varian
        if (varianData.length === 0) {
            addVarian();
        }

        addBtn.onclick = function(e) {
            e.stopPropagation();
            addVarian();
        };

        // varian error validation removed
    });
</script>
