// Admin Produk - show modal via AJAX
import './show-modal';

(function () {
    async function fetchAndShowProdukModal(id, triggerBtn) {
        if (!id) return;
        // prevent duplicate
        if (document.getElementById('produkShowModal')) return;
        triggerBtn = triggerBtn || null;
        if (triggerBtn) triggerBtn.setAttribute('disabled', '');

        try {
            const url = new URL(`/admin/produk/show/${id}`, window.location.origin).toString();
            const res = await fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' },
                credentials: 'same-origin',
            });

            const text = await res.text();
            if (!res.ok) {
                console.error('Failed to load produk modal', res.status, text);
                return;
            }

            const wrapper = document.createElement('div');
            wrapper.innerHTML = text;
            const modal = wrapper.querySelector('#produkShowModal') || wrapper.firstElementChild;
            if (!modal) {
                console.warn('Modal not found in response', text);
                return;
            }

            const imported = document.importNode(modal, true);
            document.body.appendChild(imported);

            // initialize modal behavior if available
            if (window.initProdukModal && typeof window.initProdukModal === 'function') {
                try { window.initProdukModal(imported); } catch (err) { console.error(err); }
            } else {
                // simple fallback: close on backdrop click or ESC
                const esc = (e) => { if (e.key === 'Escape') imported.remove(); };
                imported.addEventListener('click', function (ev) { if (ev.target === imported) imported.remove(); });
                const btnClose = imported.querySelector('#produkShowClose'); if (btnClose) btnClose.addEventListener('click', () => imported.remove());
                document.addEventListener('keydown', esc, { once: true });
            }

        } catch (err) {
            console.error('Error fetching produk modal:', err);
        } finally {
            if (triggerBtn) triggerBtn.removeAttribute('disabled');
        }
    }

    // Delegated click handler for .showProdukBtn
    document.addEventListener('click', function (e) {
        const btn = e.target.closest && e.target.closest('.showProdukBtn');
        if (!btn) return;
        const id = btn.getAttribute('data-id') || btn.dataset.id;
        fetchAndShowProdukModal(id, btn);
    });

})();
