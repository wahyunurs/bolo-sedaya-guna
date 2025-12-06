// Verifikasi modal logic for Pesanan
(function() {
    function numberFormat(num) {
        return new Intl.NumberFormat('id-ID').format(num || 0);
    }

    function statusClass(status) {
        switch (status) {
            case 'Menunggu Verifikasi': return 'bg-gray-200 text-gray-800';
            case 'Ditolak': return 'bg-red-100 text-red-800';
            case 'Diterima': return 'bg-blue-100 text-blue-800';
            case 'Dalam Pengiriman': return 'bg-yellow-300 text-yellow-800';
            case 'Selesai': return 'bg-green-100 text-green-800';
            default: return 'bg-gray-100 text-gray-800';
        }
    }

    let currentEscHandler = null;

    function closeModal(modalEl) {
        if (modalEl && modalEl.parentElement) {
            modalEl.remove();
        }
        if (currentEscHandler) {
            document.removeEventListener('keydown', currentEscHandler);
            currentEscHandler = null;
        }
    }

    function populateModal(data) {
        const template = document.getElementById('pesananVerifikasiModalTemplate');
        
        if (!template) {
            console.error('Template pesananVerifikasiModalTemplate tidak ditemukan!');
            alert('Template modal tidak ditemukan');
            return;
        }
        
        // Validasi data
        if (!data || !data.id) {
            console.error('Data tidak valid:', data);
            alert('Data pesanan tidak valid');
            return;
        }

        // Clone the template content - untuk browser compatibility
        const clone = template.cloneNode(true);
        const modalEl = clone.content ? clone.content.querySelector('.pesananVerifikasiModal') : clone.querySelector('.pesananVerifikasiModal');
        
        if (!modalEl) {
            console.error('Modal element tidak ditemukan dalam template');
            alert('Struktur modal tidak valid');
            return;
        }
        
        if (!modalEl) {
            console.error('Modal element tidak ditemukan dalam template');
            alert('Struktur modal tidak valid');
            return;
        }
        
        const form = fragment.querySelector('.pesananVerifForm');
        const statusInput = fragment.querySelector('.verifStatusInput');
        const keteranganInput = fragment.querySelector('#verifKeterangan');

        console.log('Form elements:', { form: !!form, statusInput: !!statusInput, keteranganInput: !!keteranganInput });

        // Items
        const itemsContainer = fragment.querySelector('.pesananItemsContainer');
        console.log('Items container found:', !!itemsContainer);
        console.log('Items data:', data.items);
        
        itemsContainer.innerHTML = '';
        if (Array.isArray(data.items) && data.items.length > 0) {
            console.log('Processing ' + data.items.length + ' items');
            data.items.forEach((item, index) => {
                const produk = item.produk || {};
                const gambar = produk.gambar_produks && produk.gambar_produks[0] ? produk.gambar_produks[0].gambar : null;
                const imgPath = gambar ? `/storage/img/produk/${gambar}` : `/img/card/produk1.png`;
                console.log(`Item ${index}:`, { nama: produk.nama, gambar: imgPath });
                const html = `
                    <div class="flex items-center gap-3 p-3 border rounded-lg">
                        <img src="${imgPath}" class="h-16 w-16 object-cover rounded" alt="${produk.nama || '-'}" />
                        <div class="flex-1">
                            <div class="font-semibold">${produk.nama || '-'}</div>
                            <div class="text-sm text-gray-600">Kuantitas: ${item.kuantitas} ${produk.satuan_produk || ''}</div>
                        </div>
                        <div class="text-right">
                            <div class="font-semibold">Rp ${numberFormat(item.harga_saat_pemesanan)}</div>
                            <div class="text-sm text-gray-600">Subtotal: Rp ${numberFormat((item.harga_saat_pemesanan || 0) * (item.kuantitas || 0))}</div>
                        </div>
                    </div>
                `;
                itemsContainer.insertAdjacentHTML('beforeend', html);
            });
        }

        // Status badge
        const badge = fragment.querySelector('.pesananStatusBadge');
        badge.textContent = data.status || '-';
        badge.className = `pesananStatusBadge inline-block px-3 py-1 rounded-full text-xs ${statusClass(data.status)}`;

        // Created date
        const created = fragment.querySelector('.pesananCreatedDate');
        if (data.created_at) {
            const d = new Date(data.created_at);
            created.textContent = d.toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
        }

        // Totals
        fragment.querySelector('.pesananOngkir').textContent = `Rp ${numberFormat(data.ongkir)}`;
        fragment.querySelector('.pesananSubtotal').textContent = `Rp ${numberFormat(data.subtotal_produk)}`;
        fragment.querySelector('.pesananTotalBayar').textContent = `Rp ${numberFormat(data.total_bayar)},-`;

        // Bukti
        const buktiContainer = fragment.querySelector('.pesananBuktiContainer');
        if (data.bukti_pembayaran) {
            const path = `/storage/img/bukti_pembayaran/${data.bukti_pembayaran}`;
            buktiContainer.innerHTML = `
                <div class="mt-2">
                    <a href="${path}" target="_blank" class="inline-block mb-2 text-sm text-blue-600 hover:underline">Lihat bukti pembayaran</a>
                    <div><img src="${path}" alt="Bukti Pembayaran" class="h-40 object-contain border rounded" /></div>
                </div>
            `;
        } else {
            buktiContainer.innerHTML = '<div class="text-gray-600">Belum ada bukti pembayaran.</div>';
        }

        // Alamat / catatan / keterangan
        fragment.querySelector('.pesananAlamat').textContent = data.alamat || data.alamat_penerima || '-';
        fragment.querySelector('.pesananCatatan').textContent = data.catatan || '-';
        fragment.querySelector('.pesananKeterangan').textContent = data.keterangan || '-';

        // Form action - menggunakan route POST ke admin.pesanan.verifikasi
        if (form && data.id) {
            // Construct action URL using base path
            const baseUrl = window.location.origin;
            form.action = `${baseUrl}/admin/pesanan/verifikasi/${data.id}`;
            console.log('Form action set to:', form.action);
        }

        // Buttons
        const btnAccept = fragment.querySelector('.pesananVerifAccept');
        const btnReject = fragment.querySelector('.pesananVerifReject');
        const btnCancel = fragment.querySelector('.pesananVerifCancel');

        function submitWithStatus(status) {
            if (!form) return;
            statusInput.value = status;
            if (status === 'Ditolak') {
                if (!keteranganInput.value.trim()) {
                    alert('Mohon isi alasan penolakan.');
                    return;
                }
            }
            form.submit();
        }

        if (btnAccept) btnAccept.addEventListener('click', function() { submitWithStatus('Diterima'); });
        if (btnReject) btnReject.addEventListener('click', function() { submitWithStatus('Ditolak'); });
        if (btnCancel) btnCancel.addEventListener('click', function() { closeModal(modalEl, escHandler); });

        const escHandler = function(e) {
            if (e.key === 'Escape') {
                closeModal(modalEl, escHandler);
            }
        };
        document.addEventListener('keydown', escHandler);

        // Close button
        const closeBtn = fragment.querySelector('.pesananVerifClose');
        if (closeBtn) closeBtn.addEventListener('click', function() { closeModal(modalEl, escHandler); });

        // Remove any existing verifikasi modal then append fresh one
        document.querySelectorAll('.pesananVerifikasiModal').forEach(function(existing) {
            existing.remove();
        });

        // Append to body
        document.body.appendChild(fragment);
    }

    // Use event delegation so dynamically rendered buttons also work
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.verifikasiButton');
        if (!btn) return;
        e.preventDefault();
        e.stopPropagation();
        
        const id = btn.getAttribute('data-id');
        const url = btn.getAttribute('data-url');
        
        if (!id) {
            console.error('Button tidak memiliki data-id');
            return;
        }
        
        if (!url) {
            console.error('Button tidak memiliki data-url');
            return;
        }
        
        console.log('Verifikasi button clicked:', { id, url });
        console.log('Fetching from URL:', url);
        
        fetch(url)
            .then(function(res) {
                console.log('Response status:', res.status);
                console.log('Response headers:', res.headers);
                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }
                return res.json();
            })
            .then(function(data) {
                console.log('Data received successfully:', data);
                console.log('Data ID:', data.id);
                console.log('Data items:', data.items);
                console.log('Data status:', data.status);
                populateModal(data);
            })
            .catch(function(err) {
                console.error('Error fetching pesanan verifikasi:', err);
                console.error('Error message:', err.message);
                alert('Gagal memuat data verifikasi: ' + err.message);
            });
    });
})();
