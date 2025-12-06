// Update Status Modal Logic for Pesanan
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

    function closeModal(modalEl, escHandler) {
        if (modalEl && modalEl.parentElement) {
            modalEl.remove();
        }
        if (escHandler) {
            document.removeEventListener('keydown', escHandler);
        }
    }

    function populateModal(data) {
        const template = document.getElementById('pesananUpdateStatusModalTemplate');
        
        if (!template) {
            alert('Template modal tidak ditemukan');
            return;
        }
        
        if (!data || !data.id) {
            alert('Data pesanan tidak valid');
            return;
        }

        // Clone template content properly
        let fragment;
        if (template.content) {
            fragment = template.content.cloneNode(true);
        } else {
            fragment = template.cloneNode(true);
        }
        
        const modalEl = fragment.querySelector('.pesananUpdateStatusModal');
        
        if (!modalEl) {
            alert('Struktur modal tidak valid');
            return;
        }
        
        // Get form and inputs
        const form = fragment.querySelector('.pesananUpdateStatusForm');
        const statusInput = fragment.querySelector('.updateStatusInput');
        const itemsContainer = fragment.querySelector('.pesananItemsContainer');
        const buktiContainer = fragment.querySelector('.pesananBuktiContainer');

        // Populate items
        if (itemsContainer) {
            itemsContainer.innerHTML = '';
            if (Array.isArray(data.items) && data.items.length > 0) {
                data.items.forEach((item) => {
                    const produk = item.produk || {};
                    const gambar = produk.gambar_produks && produk.gambar_produks[0] ? produk.gambar_produks[0].gambar : null;
                    const imgPath = gambar ? `/storage/img/produk/${gambar}` : `/img/card/produk1.png`;
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
        }

        // Status badge
        const badge = fragment.querySelector('.pesananStatusBadge');
        if (badge) {
            badge.textContent = data.status || '-';
            badge.className = `pesananStatusBadge inline-block px-3 py-1 rounded-full text-xs ${statusClass(data.status)}`;
        }

        // Created date
        const created = fragment.querySelector('.pesananCreatedDate');
        if (created && data.created_at) {
            const d = new Date(data.created_at);
            created.textContent = d.toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
        }

        // Totals
        const ongkirEl = fragment.querySelector('.pesananOngkir');
        const subtotalEl = fragment.querySelector('.pesananSubtotal');
        const totalEl = fragment.querySelector('.pesananTotalBayar');
        
        if (ongkirEl) ongkirEl.textContent = `Rp ${numberFormat(data.ongkir)}`;
        if (subtotalEl) subtotalEl.textContent = `Rp ${numberFormat(data.subtotal_produk)}`;
        if (totalEl) totalEl.textContent = `Rp ${numberFormat(data.total_bayar)},-`;

        // Bukti pembayaran
        if (buktiContainer) {
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
        }

        // Alamat / catatan
        const alamatEl = fragment.querySelector('.pesananAlamat');
        const catatanEl = fragment.querySelector('.pesananCatatan');
        
        if (alamatEl) alamatEl.textContent = data.alamat || data.alamat_penerima || '-';
        if (catatanEl) catatanEl.textContent = data.catatan || '-';

        // Set form action URL
        if (form && data.id) {
            form.action = `/admin/pesanan/update-status/${data.id}`;
            form.method = 'POST';
        }

        // Button handlers
        const btnCancel = fragment.querySelector('.pesananUpdateStatusCancel');
        const btnSubmit = fragment.querySelector('.pesananUpdateStatusSubmit');
        const closeBtn = fragment.querySelector('.pesananUpdateStatusClose');
        const statusRadios = fragment.querySelectorAll('input[name="statusOption"]');

        function submitForm() {
            // Get the selected radio from all radios in the fragment
            let selectedStatus = null;
            statusRadios.forEach(radio => {
                if (radio.checked) {
                    selectedStatus = radio;
                }
            });

            if (!selectedStatus || !selectedStatus.value) {
                alert('Mohon pilih status baru terlebih dahulu.');
                return;
            }

            const statusValue = selectedStatus.value;
            console.log('Selected status:', statusValue);
            console.log('Status input element:', statusInput);
            console.log('Form:', form);
            
            if (statusInput) {
                statusInput.value = statusValue;
                console.log('Status input value set to:', statusInput.value);
            }
            
            // Submit form
            form.submit();
        }

        if (btnCancel) {
            btnCancel.addEventListener('click', function() {
                closeModal(modalEl, escHandler);
            });
        }

        if (btnSubmit) {
            btnSubmit.addEventListener('click', function(e) {
                e.preventDefault();
                submitForm();
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                closeModal(modalEl, escHandler);
            });
        }

        const escHandler = function(e) {
            if (e.key === 'Escape') {
                closeModal(modalEl, escHandler);
            }
        };
        document.addEventListener('keydown', escHandler);

        // Overlay click handler
        if (modalEl) {
            modalEl.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal(modalEl, escHandler);
                }
            });
        }

        // Clean up any existing modals
        document.querySelectorAll('.pesananUpdateStatusModal').forEach(function(existing) {
            if (existing !== modalEl) {
                existing.remove();
            }
        });

        // Append modal to body
        if (fragment.nodeType === 11) { // DocumentFragment
            document.body.appendChild(fragment);
        } else {
            document.body.appendChild(modalEl);
        }
    }

    // Event delegation for update status button clicks
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.updateStatusButton');
        if (!btn) return;
        
        e.preventDefault();
        e.stopPropagation();
        
        const id = btn.getAttribute('data-id');
        const url = btn.getAttribute('data-url');
        
        if (!id || !url) {
            alert('Tombol update status tidak dikonfigurasi dengan benar');
            return;
        }
        
        fetch(url)
            .then(function(res) {
                if (!res.ok) {
                    throw new Error(`HTTP ${res.status}`);
                }
                return res.json();
            })
            .then(function(data) {
                populateModal(data);
            })
            .catch(function(err) {
                alert('Gagal memuat data pesanan: ' + err.message);
            });
    });
})();
