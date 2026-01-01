@component('user.components.user-layout')
    @include('user.components.navbar')

    <section class="pt-20 sm:pt-24 pb-8 bg-[#e9ffe1] min-h-screen">

        @include('user.components.message-modal')

        <div class="max-w-4xl mx-auto px-4 sm:px-6">

            <div class="bg-white p-4 sm:p-6 md:p-8 rounded-2xl shadow mt-6">

                <!-- ================= HEADER ================= -->
                <div class="flex items-center gap-3 mb-6">
                    <a href="{{ route('user.produk.index') }}" class="text-green-700 hover:text-green-900">←</a>
                    <h2 class="text-2xl font-extrabold text-green-800">Checkout</h2>
                </div>

                @php
                    // ====== AMBIL DARI QUERY STRING (BELI SEKARANG) ======
                    $qty = (int) request('kuantitas', 1);
                    $subtotal = (int) request('subtotal', $qty * $varian->harga);
                @endphp

                <form action="{{ route('user.produk.bayarSekarang') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- ================= PRODUK ================= -->
                    <div class="border rounded-xl p-4 mb-6 flex gap-4">

                        <img src="{{ $varian->gambar
                            ? asset('storage/img/varian/' . $varian->gambar)
                            : asset('storage/img/produk/' . optional($produk->gambarProduks->first())->gambar) }}"
                            class="w-24 h-24 rounded-xl object-cover border">

                        <div class="flex-1">
                            <p class="font-bold text-green-900">{{ $produk->nama }}</p>
                            <p class="text-sm text-gray-600">Varian: {{ $varian->nama }}</p>
                            <p class="font-semibold text-green-700">
                                Rp {{ number_format($varian->harga, 0, ',', '.') }}
                            </p>
                        </div>

                        <!-- ================= JUMLAH ================= -->
                        <div class="flex flex-col items-end">
                            <div class="flex items-center gap-1">
                                <button type="button" id="minus" class="w-7 h-7 bg-gray-100 rounded">−</button>
                                <input id="qty" value="{{ $qty }}" readonly
                                    class="w-12 text-center border rounded">
                                <button type="button" id="plus" class="w-7 h-7 bg-gray-100 rounded">+</button>
                            </div>

                            <p class="text-sm text-gray-600 mt-2">
                                Subtotal:
                                <span id="subtotalText">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- ================= HIDDEN ================= -->
                    <input type="hidden" name="produk_id" value="{{ request('produk_id') }}">
                    <input type="hidden" name="varian_id" value="{{ request('varian_id') }}">
                    <input type="hidden" name="kuantitas" id="qtyForm" value="{{ $qty }}">
                    <input type="hidden" name="subtotal" id="subtotalForm" value="{{ $subtotal }}">

                    <!-- ================= ALAMAT ================= -->
                    <div class="border rounded-xl p-4 mb-6 bg-gray-50 relative">
                        <h3 class="font-bold text-green-800 mb-2">Alamat Pengiriman</h3>

                        <button type="button"
                            onclick="document.getElementById('modalEditAlamat').classList.remove('hidden')"
                            class="absolute top-3 right-3 text-green-700 text-sm font-semibold">
                            Ubah
                        </button>

                        <p class="font-medium">{{ $alamat_tujuan }}</p>
                        <p class="text-sm text-gray-600">{{ $kabupaten_tujuan }}</p>
                    </div>

                    <input type="hidden" name="alamat" value="{{ $alamat_tujuan }}">
                    <input type="hidden" name="kabupaten_tujuan" value="{{ $kabupaten_tujuan }}">

                    <!-- ================= REKENING ================= -->
                    <div class="border rounded-xl p-4 mb-6">
                        <h3 class="font-bold text-green-800 mb-3">Pilih Rekening Pembayaran</h3>

                        <div class="space-y-3">
                            @foreach ($rekenings as $rek)
                                <label class="flex items-center gap-3 border rounded-lg p-3 cursor-pointer">
                                    <input type="radio" name="rekening_id" value="{{ $rek->id }}"
                                        class="accent-green-600" required>
                                    <div>
                                        <p class="font-semibold">{{ $rek->nama_bank }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $rek->nomor_rekening }} a.n {{ $rek->atas_nama }}
                                        </p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- ================= TOTAL ================= -->
                    <div class="border rounded-xl p-4 bg-green-50 mb-6">
                        <div class="flex justify-between font-bold text-green-800">
                            <span>Total Bayar</span>
                            <span id="totalText">
                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- ================= BUKTI ================= -->
                    <div class="mb-6">
                        <label class="font-semibold">Upload Bukti Pembayaran</label>
                        <input type="file" name="bukti_pembayaran" class="w-full mt-2 border rounded-lg p-2"
                            accept="image/*" required>
                    </div>

                    <!-- ================= CATATAN ================= -->
                    <div class="mb-6">
                        <label class="font-semibold">Catatan</label>
                        <textarea name="catatan" rows="3" class="w-full border rounded-lg p-3" placeholder="Catatan tambahan (opsional)"></textarea>
                    </div>

                    <!-- ================= ACTION ================= -->
                    <div class="flex justify-end">
                        <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold">
                            Bayar Sekarang
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </section>

    @include('user.produk.edit-alamat')

    <!-- ================= SCRIPT ================= -->
    <script>
        const harga = {{ (int) $varian->harga }};
        const qtyEl = document.getElementById('qty');
        const qtyForm = document.getElementById('qtyForm');
        const subtotalForm = document.getElementById('subtotalForm');
        const subtotalText = document.getElementById('subtotalText');
        const totalText = document.getElementById('totalText');

        function recalc() {
            const qty = parseInt(qtyEl.value) || 1;
            const total = qty * harga;

            qtyForm.value = qty;
            subtotalForm.value = total;

            subtotalText.textContent = 'Rp ' + total.toLocaleString('id-ID');
            totalText.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        document.getElementById('minus').onclick = () => {
            if (qtyEl.value > 1) {
                qtyEl.value--;
                recalc();
            }
        };

        document.getElementById('plus').onclick = () => {
            qtyEl.value++;
            recalc();
        };
    </script>
@endcomponent
