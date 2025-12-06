<!-- Pesanan detail modal (returned by controller show) -->
<div id="pesananShowModal" onclick="if(event.target===this) this.remove()"
    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-[1000] px-4">
    <div
        class="bg-white w-full max-w-2xl p-4 sm:p-6 rounded-xl sm:rounded-2xl shadow-lg relative max-h-[90vh] overflow-y-auto">
        <button id="pesananShowClose" onclick="document.getElementById('pesananShowModal')?.remove()" type="button"
            aria-label="Tutup"
            class="absolute top-3 right-3 sm:top-4 sm:right-4 p-1.5 sm:p-2 rounded-md border hover:bg-gray-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-600" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
        </button>

        <!-- Header -->
        <h2 class="text-xl sm:text-2xl font-bold text-green-800 mb-3 pr-8">Detail Pesanan </h2>

        <!-- Divider under header (full width across modal content) -->
        <div class="-mx-4 sm:-mx-6 h-px bg-gray-200 mb-4 sm:mb-6"></div>

        <div class="mt-3">
            <div dir="ltr" class="space-y-3 text-sm text-gray-700">
                {{-- Item cards at top --}}
                <div>
                    <p class="font-semibold mb-2 text-sm sm:text-base">Item Pesanan</p>
                    <div class="space-y-2">
                        @foreach ($pesanan->items as $item)
                            <div
                                class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3 p-2 sm:p-3 border rounded-lg">
                                @php
                                    $img = optional($item->produk->gambarProduks->first())->gambar ?? null;
                                    $imgPath = $img
                                        ? asset('storage/img/produk/' . $img)
                                        : asset('img/card/produk1.png');
                                @endphp
                                <img src="{{ $imgPath }}" class="h-14 w-14 sm:h-16 sm:w-16 object-cover rounded" />
                                <div class="flex-1 min-w-0">
                                    <div class="font-semibold text-sm sm:text-base line-clamp-2">
                                        {{ optional($item->produk)->nama ?? '-' }}</div>
                                    <div class="text-xs sm:text-sm text-gray-600">Kuantitas: {{ $item->kuantitas }}
                                        {{ optional($item->produk)->satuan_produk ?? '' }}</div>
                                </div>
                                <div class="text-left sm:text-right w-full sm:w-auto">
                                    <div class="font-semibold text-sm sm:text-base">Rp
                                        {{ number_format($item->harga_saat_pemesanan ?? 0, 0, ',', '.') }}</div>
                                    <div class="text-xs sm:text-sm text-gray-600">Subtotal: Rp
                                        {{ number_format($item->harga_saat_pemesanan * $item->kuantitas ?? 0, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Status (highlight) and date --}}
                @php
                    $statusText = $pesanan->status ?? '-';
                    $statusClass = 'bg-gray-100 text-gray-800';

                    if ($statusText === 'Menunggu Verifikasi') {
                        $statusClass = 'bg-gray-200 text-gray-800';
                    } elseif ($statusText === 'Ditolak') {
                        $statusClass = 'bg-red-100 text-red-800';
                    } elseif ($statusText === 'Diterima') {
                        $statusClass = 'bg-blue-100 text-blue-800';
                    } elseif ($statusText === 'Dalam Pengiriman') {
                        $statusClass = 'bg-yellow-300 text-yellow-800';
                    } elseif ($statusText === 'Selesai') {
                        $statusClass = 'bg-green-100 text-green-800';
                    }
                @endphp
                <div class="flex items-center justify-between">
                    <div><span
                            class="inline-block px-3 py-1 rounded-full text-xs {{ $statusClass }}">{{ $statusText }}</span>
                    </div>
                    <div class="text-sm text-gray-600">{{ optional($pesanan->created_at)->format('d M Y H:i') ?? '-' }}
                    </div>
                </div>

                {{-- Totals: ongkir, subtotal produk, total bayar --}}
                <div class="space-y-1 text-sm sm:text-base">
                    <div class="flex justify-between">
                        <div><span class="font-semibold">Ongkir:</span></div>
                        <div>Rp {{ number_format($pesanan->ongkir ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <div class="flex justify-between">
                        <div><span class="font-semibold">Subtotal Produk:</span></div>
                        <div>Rp {{ number_format($pesanan->subtotal_produk ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <div class="flex justify-between">
                        <div><span class="font-semibold">Total Bayar:</span></div>
                        <div class="font-semibold">Rp {{ number_format($pesanan->total_bayar ?? 0, 0, ',', '.') }},-
                        </div>
                    </div>
                </div>

                {{-- Bukti Pembayaran --}}
                <div class="mt-2">
                    <p class="font-semibold text-sm sm:text-base">Bukti Pembayaran</p>
                    @if ($pesanan->bukti_pembayaran)
                        @php
                            $buktiPath = asset('storage/img/bukti_pembayaran/' . $pesanan->bukti_pembayaran);
                        @endphp
                        <div class="mt-2">
                            <a href="{{ $buktiPath }}" target="_blank"
                                class="inline-block mb-2 text-sm text-blue-600 hover:underline">Lihat bukti
                                pembayaran</a>
                            <div>
                                <img src="{{ $buktiPath }}" alt="Bukti Pembayaran"
                                    class="h-40 object-contain border rounded" />
                            </div>
                        </div>
                    @else
                        <div class="text-gray-600">Belum ada bukti pembayaran.</div>
                    @endif
                </div>

                {{-- Alamat Pengiriman --}}
                <div>
                    <p class="font-semibold text-sm sm:text-base">Alamat Pengiriman</p>
                    <p class="text-gray-600 text-sm sm:text-base">
                        {{ $pesanan->alamat ?? ($pesanan->alamat_penerima ?? '-') }}</p>
                </div>

                {{-- Catatan --}}
                <div>
                    <p class="font-semibold text-sm sm:text-base">Catatan</p>
                    <p class="text-gray-600 text-sm sm:text-base">{{ $pesanan->catatan ?? '-' }}</p>
                </div>

                {{-- Keterangan (alasan ditolak) --}}
                <div>
                    <p class="font-semibold text-sm sm:text-base">Keterangan</p>
                    <p class="text-gray-600 text-sm sm:text-base">{{ $pesanan->keterangan ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        const closeBtn = document.getElementById('pesananShowClose');
        const closeBtn2 = document.getElementById('pesananShowCloseBottom');
        const modal = document.getElementById('pesananShowModal');

        if (!modal) return;

        function onKey(e) {
            if (e.key === 'Escape') close();
        }

        function close() {
            if (!modal) return;
            // remove modal element from DOM
            modal.remove();
            // cleanup listeners
            document.removeEventListener('keydown', onKey);
        }

        if (closeBtn) closeBtn.addEventListener('click', close);
        if (closeBtn2) closeBtn2.addEventListener('click', close);

        // close on overlay click (only when clicking the dark backdrop)
        modal.addEventListener('click', function(e) {
            if (e.target === modal) close();
        });

        // close on ESC
        document.addEventListener('keydown', onKey);
    })();
</script>
