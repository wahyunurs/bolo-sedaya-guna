@component('user.components.user-layout')
    @include('user.components.navbar')

    <section class="pt-16 sm:pt-20 pb-8 sm:pb-12 lg:pb-16 bg-[#e9ffe1] min-h-screen">

        <!-- Modal Flash Message -->
        @include('user.components.message-modal')

        <div class="max-w-4xl mx-auto px-4 sm:px-6">

            <!-- SINGLE CARD -->
            <div class="bg-white p-4 sm:p-6 lg:p-8 rounded-xl sm:rounded-2xl shadow mt-4 sm:mt-8">

                <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                    <a href="{{ route('user.keranjang.index') }}" aria-label="Kembali ke detail"
                        class="text-green-700 hover:text-green-900 p-1 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="sm:w-6 sm:h-6"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-arrow-left-icon lucide-arrow-left">
                            <path d="m12 19-7-7 7-7" />
                            <path d="M19 12H5" />
                        </svg>
                    </a>
                    <h2 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-green-800">Beli Sekarang</h2>
                </div>

                <form action="{{ route('user.produk.bayarSekarang') }}" method="POST" enctype="multipart/form-data"
                    id="checkoutForm">
                    @csrf

                    @php
                        $kuantitas = $kuantitas ?? 1;
                        $harga_pemesanan = $harga_pemesanan ?? ($harga_saat_pemesanan ?? $produk->harga);
                        $subtotal = $subtotal ?? $kuantitas * $harga_pemesanan;

                        $ongkir = $ongkir ?? 0;
                        $tarif_per_kg = $tarif_per_kg ?? 0;

                        $totalBeratGram = $totalBeratGram ?? ($produk->berat ?? 0) * $kuantitas;

                        $alamat_tujuan = $alamat_tujuan ?? (request('alamat') ?? (auth()->user()->alamat ?? ''));
                        $kabupaten_tujuan =
                            $kabupaten_tujuan ?? (request('kabupaten_tujuan') ?? (auth()->user()->kabupaten ?? ''));
                    @endphp

                    <!-- PRODUK RINGKASAN -->
                    <div class="mb-4 sm:mb-6 p-3 sm:p-4 border rounded-lg">
                        <div class="flex items-start sm:items-center gap-2 sm:gap-4">

                            <!-- GAMBAR PRODUK -->
                            <div
                                class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 bg-gray-50 rounded-lg overflow-hidden flex-shrink-0">
                                @php
                                    $gambar = optional($produk->gambarProduks->first())->gambar;
                                    $imgPath = $gambar
                                        ? asset('storage/img/produk/' . $gambar)
                                        : asset('img/card/produk1.png');
                                @endphp
                                <img src="{{ $imgPath }}" alt="{{ $produk->nama }}" class="w-full h-full object-cover">
                            </div>

                            <!-- INFO PRODUK -->
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm sm:text-base text-green-900 line-clamp-2">
                                    {{ $produk->nama }}</p>
                                <p class="text-xs sm:text-sm text-gray-600 mt-0.5">
                                    Rp {{ number_format($produk->harga, 0, ',', '.') }},-
                                </p>
                            </div>

                            <!-- KUANTITAS + SUBTOTAL -->
                            <div class="flex flex-col items-end gap-1.5 sm:gap-2">
                                <div class="flex items-center gap-1">
                                    <span class="text-xs sm:text-sm text-gray-700">Jumlah : </span>

                                    <button type="button" id="decreaseBtn"
                                        class="w-5 h-5 sm:w-6 sm:h-6 flex items-center justify-center bg-gray-100 rounded-sm text-green-700 hover:bg-gray-200 text-xs">-</button>

                                    <input type="text" id="kuantitasInput" value="{{ $kuantitas }}"
                                        class="w-10 sm:w-12 text-center p-0.5 border rounded-sm text-xs sm:text-sm" />

                                    <button type="button" id="increaseBtn"
                                        class="w-5 h-5 sm:w-6 sm:h-6 flex items-center justify-center bg-gray-100 rounded-sm text-green-700 hover:bg-gray-200 text-xs">+</button>
                                </div>

                                {{-- Error message shown under jumlah when stok tidak mencukupi or other modal errors --}}
                                @if (session('error'))
                                    <p id="modalErrorMessage" class="text-red-600 text-xs sm:text-sm mt-1 mb-2 sm:mb-3">
                                        {{ session('error') }}</p>
                                @endif

                                <div class="text-right">
                                    <p class="text-xs sm:text-sm text-gray-600">
                                        Subtotal: Rp <span
                                            id="produkSubtotalText">{{ number_format($subtotal, 0, ',', '.') }}</span>
                                    </p>
                                </div>
                            </div>


                        </div>

                        <!-- Hidden Data Produk -->
                        <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                        <input type="hidden" name="keranjang_id" value="{{ $keranjang_id ?? '' }}">
                        <input type="hidden" id="hiddenKuantitasInput" name="kuantitas" value="{{ $kuantitas }}">
                        <input type="hidden" id="hiddenHargaPemesananInput" name="harga_saat_pemesanan"
                            value="{{ $harga_pemesanan }}">
                        <input type="hidden" id="hiddenSubtotalInput" name="subtotal_produk" value="{{ $subtotal }}">
                        <input type="hidden" id="totalBeratGramInput" name="total_berat_gram"
                            value="{{ $totalBeratGram }}">
                        <!-- Aggregated fields required by bayarSekarang validator -->
                        <input type="hidden" id="totalJumlahInput" name="total_jumlah" value="{{ $kuantitas }}">
                        <input type="hidden" id="totalBeratInput" name="total_berat" value="{{ $totalBeratGram }}">
                        <input type="hidden" id="beratTotalInput" name="berat_total" value="{{ $totalBeratGram }}">
                    </div>

                    <!-- ALAMAT READONLY -->
                    <div class="mb-4 sm:mb-6 p-3 sm:p-4 border rounded-lg bg-gray-50 relative">

                        <button type="button"
                            onclick="(function(m){m.classList.remove('hidden');m.classList.add('flex');})(document.getElementById('modalEditAlamat'))"
                            class="absolute right-2 sm:right-3 top-2 sm:top-3 text-green-700 hover:text-green-900 text-xs sm:text-sm font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-pen-icon lucide-pen inline-block mr-1 w-3 h-3 sm:w-4 sm:h-4">
                                <path
                                    d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                            </svg>
                            Ubah Alamat
                        </button>

                        <h3 class="font-bold text-green-800 text-base sm:text-lg mb-2 pr-20 sm:pr-24">Alamat Pengiriman</h3>

                        <p class="text-sm sm:text-base text-gray-800 font-medium break-words">{{ $alamat_tujuan }}</p>
                        <p class="text-xs sm:text-sm text-gray-600 mt-1">{{ $kabupaten_tujuan }}</p>
                    </div>

                    <!-- HIDDEN ADDRESS INPUT (DIKIRIM KE SERVER) -->
                    <input type="hidden" id="hiddenAlamat" name="alamat" value="{{ old('alamat', $alamat_tujuan) }}">
                    <input type="hidden" id="hiddenKabupaten" name="kabupaten_tujuan"
                        value="{{ old('kabupaten_tujuan', $kabupaten_tujuan) }}">

                    <!-- RINGKASAN TOTAL -->
                    <div class="p-3 sm:p-4 mt-4 sm:mt-6 lg:mt-8 border rounded-lg sm:rounded-xl bg-gray-50">
                        <h3 class="font-extrabold text-base sm:text-lg text-green-800 mb-3 sm:mb-4">Ringkasan Pesanan</h3>

                        <div class="mb-2 sm:mb-3 flex justify-between text-sm sm:text-base text-gray-700">
                            <span>Subtotal produk</span>
                            <span id="subtotalText">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <div class="mb-2 sm:mb-3 space-y-1 text-gray-700">
                            <div class="flex justify-between">
                                <span class="text-xs sm:text-sm">Tarif / kg</span>
                                <span id="tarifPerKgText" class="text-xs sm:text-sm text-gray-700">Rp
                                    {{ number_format($tarif_per_kg ?? 0, 0, ',', '.') }}/kg</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-xs sm:text-sm">Total Berat</span>
                                <span id="beratTotalText"
                                    class="text-xs sm:text-sm text-gray-700">{{ number_format(($totalBeratGram ?? ($produk->berat ?? 0) * $kuantitas) / 1000, 2, ',', '.') }}
                                    kg</span>
                            </div>

                            <div class="flex justify-between font-semibold mt-1">
                                <span class="text-sm sm:text-base">Ongkir</span>
                                <span id="ongkirText" class="text-sm sm:text-base">Rp
                                    {{ number_format($ongkir, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- HIDDEN FOR JS -->
                        <input id="ongkirInput" type="hidden" name="ongkir" value="{{ $ongkir }}">
                        <input id="tarifPerKgInput" type="hidden" name="tarif_per_kg"
                            value="{{ $tarif_per_kg ?? 0 }}">
                        <input id="beratGramInput" type="hidden" name="berat_gram" value="{{ $produk->berat ?? 0 }}">
                        <input id="totalBayarHidden" type="hidden" name="total_bayar"
                            value="{{ $subtotal + $ongkir }}">

                        <div class="pt-2 sm:pt-3 border-t mt-2 sm:mt-3">
                            <div class="flex justify-between items-center">
                                <span class="font-extrabold text-sm sm:text-base text-gray-800">Total Bayar</span>
                                <span id="totalBayarText"
                                    class="font-extrabold text-base sm:text-lg lg:text-xl text-green-700">
                                    Rp {{ number_format($subtotal + $ongkir, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- DAFTAR REKENING -->
                    <div class="mt-4 sm:mt-6 mb-3 sm:mb-4 p-3 sm:p-4 border rounded-lg sm:rounded-xl bg-white">
                        <h3 class="font-extrabold text-base sm:text-lg text-green-800 mb-2 sm:mb-3">Rekening Pembayaran
                        </h3>
                        <div class="grid grid-cols-1 gap-2 sm:gap-3">
                            @forelse ($rekening as $rek)
                                <div class="border rounded-lg p-2.5 sm:p-3 bg-gray-50">
                                    <p class="font-semibold text-sm sm:text-base text-green-900">{{ $rek->nama_bank }}</p>
                                    <p class="text-xs sm:text-sm text-gray-800">No. Rekening: {{ $rek->nomor_rekening }}
                                    </p>
                                    <p class="text-xs sm:text-sm text-gray-600">a.n. {{ $rek->atas_nama }}</p>
                                </div>
                            @empty
                                <p class="text-xs sm:text-sm text-gray-600">Tidak ada rekening yang tersedia.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- INPUT BUKTI PEMBAYARAN -->
                    <div class="mt-4 sm:mt-6 mb-3 sm:mb-4">
                        <label class="font-semibold text-sm sm:text-base text-gray-700">Upload Bukti Pembayaran</label>
                        <input type="file" name="bukti_pembayaran"
                            class="w-full mt-1 p-2 sm:p-3 border rounded-lg bg-white text-sm sm:text-base"
                            accept="image/*" required>
                    </div>

                    <!-- CATATAN -->
                    <div class="mb-4">
                        <label class="block font-semibold text-sm sm:text-base text-gray-700">Catatan Pesanan</label>
                        <textarea name="catatan" rows="3" class="w-full mt-1 p-2 sm:p-3 border rounded-lg text-sm sm:text-base"
                            placeholder="Masukkan catatan tambahan untuk pesanan">{{ old('catatan') }}</textarea>
                    </div>

                    <div class="flex justify-end mt-6 sm:mt-8">
                        <button type="submit"
                            class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 sm:py-3 rounded-lg sm:rounded-xl font-semibold text-sm sm:text-base">
                            Bayar Sekarang
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </section>

    <!-- Edit Alamat Modal -->
    @include('user.produk.edit-alamat')

    <!-- Checkout JS -->
    @vite('resources/js/user/produk/checkout.js')
@endcomponent
