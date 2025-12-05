<x-app-layout>
    @include('user.components.navbar')

    <section class="py-16 bg-[#e9ffe1] min-h-screen">

        <!-- Modal Flash Message -->
        @include('user.components.message-modal')

        <div class="max-w-4xl mx-auto px-6">

            <!-- SINGLE CARD -->
            <div class="bg-white p-8 rounded-2xl shadow mt-8">

                <div class="flex items-center gap-3 mb-6">
                    <a href="{{ route('user.pesanan.index') }}" aria-label="Kembali ke detail"
                        class="text-green-700 hover:text-green-900 p-1 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-arrow-left-icon lucide-arrow-left">
                            <path d="m12 19-7-7 7-7" />
                            <path d="M19 12H5" />
                        </svg>
                    </a>
                    <h2 class="text-3xl font-extrabold text-green-800">Ubah Pesanan</h2>
                </div>

                <form action="{{ route('user.pesanan.update', $pesanan->id) }}" method="POST"
                    enctype="multipart/form-data" id="checkoutForm">
                    @csrf
                    @method('PUT')
                    @csrf

                    @php
                        // Prepare summary values from pesanan
                        $subtotal =
                            $pesanan->subtotal_produk ??
                            $pesanan->items->sum(function ($it) {
                                return ($it->harga_saat_pemesanan ?? 0) * $it->kuantitas;
                            });
                        $totalBeratGram = $pesanan->berat_total ?? $pesanan->items->sum('berat_total');
                        $ongkir = $pesanan->ongkir ?? 0;
                        $alamat_tujuan = $pesanan->alamat ?? (auth()->user()->alamat ?? '');
                        $kabupaten_tujuan = $pesanan->kabupaten_tujuan ?? (auth()->user()->kabupaten ?? '');
                    @endphp

                    <!-- PRODUK RINGKASAN (items from pesanan) -->
                    <div class="mb-6 p-4 border rounded-lg">
                        @foreach ($pesanan->items as $item)
                            @php
                                $produk = $item->produk;
                                $gambar = optional($produk->gambarProduks->first())->gambar;
                                $imgPath = $gambar
                                    ? asset('storage/img/produk/' . $gambar)
                                    : asset('img/card/produk1.png');
                            @endphp
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-24 h-24 bg-gray-50 rounded-lg overflow-hidden flex-shrink-0">
                                    <img src="{{ $imgPath }}" alt="{{ $produk->nama }}"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-green-900">{{ $produk->nama }}</p>
                                    <p class="text-sm text-gray-600">Rp
                                        {{ number_format($item->harga_saat_pemesanan ?? ($produk->harga ?? 0), 0, ',', '.') }},-
                                    </p>
                                </div>
                                <!-- KUANTITAS + SUBTOTAL -->
                                <div class="ml-auto flex flex-col items-end gap-2">
                                    <div class="flex items-center gap-1">
                                        <span class="text-sm text-gray-700">Jumlah : </span>

                                        <button type="button"
                                            class="decreaseBtn w-6 h-6 flex items-center justify-center bg-gray-100 rounded-sm text-green-700 hover:bg-gray-200 text-xs">-</button>

                                        <input type="text" inputmode="numeric" pattern="[0-9]*"
                                            name="items[{{ $item->id }}][kuantitas]" value="{{ $item->kuantitas }}"
                                            class="qty-input w-16 text-center p-1 border rounded-sm text-sm"
                                            data-item-id="{{ $item->id }}"
                                            data-price="{{ $item->harga_saat_pemesanan ?? ($produk->harga ?? 0) }}"
                                            data-weight="{{ $produk->berat ?? 0 }}"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, ''); if (this.value === '') this.value = 1;" />

                                        <button type="button"
                                            class="increaseBtn w-6 h-6 flex items-center justify-center bg-gray-100 rounded-sm text-green-700 hover:bg-gray-200 text-xs">+</button>
                                    </div>

                                    <div class="text-right">
                                        <p class="text-sm text-gray-600">
                                            Subtotal: Rp <span class="item-subtotal"
                                                data-item-id="{{ $item->id }}">{{ number_format(($item->harga_saat_pemesanan ?? ($produk->harga ?? 0)) * $item->kuantitas, 0, ',', '.') }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="items[{{ $item->id }}][id]" value="{{ $item->id }}">
                            <input type="hidden" name="items[{{ $item->id }}][harga_saat_pemesanan]"
                                value="{{ $item->harga_saat_pemesanan }}">
                        @endforeach
                    </div>

                    <!-- ALAMAT READONLY -->
                    <div class="mb-6 p-4 border rounded-lg bg-gray-50 relative">

                        <button type="button"
                            onclick="(function(m){m.classList.remove('hidden');m.classList.add('flex');})(document.getElementById('modalEditAlamat'))"
                            class="absolute right-3 top-3 text-green-700 hover:text-green-900 text-sm font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-pen-icon lucide-pen inline-block mr-1 w-4 h-4">
                                <path
                                    d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                            </svg>
                            Ubah Alamat
                        </button>

                        <h3 class="font-bold text-green-800 text-lg mb-2">Alamat Pengiriman</h3>

                        <p class="text-gray-800 font-medium">{{ $alamat_tujuan }}</p>
                        <p class="text-gray-600 mt-1">{{ $kabupaten_tujuan }}</p>
                    </div>

                    <!-- HIDDEN ADDRESS INPUT (DIKIRIM KE SERVER) -->
                    <input type="hidden" id="hiddenAlamat" name="alamat" value="{{ old('alamat', $alamat_tujuan) }}">
                    <input type="hidden" id="hiddenKabupaten" name="kabupaten_tujuan"
                        value="{{ old('kabupaten_tujuan', $kabupaten_tujuan) }}">

                    <!-- RINGKASAN TOTAL -->
                    <div class="p-4 mt-8 border rounded-xl bg-gray-50">
                        <h3 class="font-extrabold text-green-800 mb-4">Ringkasan Pesanan</h3>

                        <div class="mb-3 flex justify-between text-gray-700">
                            <span>Subtotal produk</span>
                            <span id="subtotalText">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <div class="mb-3 space-y-1 text-gray-700">
                            <div class="flex justify-between">
                                <span class="text-sm">Tarif / kg</span>
                                <span id="tarifPerKgText" class="text-sm text-gray-700">Rp
                                    {{ number_format($tarif_per_kg ?? 0, 0, ',', '.') }}/kg</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-sm">Total Berat</span>
                                <span id="beratTotalText"
                                    class="text-sm text-gray-700">{{ number_format(($totalBeratGram ?? ($produk->berat ?? 0) * $kuantitas) / 1000, 2, ',', '.') }}
                                    kg</span>
                            </div>

                            <div class="flex justify-between font-semibold mt-1">
                                <span>Ongkir</span>
                                <span id="ongkirText">Rp {{ number_format($ongkir, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- HIDDEN FOR JS -->
                        <input id="ongkirInput" type="hidden" name="ongkir" value="{{ $ongkir }}">
                        <input id="tarifPerKgInput" type="hidden" name="tarif_per_kg"
                            value="{{ $tarif_per_kg ?? 0 }}">
                        <input id="beratGramInput" type="hidden" name="berat_gram" value="{{ $totalBeratGram }}">
                        <input id="totalBayarHidden" type="hidden" name="total_bayar"
                            value="{{ $subtotal + $ongkir }}">

                        <div class="pt-3 border-t mt-3">
                            <div class="flex justify-between items-center">
                                <span class="font-extrabold text-gray-800">Total Bayar</span>
                                <span id="totalBayarText" class="font-extrabold text-green-700">
                                    Rp {{ number_format($subtotal + $ongkir, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- INPUT BUKTI PEMBAYARAN -->
                    <div class="mt-6 mb-4">
                        <label class="font-semibold text-gray-700">Upload Bukti Pembayaran</label>
                        <input type="file" name="bukti_pembayaran"
                            class="w-full mt-1 p-3 border rounded-lg bg-white" accept="image/*" required>
                    </div>

                    <!-- CATATAN -->
                    <div class="mb-4">
                        <label class="block font-semibold text-gray-700">Catatan Pesanan</label>
                        <textarea name="catatan" rows="3" class="w-full mt-1 p-3 border rounded-lg"
                            placeholder="Masukkan catatan tambahan untuk pesanan">{{ old('catatan') }}</textarea>
                    </div>

                    <div class="flex justify-end mt-8">
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold">
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
    @vite('resources/js/user/pesanan/edit-pesanan.js')

    <script>
        (function() {
            function formatRupiah(number) {
                return new Intl.NumberFormat('id-ID').format(number);
            }

            function formatCurrency(number) {
                return 'Rp ' + formatRupiah(number) + ',-';
            }

            function recalcTotals() {
                const qtyInputs = document.querySelectorAll('.qty-input');
                if (!qtyInputs.length) return;
                let subtotal = 0;
                let totalBerat = 0;

                qtyInputs.forEach(function(input) {
                    const qty = parseInt(input.value) || 0;
                    const price = parseFloat(input.dataset.price) || 0;
                    const weight = parseFloat(input.dataset.weight) || 0; // grams
                    const itemSubtotal = Math.round(price * qty);

                    const itemId = input.dataset.itemId;
                    const span = document.querySelector('.item-subtotal[data-item-id="' + itemId + '"]');
                    if (span) span.textContent = formatCurrency(itemSubtotal);

                    subtotal += itemSubtotal;
                    totalBerat += weight * qty;
                });

                const subtotalEl = document.getElementById('subtotalText');
                if (subtotalEl) subtotalEl.textContent = formatCurrency(subtotal);

                const beratEl = document.getElementById('beratTotalText');
                if (beratEl) beratEl.textContent = (totalBerat / 1000).toFixed(2).replace('.', ',') + ' kg';

                const tarif = parseFloat(document.getElementById('tarifPerKgInput')?.value || 0);
                const totalBeratKg = totalBerat / 1000;
                const ongkir = Math.round(tarif * totalBeratKg);

                const ongkirEl = document.getElementById('ongkirText');
                if (ongkirEl) ongkirEl.textContent = formatCurrency(ongkir);

                const totalBayar = subtotal + ongkir;
                const totalBayarEl = document.getElementById('totalBayarText');
                if (totalBayarEl) totalBayarEl.textContent = formatCurrency(totalBayar);

                const beratInput = document.getElementById('beratGramInput');
                if (beratInput) beratInput.value = totalBerat;
                const ongkirInput = document.getElementById('ongkirInput');
                if (ongkirInput) ongkirInput.value = ongkir;
                const totalBayarHidden = document.getElementById('totalBayarHidden');
                if (totalBayarHidden) totalBayarHidden.value = totalBayar;
            }

            function initQtyHandlers() {
                document.querySelectorAll('.decreaseBtn').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        const input = btn.parentElement.querySelector('.qty-input');
                        if (!input) return;
                        let v = parseInt(input.value) || 1;
                        if (v > 1) v--;
                        input.value = v;
                        input.dispatchEvent(new Event('change', {
                            bubbles: true
                        }));
                    });
                });

                document.querySelectorAll('.increaseBtn').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        const input = btn.parentElement.querySelector('.qty-input');
                        if (!input) return;
                        let v = parseInt(input.value) || 0;
                        v++;
                        input.value = v;
                        input.dispatchEvent(new Event('change', {
                            bubbles: true
                        }));
                    });
                });

                document.querySelectorAll('.qty-input').forEach(function(input) {
                    input.addEventListener('change', function() {
                        if (parseInt(input.value) < 1 || isNaN(parseInt(input.value))) input.value = 1;
                        recalcTotals();
                    });
                });
            }

            document.addEventListener('DOMContentLoaded', function() {
                initQtyHandlers();
                recalcTotals();
            });
        })();
    </script>

</x-app-layout>
