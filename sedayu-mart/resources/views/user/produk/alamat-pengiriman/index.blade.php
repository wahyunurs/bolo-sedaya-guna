@component('user.components.user-layout')
    @include('user.components.navbar')

    <section class="pt-16 sm:pt-20 pb-8 sm:pb-12 bg-[#e9ffe1] min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6">

            <!-- HEADER -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-green-800">Alamat Pengiriman</h1>
                <a href="{{ route('user.produk.alamatPengiriman.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold shadow">
                    + Tambah Alamat
                </a>
            </div>

            @php
                $alamatUtama = $alamatPengirimans->where('utama', 1)->first() ?? $alamatPengirimans->first();
            @endphp

            {{-- 🔥 FORM HARUS GET --}}
            <form method="GET" action="{{ route('user.produk.checkout') }}" id="formPilihAlamat">

                {{-- DATA CHECKOUT --}}
                <input type="hidden" name="produk_id" value="{{ request('produk_id') }}">
                <input type="hidden" name="varian_id" value="{{ request('varian_id') }}">
                <input type="hidden" name="kuantitas" value="{{ request('kuantitas') }}">

                {{-- DATA ALAMAT --}}
                <input type="hidden" name="alamat" id="alamatHidden">
                <input type="hidden" name="kabupaten_tujuan" id="kabupatenHidden">
                <input type="hidden" name="nama_penerima" id="namaPenerimaHidden">
                <input type="hidden" name="nomor_telepon" id="nomorTeleponHidden">
                <input type="hidden" name="provinsi" id="provinsiHidden">
                <input type="hidden" name="kode_pos" id="kodePosHidden">
                <input type="hidden" name="keterangan" id="keteranganHidden">
                <input type="hidden" name="utama" id="utamaHidden">

                <div class="space-y-4">
                    @forelse ($alamatPengirimans as $alamat)
                        <div class="flex gap-4 p-5 bg-white rounded-xl shadow hover:ring-2 hover:ring-green-200">

                            <input type="radio" name="alamat_id" class="mt-1 accent-green-600"
                                {{ $alamatUtama && $alamatUtama->id === $alamat->id ? 'checked' : '' }}
                                data-alamat="{{ $alamat->alamat }}" data-kabupaten="{{ $alamat->kabupaten }}"
                                data-nama_penerima="{{ $alamat->nama_penerima }}"
                                data-nomor_telepon="{{ $alamat->nomor_telepon }}" data-provinsi="{{ $alamat->provinsi }}"
                                data-kode_pos="{{ $alamat->kode_pos }}" data-keterangan="{{ $alamat->keterangan }}"
                                data-utama="{{ $alamat->utama }}" required>

                            <div class="flex-1">
                                <div class="font-bold text-gray-900 flex gap-2">
                                    {{ $alamat->nama_penerima }}
                                    @if ($alamat->utama)
                                        <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded">
                                            Utama
                                        </span>
                                    @endif
                                </div>

                                <div class="text-sm text-gray-700 mt-1">
                                    {{ $alamat->alamat }}
                                </div>

                                <div class="text-sm text-gray-500 mt-1">
                                    {{ $alamat->kabupaten }}, {{ $alamat->provinsi }} {{ $alamat->kode_pos }}
                                </div>

                                <div class="text-sm text-gray-500">
                                    Telp: {{ $alamat->nomor_telepon }}
                                </div>

                                @if ($alamat->keterangan)
                                    <div class="text-xs text-gray-400 italic">
                                        {{ $alamat->keterangan }}
                                    </div>
                                @endif
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('user.produk.alamatPengiriman.edit', $alamat->id) }}"
                                    class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-100 hover:bg-green-100 text-green-700">
                                    ✏️
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white p-6 rounded-xl text-center text-gray-500">
                            Belum ada alamat pengiriman
                        </div>
                    @endforelse
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-xl font-semibold">
                        Pilih Alamat Ini
                    </button>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const radios = document.querySelectorAll('input[name="alamat_id"]');

            function syncHidden(radio) {
                alamatHidden.value = radio.dataset.alamat || '';
                kabupatenHidden.value = radio.dataset.kabupaten || '';
                namaPenerimaHidden.value = radio.dataset.nama_penerima || '';
                nomorTeleponHidden.value = radio.dataset.nomor_telepon || '';
                provinsiHidden.value = radio.dataset.provinsi || '';
                kodePosHidden.value = radio.dataset.kode_pos || '';
                keteranganHidden.value = radio.dataset.keterangan || '';
                utamaHidden.value = radio.dataset.utama || '';
            }

            radios.forEach(radio => {
                radio.addEventListener('change', () => syncHidden(radio));
                if (radio.checked) syncHidden(radio);
            });
        });
    </script>
@endcomponent
