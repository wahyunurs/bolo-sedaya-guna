<!-- MODAL EDIT ALAMAT -->
<div id="modalEditAlamat"
    class="fixed inset-0 bg-black bg-opacity-50 {{ session('error') ? 'flex' : 'hidden' }} justify-center items-center z-[999]">

    <div class="bg-white w-[90%] max-w-md p-8 rounded-2xl shadow-xl relative">

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
        <h2 class="text-xl font-bold text-green-800 mb-4">Ubah Alamat</h2>

        <!-- Divider under header (full width across modal content) -->
        <div class="-mx-8 h-px bg-gray-200 mb-6"></div>

        <form method="GET" action="{{ route('user.produk.checkout') }}">
            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
            <input type="hidden" name="kuantitas" value="{{ $kuantitas ?? 1 }}">
            <input type="hidden" name="harga_saat_pemesanan" value="{{ $harga_pemesanan ?? $produk->harga }}">

            <div class="mb-3">
                <label class="block text-sm font-semibold">Alamat Lengkap</label>
                <textarea id="alamatTextarea" name="alamat" rows="3" class="w-full mt-1 p-2 border rounded">{{ old('alamat', $alamat_tujuan) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-semibold">Kabupaten / Kota</label>

                @php
                    $list = isset($semua_kabupaten) ? $semua_kabupaten : (isset($kabupatens) ? $kabupatens : collect());
                    $selected = old('kabupaten_tujuan', $kabupaten_tujuan);
                @endphp

                <div class="relative mt-2">
                    <!-- actual value to submit -->
                    <input id="kabupatenTujuanHidden" type="hidden" name="kabupaten_tujuan"
                        value="{{ $selected ?? '' }}">

                    <!-- Searchable input (first control) -->
                    <input id="kabupatenTujuanSearch" type="text" autocomplete="off"
                        class="block w-full pl-9 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm bg-white"
                        placeholder="Pilih Kabupaten/Kota" value="{{ $selected ?? '' }}">

                    <!-- dropdown list -->
                    <ul id="kabupatenTujuanList"
                        class="absolute left-0 right-0 mt-1 max-h-44 overflow-auto border border-gray-200 rounded-md shadow-sm bg-white z-50 hidden">
                        <li class="px-3 py-2 text-sm text-gray-500">Ketik untuk mencari atau pilih dari daftar</li>

                        @foreach ($list as $item)
                            @php
                                $label = is_object($item) ? $item->kabupaten ?? (string) $item : (string) $item;
                                $isSelected = $label === $selected;
                            @endphp
                            <li data-value="{{ $label }}"
                                class="px-3 py-2 text-sm text-black hover:bg-green-500 hover:text-white cursor-pointer {{ $isSelected ? 'bg-green-50 font-semibold' : '' }}">
                                {{ $label }}
                            </li>
                        @endforeach

                        @if (count($list) === 0)
                            <li class="px-3 py-2 text-sm text-gray-500">Tidak ada data</li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end gap-4">
                <button type="submit"
                    class="px-5 py-2 rounded-lg bg-[#ffd000] hover:bg-[#dab200] text-white font-semibold">
                    Ubah Alamat
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Alamat JavaScript -->
@vite('resources/js/user/produk/edit-alamat.js')
