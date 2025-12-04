document.addEventListener('DOMContentLoaded', function() {
    // SEARCH: debounce + clear button
    var form = document.getElementById('searchForm');
    var input = document.getElementById('searchInput');
    var clearBtn = document.getElementById('clearSearchBtn');
    if (form && input) {
        function updateClearVisibility() {
            if (!clearBtn) return;
            if (input.value && input.value.trim() !== '') clearBtn.classList.remove('hidden');
            else clearBtn.classList.add('hidden');
        }

        updateClearVisibility();

        var debounceTimeout = null;
        var DEBOUNCE_MS = 500;

        input.addEventListener('input', function() {
            updateClearVisibility();
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(function() { form.submit(); }, DEBOUNCE_MS);
        });

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') { e.preventDefault(); clearTimeout(debounceTimeout); form.submit(); }
        });

        if (clearBtn) {
            clearBtn.addEventListener('click', function() {
                input.value = '';
                updateClearVisibility();
                clearTimeout(debounceTimeout);
                var url = new URL(window.location.href);
                url.searchParams.delete('search');
                window.location.href = url.pathname + (url.search ? url.search : '');
            });
        }
    }

    // Additional cart page behavior: bulk delete modal, checkout redirect, and quantity updates
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

    // Bulk delete & modal handlers
    (function() {
        const openBtn = document.getElementById('openBulkDeleteModalBtn');
        const modal = document.getElementById('bulkDeleteModal');
        const cancelBtn = document.getElementById('bulkDeleteCancel');
        const confirmBtn = document.getElementById('bulkDeleteConfirm');
        const countEl = document.getElementById('bulkDeleteCount');
        const formEl = document.getElementById('bulkDeleteForm');

        function getCheckedIds() { return Array.from(document.querySelectorAll('input.bulk-check:checked')).map(i => i.value); }
        function showModal(count) { if (!modal) return; if (countEl) countEl.textContent = count; modal.classList.remove('hidden'); modal.classList.add('flex'); }
        function hideModal() { if (!modal) return; modal.classList.remove('flex'); modal.classList.add('hidden'); }

        if (openBtn) {
            openBtn.addEventListener('click', function() {
                const checked = getCheckedIds();
                if (!checked || checked.length === 0) { alert('Pilih minimal satu item yang ingin dihapus.'); return; }
                showModal(checked.length);
            });
        }

        const singleButtons = document.querySelectorAll('.single-delete-btn');
        const singleForm = document.getElementById('singleDeleteForm');
        const deleteBase = '/user/keranjang/destroy';
        if (singleButtons && singleButtons.length) {
            singleButtons.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const id = btn.dataset.id; if (!id) return;
                    if (modal) modal.dataset.mode = 'single'; if (countEl) countEl.textContent = '1'; showModal(1);
                    if (singleForm) singleForm.action = deleteBase + '/' + id;
                });
            });
        }

        if (cancelBtn) cancelBtn.addEventListener('click', hideModal);
        if (confirmBtn) {
            confirmBtn.addEventListener('click', function() {
                if (modal && modal.dataset.mode === 'single') { if (singleForm) singleForm.submit(); return; }
                const checked = getCheckedIds(); if (!checked || checked.length === 0) { alert('Pilih minimal satu item yang ingin dihapus.'); hideModal(); return; }
                if (formEl) formEl.submit();
            });
        }
    })();

    // Checkout button: create plain form and submit to server so it renders checkout
    (function() {
        const checkoutUrl = '/user/keranjang/checkout';
        document.querySelectorAll('input.bulk-check').forEach(function(chk) {
            let item = chk.closest('.bg-white'); if (!item) return;
            const cartBtn = item.querySelector('button.p-2.rounded-lg.text-green-700'); if (!cartBtn) return;
            cartBtn.addEventListener('click', function(e) {
                e.preventDefault(); const keranjangId = chk.value; if (!keranjangId) return;
                const form = document.createElement('form'); form.method = 'POST'; form.action = checkoutUrl; form.style.display = 'none';
                const csrf = document.createElement('input'); csrf.type = 'hidden'; csrf.name = '_token'; csrf.value = csrfToken; form.appendChild(csrf);
                const input = document.createElement('input'); input.type = 'hidden'; input.name = 'keranjang_id'; input.value = keranjangId; form.appendChild(input);
                document.body.appendChild(form); form.submit();
            });
        });
    })();

    // Quantity controls and update via AJAX
    (function() {
        const updateUrl = '/user/keranjang/update';
        function formatRupiah(number) { return new Intl.NumberFormat('id-ID').format(number); }
        function setSubtotalUI(id, amount) { const el = document.querySelector('.subtotalText[data-id="' + id + '"]'); if (el) el.textContent = 'Rp ' + formatRupiah(amount) + ',-'; const hidden = document.getElementById('hiddenSubtotal-' + id); if (hidden) hidden.value = amount; }
        function sendUpdate(keranjangId, kuantitas, button) {
            if (button) button.disabled = true;
            fetch(updateUrl, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/x-www-form-urlencoded', 'Accept': 'application/json' }, body: new URLSearchParams({ keranjang_id: keranjangId, kuantitas: kuantitas }), credentials: 'same-origin' })
            .then(function(res) { return res.json(); }).then(function(data) { if (button) button.disabled = false; if (!data || !data.success) { alert(data && data.message ? data.message : 'Gagal memperbarui keranjang.'); return; } setSubtotalUI(keranjangId, data.subtotal); }).catch(function(err) { if (button) button.disabled = false; alert('Terjadi kesalahan saat memperbarui keranjang. Coba lagi.'); console.error(err); });
        }

        document.querySelectorAll('.decreaseBtn').forEach(function(btn) { btn.addEventListener('click', function() { const id = btn.dataset.id; const input = document.querySelector('.kuantitasInput[data-id="' + id + '"]'); if (!input) return; let val = parseInt(input.value) || 0; if (val <= 1) return; val -= 1; input.value = val; sendUpdate(id, val, btn); }); });

        document.querySelectorAll('.increaseBtn').forEach(function(btn) { btn.addEventListener('click', function() { const id = btn.dataset.id; const input = document.querySelector('.kuantitasInput[data-id="' + id + '"]'); if (!input) return; let val = parseInt(input.value) || 0; val += 1; input.value = val; sendUpdate(id, val, btn); }); });

        let timers = {};
        document.querySelectorAll('.kuantitasInput').forEach(function(input) {
            input.addEventListener('input', function() {
                const id = input.dataset.id; let val = parseInt(input.value.replace(/[^0-9]/g, '')) || 0; if (val < 1) val = 1; input.value = val;
                if (timers[id]) clearTimeout(timers[id]); timers[id] = setTimeout(function() { sendUpdate(id, val, null); }, 600);
            });
        });
    })();

});