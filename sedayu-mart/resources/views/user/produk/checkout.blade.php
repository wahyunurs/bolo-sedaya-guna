@component('user.components.user-layout')
@include('user.components.navbar')

<section class="pt-20 sm:pt-24 pb-8 bg-[#e9ffe1] min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">

        <div class="bg-white p-4 sm:p-6 md:p-8 rounded-2xl shadow mt-6">

            <!-- ================= HEADER ================= -->
            <div class="flex items-center gap-3 mb-6">
                <a href="{{ route('user.produk.index') }}" class="text-green-700 hover:text-green-900">←</a>
                <h2 class="text-2xl font-extrabold text-green-800">Checkout</h2>
            </div>

            @php
                /* ================= PARAM ================= */
                $qty = max(1, (int) request('kuantitas', 1));
                $alamatId = request('alamat_id');

                /* ================= ALAMAT ================= */
                $alamatUtama = $alamatId
                    ? $alamatPengirimans->where('id', $alamatId)->first()
                    : $alamatPengirimans->where('utama', 1)->first() ?? $alamatPengirimans->first();

                /* ================= BERAT ================= */
                $beratVarianGram = (int) ($varian->berat ?? 1000);
                $totalBeratGram = $beratVarianGram * $qty;
                $totalBeratKg = max(1, (int) ceil($totalBeratGram / 1000));

                /* ================= ONGKIR ================= */
                $tarif = $alamatUtama
                    ? $tarifPengirimans->where('kabupaten', $alamatUtama->kabupaten)->first()
                    : null;

                $tarifPerKg = (int) ($tarif->tarif_per_kg ?? 0);
                $ongkir = $tarifPerKg * $totalBeratKg;

                /* ================= TOTAL ================= */
                $subtotal = $qty * $varian->harga;
                $totalBayar = $subtotal + $ongkir;
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
                            <input id="qty" value="{{ $qty }}" readonly class="w-12 text-center border rounded">
                            <button type="button" id="plus" class="w-7 h-7 bg-gray-100 rounded">+</button>
                        </div>

                        <p class="text-sm text-gray-600 mt-2">
                            Subtotal:
                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <!-- ================= HIDDEN (WAJIB UNTUK CONTROLLER) ================= -->
                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                <input type="hidden" name="varian_id" value="{{ $varian->id }}">
                <input type="hidden" name="kuantitas" value="{{ $qty }}">
                <input type="hidden" name="alamat" value="{{ $alamatUtama->alamat ?? '' }}">
                <input type="hidden" name="kabupaten_tujuan" value="{{ $alamatUtama->kabupaten ?? '' }}">

                <!-- ================= ALAMAT ================= -->
                <div class="border rounded-xl p-4 mb-6 bg-gray-50 relative flex gap-4">
                    <span class="bg-green-100 text-green-700 rounded-xl p-3">📍</span>

                    <div class="flex-1">
                        <div class="font-bold">
                            {{ $alamatUtama->nama_penerima ?? '-' }}
                            @if ($alamatUtama && $alamatUtama->utama)
                                <span class="text-xs bg-green-100 text-green-700 px-2 rounded">Utama</span>
                            @endif
                        </div>
                        <div class="text-sm">{{ $alamatUtama->alamat ?? '-' }}</div>
                        <div class="text-sm text-gray-500">
                            {{ $alamatUtama->kabupaten ?? '-' }}, {{ $alamatUtama->provinsi ?? '-' }}
                        </div>
                        <div class="text-sm text-gray-500">
                            Telp: {{ $alamatUtama->nomor_telepon ?? '-' }}
                        </div>
                        @if ($alamatUtama->keterangan)
                            <div class="text-xs text-gray-400 italic">{{ $alamatUtama->keterangan }}</div>
                        @endif
                    </div>

                    <a href="{{ route('user.produk.alamatPengiriman', [
                        'produk_id' => $produk->id,
                        'varian_id' => $varian->id,
                        'kuantitas' => $qty,
                    ]) }}"
                        class="absolute top-3 right-3 text-green-700 text-sm font-semibold">
                        Ubah
                    </a>
                </div>

                <!-- ================= REKENING ================= -->
                <div class="border rounded-xl p-4 mb-6">
                    <h3 class="font-bold text-green-800 mb-3">Pilih Rekening Pembayaran</h3>
                    @foreach ($rekenings as $rek)
                        <label class="flex items-center gap-3 border rounded-lg p-3 cursor-pointer mb-2">
                            <input type="radio" name="rekening_id" value="{{ $rek->id }}" required>
                            <div>
                                <p class="font-semibold">{{ $rek->nama_bank }}</p>
                                <p class="text-sm text-gray-600">
                                    {{ $rek->nomor_rekening }} a.n {{ $rek->atas_nama }}
                                </p>
                            </div>
                        </label>
                    @endforeach
                </div>

                <!-- ================= TOTAL ================= -->
                <div class="border rounded-xl p-4 bg-green-50 mb-6 space-y-2">
                    <div class="flex justify-between">
                        <span>Subtotal Produk</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Ongkir ({{ $totalBeratKg }} Kg)</span>
                        <span>Rp {{ number_format($ongkir, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-green-800 text-lg">
                        <span>Total Bayar</span>
                        <span>Rp {{ number_format($totalBayar, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- ================= BUKTI ================= -->
                <div class="mb-6">
                    <label class="font-semibold">Upload Bukti Pembayaran</label>
                    <input type="file" name="bukti_pembayaran" required class="w-full mt-2 border rounded-lg p-2">
                </div>

                <!-- ================= CATATAN ================= -->
                <div class="mb-6">
                    <label class="font-semibold">Catatan</label>
                    <textarea name="catatan" rows="3" class="w-full border rounded-lg p-3"></textarea>
                </div>

                <div class="flex justify-end">
                    <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold">
                        Bayar Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    const qtyEl = document.getElementById('qty');

    function reloadWithParams(newQty) {
        const params = new URLSearchParams();
        params.set('produk_id', '{{ $produk->id }}');
        params.set('varian_id', '{{ $varian->id }}');
        params.set('kuantitas', newQty);

        @if(optional($alamatUtama)->id)
            params.set('alamat_id', '{{ $alamatUtama->id }}');
        @endif

        window.location.href = `{{ route('user.produk.checkout') }}?${params.toString()}`;
    }

    document.getElementById('minus').onclick = () => {
        let q = parseInt(qtyEl.value);
        if (q > 1) reloadWithParams(q - 1);
    };

    document.getElementById('plus').onclick = () => {
        let q = parseInt(qtyEl.value);
        reloadWithParams(q + 1);
    };
</script>
@endcomponent
