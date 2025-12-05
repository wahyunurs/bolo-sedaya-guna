// Inisialisasi behavior untuk modal produk yang di-inject via AJAX
(function () {
    // Helper that binds modal behavior for a given node
    function bindProdukModal(m) {
        if (!m) return;

        try { window.currentProdukId = m.dataset.id ? String(m.dataset.id) : null; } catch (e) { window.currentProdukId = null; }

        // Define close behavior
        const close = () => {
            if (m && m.parentNode) m.parentNode.removeChild(m);
            window.currentProdukId = null;
            document.removeEventListener('keydown', onKeyDown);
        };

        // Backdrop click
        m.addEventListener('click', function (ev) {
            if (ev.target === m) close();
        });

        // Close buttons
        const c = m.querySelector('#produkShowClose');
        const c2 = m.querySelector('#produkShowCloseBtn');
        if (c) c.addEventListener('click', close);
        if (c2) c2.addEventListener('click', close);

        // ESC key
        function onKeyDown(e) { if (e.key === 'Escape' || e.key === 'Esc') close(); }
        document.addEventListener('keydown', onKeyDown);
    }

    // Expose initializer so the AJAX inserter can call it after injecting the node
    if (!window.initProdukModal) {
        window.initProdukModal = function (node) {
            const m = node || document.getElementById('produkShowModal');
            bindProdukModal(m);
        };
    }

    // If modal is already present at script execution, bind it immediately
    const existing = document.getElementById('produkShowModal');
    if (existing) window.initProdukModal(existing);

})();
