<!-- Update Status Modal Template -->
<template id="pesananUpdateStatusModalTemplate">
    <div class="pesananUpdateStatusModal fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-[1000]">
        <div class="bg-white w-[95%] max-w-2xl p-6 rounded-2xl shadow-lg relative">
            <button class="pesananUpdateStatusClose absolute top-4 right-4 p-2 rounded-md border hover:bg-gray-50"
                type="button" aria-label="Tutup">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>

            <!-- Header -->
            <h2 class="text-2xl font-bold text-blue-800 mb-3">Perbarui Status Pesanan</h2>

            <!-- Divider -->
            <div class="-mx-6 h-px bg-gray-200 mb-6"></div>

            <form class="pesananUpdateStatusForm space-y-4" method="POST" action="">
                @csrf
                <input type="hidden" name="status" class="updateStatusInput" value="">

                <div style="max-height: calc(70vh); overflow-y:auto;" class="mt-2 space-y-3 text-sm text-gray-700">
                    <!-- Item cards -->
                    <div>
                        <p class="font-semibold mb-2">Item Pesanan</p>
                        <div class="pesananItemsContainer space-y-2"><!-- populated by JS --></div>
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
                        <div class="pesananBuktiContainer"><!-- populated by JS --></div>
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

                    <!-- Status Selection -->
                    <div>
                        <label class="block font-semibold mb-2" for="statusSelect">Pilih Status Baru</label>
                        <div class="space-y-2">
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-blue-50">
                                <input type="radio" name="statusOption" value="Dalam Pengiriman"
                                    class="statusOption mr-3">
                                <div>
                                    <div class="font-medium text-gray-800">Dalam Pengiriman</div>
                                    <div class="text-sm text-gray-600">Pesanan sedang dalam proses pengiriman</div>
                                </div>
                            </label>
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-blue-50">
                                <input type="radio" name="statusOption" value="Selesai" class="statusOption mr-3">
                                <div>
                                    <div class="font-medium text-gray-800">Selesai</div>
                                    <div class="text-sm text-gray-600">Pesanan telah diterima oleh pelanggan</div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button"
                        class="pesananUpdateStatusCancel px-4 py-2 bg-gray-200 rounded-md">Batal</button>
                    <button type="button"
                        class="pesananUpdateStatusSubmit px-4 py-2 bg-blue-600 text-white rounded-md">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</template>
