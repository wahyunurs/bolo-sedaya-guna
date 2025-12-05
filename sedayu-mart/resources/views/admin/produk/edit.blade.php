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
                            <li><a href="{{ route('admin.produk.index') }}" class="text-green-600 font-semibold">Produk</a></li>
                            <li><span class="text-green-400">></span></li>
                            <li class="text-green-700">Ubah</li>
                        </ol>
                        <h1 class="text-3xl font-bold text-gray-800 mt-2">Ubah Produk</h1>
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

                        <!-- Harga -->
                        <div>
                            <label for="harga" class="block text-sm font-medium text-gray-700">Harga</label>
                            <input type="number" name="harga" id="harga" required
                                value="{{ old('harga', $produk->harga ?? '') }}"
                                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Masukkan harga (tanpa pemisah)">
                        </div>

                        <!-- Berat -->
                        <div>
                            <label for="berat" class="block text-sm font-medium text-gray-700">Berat (gram)</label>
                            <input type="number" name="berat" id="berat" required
                                value="{{ old('berat', $produk->berat ?? '') }}"
                                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Berat dalam gram">
                        </div>

                        <!-- Stok -->
                        <div>
                            <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                            <input type="number" name="stok" id="stok" required
                                value="{{ old('stok', $produk->stok ?? 0) }}"
                                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Jumlah stok">
                        </div>

                        <!-- Satuan -->
                        <div>
                            <label for="satuan_produk" class="block text-sm font-medium text-gray-700">Satuan</label>
                            <input type="text" name="satuan_produk" id="satuan_produk" required
                                value="{{ old('satuan_produk', $produk->satuan_produk ?? '') }}"
                                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Contoh: Kg, Liter, Pcs">
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

                            @php
                                $existing = isset($produk) ? $produk->gambarProduks->values() : collect();
                            @endphp
                            <div class="grid grid-cols-5 gap-3 mt-3">
                                @for ($i = 0; $i < 5; $i++)
                                    @php
                                        $slot = $existing->get($i);
                                        $slotId = $slot ? $slot->id : null;
                                        $slotUrl =
                                            $slot && $slot->gambar
                                                ? asset('storage/img/produk/' . $slot->gambar)
                                                : asset('img/card/produk1.png');
                                        $slotUtama = $slot && $slot->utama;
                                    @endphp
                                    <div class="border rounded p-2 text-center slot-item"
                                        data-slot="{{ $i }}">
                                        <div
                                            class="w-full h-24 bg-gray-100 rounded mb-2 overflow-hidden flex items-center justify-center">
                                            <img id="preview-{{ $i }}"
                                                src="{{ old('slot_preview_' . $i, $slotUrl) }}" alt="preview"
                                                class="object-cover w-full h-full">
                                        </div>

                                        <input type="file" name="gambar[]" accept="image/*"
                                            data-index="{{ $i }}" class="gambar-input text-sm w-full" />

                                        {{-- hidden mapping to existing image id for this slot --}}
                                        <input type="hidden" name="slot_existing_id[{{ $i }}]"
                                            id="slot_existing_id_{{ $i }}" value="{{ $slotId ?? '' }}">

                                        {{-- hidden delete flag for this slot --}}
                                        <input type="hidden" name="delete_slot[{{ $i }}]"
                                            id="delete_slot_{{ $i }}" value="0">

                                        <div class="text-sm mt-2 flex items-center justify-center space-x-2">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="utama_gambar"
                                                    value="{{ $slotId ? 'existing_' . $slotId : 'new_' . $i }}"
                                                    class="mr-2"
                                                    {{ (old('utama_gambar') ? old('utama_gambar') == ($slotId ? 'existing_' . $slotId : 'new_' . $i) : ($slotUtama ? true : $i == 0 && !$existing->count())) ? 'checked' : '' }}>
                                                Utama
                                            </label>

                                            <button type="button"
                                                class="hapus-slot text-red-500 {{ $slotId ? '' : 'hidden' }}"
                                                data-slot="{{ $i }}"
                                                aria-label="Hapus slot {{ $i }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2">
                                                    <line x1="18" y1="6" x2="6"
                                                        y2="18" />
                                                    <line x1="6" y1="6" x2="18"
                                                        y2="18" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        {{-- existing images are shown inside the 5 slots above; no separate block needed --}}

                        <!-- Tombol Submit -->
                        <div class="flex justify-end space-x-4">
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

<!-- Edit Produk JavaScript -->
{{-- @vite('resources/js/admin/produk/edit.js') --}}

<script>
    // Preview selected images for the 5 upload boxes
    (function() {
        function onFileChange(e) {
            const input = e.currentTarget;
            const idx = input.dataset.index;
            const preview = document.getElementById('preview-' + idx);
            if (!preview) return;
            const file = input.files && input.files[0];
            if (file) {
                preview.src = URL.createObjectURL(file);
            } else {
                // reset to placeholder
                preview.src = '{{ asset('img/card/produk1.png') }}';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // wire change handlers for file inputs
            document.querySelectorAll('.gambar-input').forEach(function(inp) {
                inp.addEventListener('change', function(e) {
                    onFileChange(e);

                    // show/hide delete button depending on whether a file is selected
                    const idx = e.currentTarget.dataset.index;
                    const btn = document.querySelector('.hapus-slot[data-slot="' + idx +
                        '"]');
                    if (btn) {
                        const file = e.currentTarget.files && e.currentTarget.files[0];
                        if (file) {
                            btn.classList.remove('hidden');
                        } else {
                            // if there is still an existing id input, keep button visible, otherwise hide
                            const exist = document.getElementById('slot_existing_id_' +
                            idx);
                            if (!exist || !exist.value) btn.classList.add('hidden');
                        }
                    }
                });
            });

            // initialize delete button visibility for each slot
            document.querySelectorAll('.slot-item').forEach(function(slotDiv) {
                const idx = slotDiv.dataset.slot;
                const exist = document.getElementById('slot_existing_id_' + idx);
                const btn = slotDiv.querySelector('.hapus-slot');
                if (btn) {
                    if (exist && exist.value) {
                        btn.classList.remove('hidden');
                    } else {
                        btn.classList.add('hidden');
                    }
                }
            });

            // handle delete slot clicks
            document.querySelectorAll('.hapus-slot').forEach(function(btn) {
                btn.addEventListener('click', function(ev) {
                    const slot = btn.dataset.slot;
                    // mark delete flag for slot
                    const del = document.getElementById('delete_slot_' + slot);
                    if (del) del.value = '1';
                    // read existing id, then remove existing id mapping so it's not submitted
                    const exist = document.getElementById('slot_existing_id_' + slot);
                    const existingId = exist ? exist.value : '';
                    if (exist) exist.remove();
                    // hide this delete button
                    btn.classList.add('hidden');
                    // also clear file input for this slot if any
                    const fileInput = document.querySelector(
                        'input.gambar-input[data-index="' + slot + '"]');
                    if (fileInput) {
                        fileInput.value = '';
                    }
                    // reset preview to placeholder
                    const preview = document.getElementById('preview-' + slot);
                    if (preview) preview.src = '{{ asset('img/card/produk1.png') }}';
                    // if utama radio pointed to this existing, clear it and set to 'new_{i}'
                    const radio = document.querySelector(
                        'input[name="utama_gambar"][value="existing_' + existingId +
                        '"]');
                    if (radio) {
                        if (radio.checked) radio.checked = false;
                        // change its value so it does not reference the removed existing id
                        radio.value = 'new_' + slot;
                    }
                });
            });
        });
    })();
</script>
