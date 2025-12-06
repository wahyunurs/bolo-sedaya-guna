<!-- Pesanan detail modal template (dynamically populated by JS) -->
<template id="pesananShowModalTemplate">
    <div class="pesananShowModal fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-[1000]"
        onclick="if(event.target===this) this.remove()">
        <div class="bg-white w-[95%] max-w-2xl p-6 rounded-2xl shadow-lg relative">
            <button class="pesananShowClose absolute top-4 right-4 p-2 rounded-md border hover:bg-gray-50" type="button"
                aria-label="Tutup">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>

            <!-- Header -->
            <h2 class="text-2xl font-bold text-green-800 mb-3">Detail Pesanan</h2>

            <!-- Divider -->
            <div class="-mx-6 h-px bg-gray-200 mb-6"></div>

            <div style="max-height: calc(90vh - 6rem); overflow-y:auto;" class="mt-3">
                <div dir="ltr" class="space-y-3 text-sm text-gray-700">
                    <!-- Item cards -->
                    <div>
                        <p class="font-semibold mb-2">Item Pesanan</p>
                        <div class="pesananItemsContainer space-y-2">
                            <!-- Populated by JS -->
                        </div>
                    </div>

                    <!-- Status and date -->
                    <div class="flex items-center justify-between">
                        <div><span class="pesananStatusBadge inline-block px-3 py-1 rounded-full text-xs">-</span></div>
                        <div class="pesananCreatedDate text-sm text-gray-600">-</div>
                    </div>

                    <!-- Totals -->
                    <div class="space-y-1">
                        <div class="flex justify-between">
                            <div><span class="font-semibold">Ongkir:</span></div>
                            <div class="pesananOngkir">Rp 0</div>
                        </div>
                        <div class="flex justify-between">
                            <div><span class="font-semibold">Subtotal Produk:</span></div>
                            <div class="pesananSubtotal">Rp 0</div>
                        </div>
                        <div class="flex justify-between">
                            <div><span class="font-semibold">Total Bayar:</span></div>
                            <div class="pesananTotalBayar font-semibold">Rp 0,-</div>
                        </div>
                    </div>

                    <!-- Bukti Pembayaran -->
                    <div class="mt-2">
                        <p class="font-semibold">Bukti Pembayaran</p>
                        <div class="pesananBuktiContainer">
                            <!-- Populated by JS -->
                        </div>
                    </div>

                    <!-- Alamat Pengiriman -->
                    <div>
                        <p class="font-semibold">Alamat Pengiriman</p>
                        <p class="pesananAlamat text-gray-600">-</p>
                    </div>

                    <!-- Catatan -->
                    <div>
                        <p class="font-semibold">Catatan</p>
                        <p class="pesananCatatan text-gray-600">-</p>
                    </div>

                    <!-- Keterangan -->
                    <div>
                        <p class="font-semibold">Keterangan</p>
                        <p class="pesananKeterangan text-gray-600">-</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
