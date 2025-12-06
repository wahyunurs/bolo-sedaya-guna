(function() {
    function bindRows() {
        document.querySelectorAll('.pesanan-row').forEach(function(row) {
            row.addEventListener('click', function(e) {
                // Skip if clicking on action buttons/links
                if (e.target.closest('a') || e.target.closest('button')) return;

                const pesananId = row.getAttribute('data-pesanan-id');
                const showUrl = row.getAttribute('data-show-url') || `/admin/pesanan/show/${pesananId}`;
                if (!pesananId || !showUrl) return;

                // Fetch pesanan details (support subfolder deploys via data-show-url)
                fetch(showUrl)
                    .then(res => res.json())
                    .then(data => showPesananModal(data))
                    .catch(err => console.error('Error fetching pesanan:', err));
            });
        });
    }

    function showPesananModal(pesanan) {
        const template = document.getElementById('pesananShowModalTemplate');
        if (!template) return;

        // Clone template
        const modal = template.content.cloneNode(true);

        // Populate items
        const itemsContainer = modal.querySelector('.pesananItemsContainer');
        itemsContainer.innerHTML = '';
        if (pesanan.items && pesanan.items.length > 0) {
            pesanan.items.forEach(item => {
                const produk = item.produk || {};
                const gambar = produk.gambar_produks && produk.gambar_produks[0]
                    ? produk.gambar_produks[0].gambar
                    : null;
                const imgPath = gambar
                    ? `/storage/img/produk/${gambar}`
                    : `/img/card/produk1.png`;

                const itemHtml = `
                    <div class="flex items-center gap-3 p-3 border rounded-lg">
                        <img src="${imgPath}" class="h-16 w-16 object-cover rounded" alt="${produk.nama || '-'}" />
                        <div class="flex-1">
                            <div class="font-semibold">${produk.nama || '-'}</div>
                            <div class="text-sm text-gray-600">Kuantitas: ${item.kuantitas} ${produk.satuan_produk || ''}</div>
                        </div>
                        <div class="text-right">
                            <div class="font-semibold">Rp ${numberFormat(item.harga_saat_pemesanan || 0)}</div>
                            <div class="text-sm text-gray-600">Subtotal: Rp ${numberFormat((item.harga_saat_pemesanan || 0) * item.kuantitas)}</div>
                        </div>
                    </div>
                `;
                itemsContainer.insertAdjacentHTML('beforeend', itemHtml);
            });
        }

        // Populate status
        const statusBadge = modal.querySelector('.pesananStatusBadge');
        statusBadge.textContent = pesanan.status || '-';
        statusBadge.className = `inline-block px-3 py-1 rounded-full text-xs ${getStatusClass(pesanan.status)}`;

        // Populate date
        const createdDate = modal.querySelector('.pesananCreatedDate');
        if (pesanan.created_at) {
            const date = new Date(pesanan.created_at);
            createdDate.textContent = date.toLocaleDateString('id-ID', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
            });
        }

        // Populate totals
        modal.querySelector('.pesananOngkir').textContent = `Rp ${numberFormat(pesanan.ongkir || 0)}`;
        modal.querySelector('.pesananSubtotal').textContent = `Rp ${numberFormat(pesanan.subtotal_produk || 0)}`;
        modal.querySelector('.pesananTotalBayar').textContent = `Rp ${numberFormat(pesanan.total_bayar || 0)},-`;

        // Populate bukti pembayaran
        const buktiContainer = modal.querySelector('.pesananBuktiContainer');
        if (pesanan.bukti_pembayaran) {
            const buktiPath = `/storage/img/bukti_pembayaran/${pesanan.bukti_pembayaran}`;
            buktiContainer.innerHTML = `
                <div class="mt-2">
                    <a href="${buktiPath}" target="_blank" class="inline-block mb-2 text-sm text-blue-600 hover:underline">Lihat bukti pembayaran</a>
                    <div>
                        <img src="${buktiPath}" alt="Bukti Pembayaran" class="h-40 object-contain border rounded" />
                    </div>
                </div>
            `;
        } else {
            buktiContainer.innerHTML = '<div class="text-gray-600">Belum ada bukti pembayaran.</div>';
        }

        // Populate alamat/catatan/keterangan
        modal.querySelector('.pesananAlamat').textContent = pesanan.alamat || pesanan.alamat_penerima || '-';
        modal.querySelector('.pesananCatatan').textContent = pesanan.catatan || '-';
        modal.querySelector('.pesananKeterangan').textContent = pesanan.keterangan || '-';

        // Attach close handlers
        const closeBtn = modal.querySelector('.pesananShowClose');
        const modalDiv = modal.querySelector('[onclick*="remove"]');

        function closeModal() {
            if (modalDiv && modalDiv.parentElement) {
                modalDiv.remove();
            }
        }

        if (closeBtn) closeBtn.addEventListener('click', closeModal);

        // Close on overlay click
        if (modalDiv) {
            modalDiv.addEventListener('click', function(e) {
                if (e.target === this) closeModal();
            });
        }

        // Close on ESC
        const escHandler = function(e) {
            if (e.key === 'Escape') {
                closeModal();
                document.removeEventListener('keydown', escHandler);
            }
        };
        document.addEventListener('keydown', escHandler);

        // Remove any existing show modal instances
        document.querySelectorAll('.pesananShowModal').forEach(function(existing) {
            existing.remove();
        });

        // Append modal to body
        document.body.appendChild(modal);
    }

    function numberFormat(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }

    function getStatusClass(status) {
        switch (status) {
            case 'Menunggu Verifikasi':
                return 'bg-gray-200 text-gray-800';
            case 'Ditolak':
                return 'bg-red-100 text-red-800';
            case 'Diterima':
                return 'bg-blue-100 text-blue-800';
            case 'Dalam Pengiriman':
                return 'bg-yellow-300 text-yellow-800';
            case 'Selesai':
                return 'bg-green-100 text-green-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bindRows);
    } else {
        bindRows();
    }
})();