<!-- Show Produk Modal -->
<div id="show-produk-modal-{{ $produk->id }}" tabindex="-1" aria-hidden="true"
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
                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-blue-100 uppercase tracking-wider mb-1">Detail Produk
                            </p>
                            <h3 class="text-xl md:text-2xl font-bold text-white leading-tight">Informasi produk</h3>
                        </div>
                    </div>
                    <button type="button"
                        class="flex-shrink-0 text-white/90 bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-lg text-sm w-10 h-10 inline-flex justify-center items-center transition-all duration-200 hover:scale-110"
                        data-modal-hide="show-produk-modal-{{ $produk->id }}">
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
            <div class="flex-1 overflow-y-auto p-4 md:p-6 space-y-4">
                <!-- Produk Info -->
                <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                    <div class="flex gap-4 items-center">
                        @php
                            $defaultVarian = null;
                            $defaultVarianImg = null;
                            if (isset($varians) && count($varians) > 0) {
                                foreach ($varians as $v) {
                                    if (isset($v->is_default) && $v->is_default) {
                                        $defaultVarian = $v;
                                        break;
                                    }
                                }
                                if (!$defaultVarian) {
                                    $defaultVarian = $varians[0];
                                }
                                if ($defaultVarian && !empty($defaultVarian->gambar)) {
                                    $defaultVarianImg = asset('storage/img/varian/' . $defaultVarian->gambar);
                                }
                            }
                            $produkImg = isset($produk->gambarProduks[0])
                                ? asset('storage/img/produk/' . $produk->gambarProduks[0]->gambar)
                                : asset('img/card/produk1.png');
                        @endphp
                        <img id="modalProductImg" src="{{ $defaultVarianImg ?? $produkImg }}"
                            data-default="{{ $produkImg }}" class="w-20 h-20 rounded-xl object-cover border"
                            alt="{{ $produk->nama ?? 'Produk' }}">

                        <div class="flex-1">
                            <label class="text-xs uppercase text-gray-500 font-medium">Nama Produk</label>
                            <p id="modalProductName" class="font-semibold text-gray-900 text-base leading-tight">
                                {{ $produk->nama ?? '' }}
                            </p>
                            @php
                                $defaultVarian = null;
                                if (isset($varians) && count($varians) > 0) {
                                    foreach ($varians as $v) {
                                        if (isset($v->is_default) && $v->is_default) {
                                            $defaultVarian = $v;
                                            break;
                                        }
                                    }
                                    if (!$defaultVarian) {
                                        $defaultVarian = $varians[0];
                                    }
                                }
                            @endphp
                            @if ($defaultVarian)
                                <div id="modalVarianInfo" class="mt-2">
                                    <div class="text-xs text-gray-500">Varian: <span
                                            id="varianNama">{{ $defaultVarian->nama }}</span></div>
                                    <div class="text-xs text-gray-500">Harga: <span id="varianHarga">Rp
                                            {{ number_format($defaultVarian->harga, 0, ',', '.') }}</span></div>
                                    <div class="text-xs text-gray-500">Stok: <span
                                            id="varianStok">{{ $defaultVarian->stok }}</span></div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if (isset($varians) && count($varians) > 0)
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // Data varian ke JS
                            var varianData = @json(collect($varians)->mapWithKeys(fn($v) => [$v->id => ['nama' => $v->nama, 'harga' => $v->harga, 'stok' => $v->stok]]));
                            var radios = document.querySelectorAll('input[name="varian_id"]');
                            var namaEl = document.getElementById('varianNama');
                            var hargaEl = document.getElementById('varianHarga');
                            var stokEl = document.getElementById('varianStok');
                            radios.forEach(function(radio) {
                                radio.addEventListener('change', function() {
                                    var id = this.value;
                                    if (varianData[id]) {
                                        namaEl.textContent = varianData[id].nama;
                                        hargaEl.textContent = 'Rp ' + Number(varianData[id].harga).toLocaleString(
                                            'id-ID');
                                        stokEl.textContent = varianData[id].stok;
                                    }
                                });
                            });
                        });
                    </script>
                @endif

                <!-- Jumlah -->
                <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm space-y-2">
                    <label class="text-sm font-semibold text-gray-700">Jumlah</label>
                    <div class="flex items-center gap-2">
                        <button id="modalDecrease"
                            class="w-10 h-10 rounded-lg bg-gray-100 hover:bg-gray-200 font-bold">−</button>

                        <input id="modalJumlahInput" type="text" value="1"
                            class="w-24 text-center border rounded-lg py-2 focus:ring-2 focus:ring-green-500">

                        <button id="modalIncrease"
                            class="w-10 h-10 rounded-lg bg-gray-100 hover:bg-gray-200 font-bold">+</button>
                    </div>
                </div>

                <!-- Varian -->
                @if (isset($varians) && count($varians) > 0)
                    <div class="mb-8">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Varian Produk</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @php
                                $defaultVarianId = null;
                                foreach ($varians as $v) {
                                    if (isset($v->is_default) && $v->is_default) {
                                        $defaultVarianId = $v->id;
                                        break;
                                    }
                                }
                            @endphp
                            @forelse ($varians as $varian)
                                <label for="varian-radio-{{ $produk->id }}-{{ $varian->id }}"
                                    class="group bg-white rounded-2xl border border-gray-100 shadow-lg hover:shadow-xl transition-all duration-300 p-4 flex gap-4 cursor-pointer relative varian-card-label">
                                    <input type="radio" name="varian_id"
                                        id="varian-radio-{{ $produk->id }}-{{ $varian->id }}"
                                        value="{{ $varian->id }}" class="sr-only varian-radio"
                                        @if ($defaultVarianId == $varian->id) checked @endif>
                                    <span class="absolute top-2 right-2 hidden group-[.varian-selected]:block">
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                    <!-- Gambar -->
                                    <div class="flex-shrink-0">
                                        @if ($varian->gambar)
                                            <img src="{{ asset('storage/img/varian/' . $varian->gambar) }}"
                                                class="w-16 h-16 rounded-xl object-cover border shadow">
                                        @else
                                            <div
                                                class="w-16 h-16 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <rect x="3" y="3" width="18" height="18" rx="2" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <!-- Info -->
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <p class="font-bold text-gray-900 truncate">{{ $varian->nama }}</p>
                                        </div>
                                        <div class="text-sm text-gray-600 space-y-0.5">
                                            <p class="font-semibold text-green-700">Rp
                                                {{ number_format($varian->harga, 0, ',', '.') }}</p>
                                            <p>Stok: <span class="font-semibold">{{ $varian->stok }}</span></p>
                                        </div>
                                    </div>
                                </label>
                            @empty
                                <div
                                    class="col-span-2 text-center py-10 bg-white rounded-2xl border border-gray-100 shadow">
                                    <p class="text-gray-500 italic">Tidak ada varian tersedia.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <style>
                        /* Card border highlight for selected varian */
                        .varian-card-label {
                            border-width: 2px;
                            border-color: #f3f4f6;
                        }

                        .varian-radio:checked+.varian-card-label,
                        .varian-card-label:has(.varian-radio:checked) {
                            border-color: #22c55e !important;
                            box-shadow: 0 0 0 2px #22c55e33;
                        }
                    </style>
                @endif

                <!-- Subtotal -->
                <div
                    class="flex justify-between items-center bg-green-50 border border-green-100 rounded-xl p-4 font-semibold text-green-800">
                    <span>Subtotal</span>
                    <span id="modalSubtotalText">
                        Rp {{ number_format($produk->harga ?? 0, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <!-- ================= FOOTER ================= -->
            <div class="p-4 border-t bg-gray-50 flex flex-col sm:flex-row gap-3">

                <!-- Tambah Keranjang -->
                <form id="formTambahKeranjang" method="POST" action="{{ route('user.produk.tambahKeranjang') }}"
                    class="flex-1">
                    @csrf
                    <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                    <input type="hidden" name="jumlah" id="formTambahJumlah" value="1">
                    <input type="hidden" name="varian_id" id="formTambahVarianId">
                    <button
                        class="w-full py-2.5 rounded-lg bg-orange-500 hover:bg-orange-600 text-white font-semibold flex items-center justify-center gap-2">
                        🛒 Tambah Keranjang
                    </button>
                </form>

                <!-- Beli Sekarang -->
                <form method="POST" action="{{ route('user.produk.beliSekarang') }}" class="flex-1"
                    id="formBeliSekarang">
                    @csrf
                    <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                    <input type="hidden" name="varian_id" id="formBeliVarianId">
                    <input type="hidden" name="subtotal" id="formBeliSubtotal" value="">
                    <input type="text" name="jumlah" id="formBeliJumlah" value="1" style="display:none;">
                    <button
                        class="w-full py-2.5 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold flex items-center justify-center gap-2">
                        💳 Beli Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var minusBtn = document.getElementById('modalDecrease');
        var plusBtn = document.getElementById('modalIncrease');
        var jumlahInput = document.getElementById('modalJumlahInput');
        var radios = document.querySelectorAll('input[name="varian_id"]');
        var subtotalEl = document.getElementById('modalSubtotalText');
        var imgEl = document.getElementById('modalProductImg');
        var produkDefaultImg = imgEl ? imgEl.getAttribute('data-default') || imgEl.src : '';
        var varianData = {};
        // Ambil data varian dari window atau inisialisasi ulang jika sudah ada
        if (typeof window.varianDataModal === 'object') {
            varianData = window.varianDataModal;
        } else if (typeof varianData !== 'undefined' && Object.keys(varianData).length > 0) {
            // sudah diinisialisasi oleh script sebelumnya
        } else {
            // fallback: ambil dari blade jika ada
            varianData = {};
        }
        // Inisialisasi varianData jika belum ada
        if (!Object.keys(varianData).length && typeof collect === 'undefined') {
            varianData = {};
            @if (isset($varians) && count($varians) > 0)
                @foreach ($varians as $v)
                    varianData['{{ $v->id }}'] = {
                        nama: @json($v->nama),
                        harga: {{ $v->harga }},
                        stok: {{ $v->stok }},
                        gambar: {!! $v->gambar ? '\'' . asset('storage/img/varian/' . $v->gambar) . '\'' : 'null' !!}
                    };
                @endforeach
            @endif
        }

        // Form Beli Sekarang
        var formBeliVarianId = document.getElementById('formBeliVarianId');
        var formBeliJumlah = document.getElementById('formBeliJumlah');
        var formBeliSubtotal = document.getElementById('formBeliSubtotal');

        function updateSubtotal() {
            var harga = 0;
            var jumlah = parseInt(jumlahInput.value) || 1;
            var checked = document.querySelector('input[name="varian_id"]:checked');
            var varianId = checked ? checked.value : '';
            if (checked && varianData[varianId]) {
                harga = parseInt(varianData[varianId].harga) || 0;
            }
            var subtotal = harga * jumlah;
            subtotalEl.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            // Sinkronkan ke form Beli Sekarang
            if (formBeliVarianId) formBeliVarianId.value = varianId;
            if (formBeliJumlah) formBeliJumlah.value = jumlah;
            if (formBeliSubtotal) formBeliSubtotal.value = subtotal;
        }

        radios.forEach(function(radio) {
            radio.addEventListener('change', function() {
                // Ganti gambar jika ada gambar varian
                var id = this.value;
                if (imgEl && varianData[id]) {
                    if (varianData[id].gambar) {
                        imgEl.src = varianData[id].gambar;
                    } else {
                        imgEl.src = produkDefaultImg;
                    }
                }
                updateSubtotal();
            });
        });

        minusBtn && minusBtn.addEventListener('click', function(e) {
            e.preventDefault();
            var val = parseInt(jumlahInput.value) || 1;
            if (val > 1) jumlahInput.value = val - 1;
            updateSubtotal();
        });
        plusBtn && plusBtn.addEventListener('click', function(e) {
            e.preventDefault();
            var val = parseInt(jumlahInput.value) || 1;
            jumlahInput.value = val + 1;
            updateSubtotal();
        });
        jumlahInput && jumlahInput.addEventListener('input', function() {
            updateSubtotal();
        });
        // Inisialisasi pertama
        updateSubtotal();
    });
</script>
