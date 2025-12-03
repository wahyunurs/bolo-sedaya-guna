document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modalTambahKeranjang');
    const btnOpen = document.getElementById('openTambahKeranjang') || document.querySelector('.btn-buka-modal');
    const btnCloseTop = document.getElementById('btnCloseModalTop');

    const inputJumlah = document.getElementById('jumlahInput');
    const subtotal = document.getElementById('subtotalText');
    const jumlahHidden = document.getElementById('jumlahHidden');

    function parsePriceFromText(text) {
        if (!text) return 0;
        const digits = text.replace(/[^0-9]/g, '');
        return parseInt(digits) || 0;
    }

    function formatRupiah(n) {
        return 'Rp ' + n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ',-';
    }

    let hargaProduk = 0;
    if (btnOpen && btnOpen.dataset && btnOpen.dataset.price) {
        hargaProduk = parseInt(btnOpen.dataset.price) || 0;
    }
    if (!hargaProduk) {
        const priceEl = document.querySelector('#modalTambahKeranjang .text-gray-600');
        if (priceEl) hargaProduk = parsePriceFromText(priceEl.textContent || '');
    }

    if (!modal) return;

    if (btnOpen) {
        btnOpen.addEventListener('click', function () {
            if (inputJumlah) inputJumlah.value = 1;
            if (subtotal) subtotal.textContent = formatRupiah(hargaProduk);
            if (jumlahHidden) jumlahHidden.value = inputJumlah ? inputJumlah.value : 1;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    if (btnCloseTop) {
        btnCloseTop.addEventListener('click', function () {
            closeModal();
            // hide server-rendered error message so it only appears once
            const modalError = document.getElementById('modalErrorMessage');
            if (modalError) modalError.classList.add('hidden');
        });
    }

    // close when clicking outside modal content (on overlay)
    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            closeModal();
            const modalError = document.getElementById('modalErrorMessage');
            if (modalError) modalError.classList.add('hidden');
        }
    });

    if (inputJumlah) {
        inputJumlah.addEventListener('input', function () {
            // sanitize: keep only digits
            var raw = (inputJumlah.value || '').toString().replace(/\D+/g, '');
            inputJumlah.value = raw;

            // For display/subtotal, treat empty as 1
            var q = parseInt(raw, 10);
            if (isNaN(q) || q < 1) q = 1;

            if (subtotal) subtotal.textContent = formatRupiah(hargaProduk * q);
            if (jumlahHidden) jumlahHidden.value = (raw === '' ? 1 : q);
        });

        // on blur ensure value is at least 1
        inputJumlah.addEventListener('blur', function () {
            if (!inputJumlah.value || inputJumlah.value.trim() === '') {
                inputJumlah.value = '1';
                if (subtotal) subtotal.textContent = formatRupiah(hargaProduk * 1);
                if (jumlahHidden) jumlahHidden.value = 1;
            }
        });
    }

    // decrease / increase buttons
    var btnDecrease = document.getElementById('btnDecrease');
    var btnIncrease = document.getElementById('btnIncrease');

    function changeQuantity(delta) {
        if (!inputJumlah) return;
        let q = parseInt(inputJumlah.value) || 1;
        q = q + delta;
        if (q < 1) q = 1;
        inputJumlah.value = q;
        if (subtotal) subtotal.textContent = formatRupiah(hargaProduk * q);
        if (jumlahHidden) jumlahHidden.value = q;
    }

    if (btnDecrease) btnDecrease.addEventListener('click', function () { changeQuantity(-1); });
    if (btnIncrease) btnIncrease.addEventListener('click', function () { changeQuantity(1); });

    const form = modal.querySelector('form');
    if (form && jumlahHidden) {
        form.addEventListener('submit', function () {
            jumlahHidden.value = inputJumlah ? inputJumlah.value : 1;
        });
    }
});