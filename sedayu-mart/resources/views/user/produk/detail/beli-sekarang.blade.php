<!-- ================= BELI SEKARANG MODAL ================= -->
<div id="beli-sekarang-modal-{{ $produk->id }}" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center overflow-y-auto">

    <div class="relative p-4 w-full max-w-2xl h-full flex items-center justify-center">
        <div class="relative bg-white rounded-2xl shadow-2xl overflow-hidden w-full max-h-[90vh] flex flex-col">

            <!-- ================= HEADER ================= -->
            <div class="p-6 bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-600">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-blue-100 font-semibold uppercase">Beli Sekarang</p>
                        <h3 class="text-xl font-bold text-white">Beli produk sekarang</h3>
                    </div>
                    <button data-modal-hide="beli-sekarang-modal-{{ $produk->id }}"
                        class="w-10 h-10 bg-white/10 hover:bg-white/20 rounded-lg text-white flex items-center justify-center">
                        ✕
                    </button>
                </div>
            </div>

            <!-- ================= BODY ================= -->
            <div class="flex-1 overflow-y-auto p-4 space-y-4">

                @php
                    $defaultVarian = collect($varians ?? [])->firstWhere('is_default', true) ?? ($varians[0] ?? null);
                    $produkImg = isset($produk->gambarProduks[0])
                        ? asset('storage/img/produk/' . $produk->gambarProduks[0]->gambar)
                        : asset('img/card/produk1.png');
                    $defaultImg = $defaultVarian?->gambar
                        ? asset('storage/img/varian/' . $defaultVarian->gambar)
                        : $produkImg;
                @endphp

                <!-- ================= PRODUK INFO ================= -->
                <div class="bg-white border rounded-xl p-4 shadow-sm flex gap-4">
                    <img id="beliProductImg" src="{{ $defaultImg }}" data-default="{{ $produkImg }}"
                        class="w-20 h-20 rounded-xl object-cover border">

                    <div>
                        <p class="font-semibold">{{ $produk->nama }}</p>
                        @if ($defaultVarian)
                            <div class="text-xs text-gray-500 mt-2">
                                Varian: <span id="beliVarianNama">{{ $defaultVarian->nama }}</span><br>
                                Harga: <span id="beliVarianHarga">Rp
                                    {{ number_format($defaultVarian->harga, 0, ',', '.') }}</span><br>
                                Stok: <span id="beliVarianStok">{{ $defaultVarian->stok }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- ================= JUMLAH ================= -->
                <div class="bg-white border rounded-xl p-4">
                    <label class="text-sm font-semibold">Jumlah</label>
                    <div class="flex items-center gap-2 mt-2">
                        <button id="beliMinus" class="w-10 h-10 bg-gray-100 rounded-lg">−</button>
                        <input id="beliJumlah" value="1" class="w-24 text-center border rounded-lg py-2">
                        <button id="beliPlus" class="w-10 h-10 bg-gray-100 rounded-lg">+</button>
                    </div>
                </div>

                <!-- ================= VARIAN ================= -->
                @if (isset($varians) && count($varians))
                    <div>
                        <h2 class="font-bold mb-4">Varian Produk</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach ($varians as $varian)
                                <label
                                    class="group varian-card-label bg-white rounded-2xl border shadow-lg hover:shadow-xl p-4 flex gap-4 cursor-pointer relative transition">

                                    <input type="radio" name="beli_varian_id" value="{{ $varian->id }}"
                                        class="sr-only" @checked($defaultVarian?->id === $varian->id)>

                                    <!-- CHECK ICON -->
                                    <span class="absolute top-2 right-2 hidden group-[.varian-selected]:block">
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>

                                    <!-- IMAGE -->
                                    <div class="w-16 h-16">
                                        @if ($varian->gambar)
                                            <img src="{{ asset('storage/img/varian/' . $varian->gambar) }}"
                                                class="w-16 h-16 rounded-xl object-cover border">
                                        @else
                                            <div class="w-16 h-16 bg-gray-100 rounded-xl"></div>
                                        @endif
                                    </div>

                                    <!-- INFO -->
                                    <div class="flex-1">
                                        <p class="font-bold">{{ $varian->nama }}</p>
                                        <p class="text-green-700 font-semibold text-sm">
                                            Rp {{ number_format($varian->harga, 0, ',', '.') }}
                                        </p>
                                        <p class="text-sm">Stok: {{ $varian->stok }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- ================= SUBTOTAL ================= -->
                <div class="bg-green-50 border rounded-xl p-4 flex justify-between font-semibold text-green-800">
                    <span>Subtotal</span>
                    <span id="beliSubtotal">Rp 0</span>
                </div>
            </div>

            <!-- ================= FOOTER ================= -->
            <div class="p-4 border-t bg-gray-50 flex flex-col sm:flex-row gap-3 justify-end">
                <form id="formBeliSekarang" method="POST" action="{{ route('user.produk.beliSekarang') }}"
                    class="sm:w-auto w-full">
                    @csrf
                    <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                    <input type="hidden" name="varian_id" id="beliVarianId">
                    <input type="hidden" name="jumlah" id="beliJumlahForm">
                    <input type="hidden" name="subtotal" id="beliSubtotalForm">

                    <button
                        class="w-full sm:w-auto py-2.5 px-6 rounded-lg bg-orange-500 hover:bg-orange-600 text-white font-semibold flex items-center justify-center gap-2">
                        💳 Beli Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ================= STYLE ================= -->
<style>
    .varian-card-label {
        border-width: 2px;
        border-color: #e5e7eb;
        transition: border-color .2s, box-shadow .2s;
    }

    .varian-card-label.varian-selected {
        border-color: #22c55e !important;
        box-shadow: 0 0 0 2px #22c55e33;
    }
</style>

<!-- ================= SCRIPT ================= -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('beli-sekarang-modal-{{ $produk->id }}');
        if (!modal) return;

        const radios = modal.querySelectorAll('input[name="beli_varian_id"]');
        const jumlahInput = modal.querySelector('#beliJumlah');
        const subtotalEl = modal.querySelector('#beliSubtotal');
        const imgEl = modal.querySelector('#beliProductImg');

        const formVarian = modal.querySelector('#beliVarianId');
        const formJumlah = modal.querySelector('#beliJumlahForm');
        const formSubtotal = modal.querySelector('#beliSubtotalForm');


        const varianData = {
            @foreach ($varians as $v)
                '{{ $v->id }}': {
                    nama: @json($v->nama),
                    harga: {{ $v->harga }},
                    stok: {{ $v->stok }},
                    gambar: {!! $v->gambar ? '\'' . asset('storage/img/varian/' . $v->gambar) . '\'' : 'null' !!}
                },
            @endforeach
        };

        const varianNamaEl = modal.querySelector('#beliVarianNama');
        const varianHargaEl = modal.querySelector('#beliVarianHarga');
        const varianStokEl = modal.querySelector('#beliVarianStok');

        function updateHighlight() {
            radios.forEach(radio => {
                const card = radio.closest('.varian-card-label');
                card.classList.toggle('varian-selected', radio.checked);
            });
        }

        function updateProdukInfo(varianId) {
            if (!varianData[varianId]) return;
            if (varianNamaEl) varianNamaEl.textContent = varianData[varianId].nama;
            if (varianHargaEl) varianHargaEl.textContent = 'Rp ' + Number(varianData[varianId].harga)
                .toLocaleString('id-ID');
            if (varianStokEl) varianStokEl.textContent = varianData[varianId].stok;
        }

        function updateSubtotal() {
            const checked = modal.querySelector('input[name="beli_varian_id"]:checked');
            if (!checked) return;

            const jumlah = parseInt(jumlahInput.value) || 1;
            const harga = varianData[checked.value].harga;
            const subtotal = harga * jumlah;

            subtotalEl.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            formVarian.value = checked.value;
            formJumlah.value = jumlah;
            formSubtotal.value = subtotal;

            if (varianData[checked.value].gambar) {
                imgEl.src = varianData[checked.value].gambar;
            }
            updateProdukInfo(checked.value);
        }

        radios.forEach(radio => {
            radio.addEventListener('change', () => {
                updateHighlight();
                updateSubtotal();
            });
        });

        modal.querySelector('#beliMinus').onclick = e => {
            e.preventDefault();
            if (jumlahInput.value > 1) jumlahInput.value--;
            updateSubtotal();
        };

        modal.querySelector('#beliPlus').onclick = e => {
            e.preventDefault();
            jumlahInput.value++;
            updateSubtotal();
        };

        updateHighlight();
        updateSubtotal();
    });
</script>
