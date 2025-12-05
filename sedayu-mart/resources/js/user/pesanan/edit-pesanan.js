document.addEventListener('DOMContentLoaded', function () {
    const kuantitasInput = document.getElementById('kuantitasInput');
    const hiddenHargaInput = document.getElementById('hiddenHargaPemesananInput');

    const harga = Number(hiddenHargaInput ? parseInt(hiddenHargaInput.value || 0) : 0);

    const produkSubtotalText = document.getElementById('produkSubtotalText');
    const subtotalText = document.getElementById('subtotalText');
    const totalBayarText = document.getElementById('totalBayarText');

    const tarifEl = document.getElementById('tarifPerKgInput');
    const beratEl = document.getElementById('beratGramInput');

    const tarifPerKgText = document.getElementById('tarifPerKgText');
    const beratTotalText = document.getElementById('beratTotalText');
    const ongkirText = document.getElementById('ongkirText');
    const ongkirInput = document.getElementById('ongkirInput');

    const hiddenKuantitas = document.getElementById('hiddenKuantitasInput');
    const hiddenSubtotal = document.getElementById('hiddenSubtotalInput');
    const hiddenTotalBeratGram = document.getElementById('totalBeratGramInput');
    const totalBayarHidden = document.getElementById('totalBayarHidden');

    function formatRupiah(x) {
        return 'Rp ' + Number(x).toLocaleString('id-ID') + ',-';
    }

    // Compute and sync visible + hidden fields
    function updateAll(qty) {
        try {
            qty = Math.max(1, parseInt(qty) || 1);
            if (kuantitasInput) kuantitasInput.value = qty;

            if (hiddenKuantitas) hiddenKuantitas.value = qty;

            // SUBTOTAL
            const unitPrice = Number(harga || 0);
            const subtotal = qty * unitPrice;
            if (hiddenSubtotal) hiddenSubtotal.value = subtotal;

            if (produkSubtotalText) produkSubtotalText.textContent = subtotal.toLocaleString('id-ID');
            if (subtotalText) subtotalText.textContent = formatRupiah(subtotal);

            // WEIGHT
            const perItemGram = parseInt((beratEl && beratEl.value) ? beratEl.value : 0) || 0;
            const totalGram = perItemGram * qty;
            if (hiddenTotalBeratGram) hiddenTotalBeratGram.value = totalGram;

            if (beratTotalText) beratTotalText.textContent = Number(totalGram / 1000).toLocaleString('id-ID', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }) + ' kg';

            // ONGKIR
            const tarif = parseInt((tarifEl && tarifEl.value) ? tarifEl.value : 0) || 0;
            const ongkir = Math.max(0, Math.round((totalGram / 1000) * tarif));

            if (ongkirInput) ongkirInput.value = ongkir;
            if (ongkirText) ongkirText.textContent = formatRupiah(ongkir);

            if (tarifPerKgText) tarifPerKgText.textContent = formatRupiah(tarif) + '/kg';

            // TOTAL BAYAR
            const totalBayar = subtotal + ongkir;
            if (totalBayarText) totalBayarText.textContent = formatRupiah(totalBayar);
            if (totalBayarHidden) totalBayarHidden.value = totalBayar;
        } catch (err) {
            console.error('updateAll error', err);
        }
    }

    // BUTTONS
    const decreaseBtn = document.getElementById('decreaseBtn');
    const increaseBtn = document.getElementById('increaseBtn');

    if (decreaseBtn) decreaseBtn.addEventListener('click', (e) => {
        e.preventDefault();
        const current = kuantitasInput ? parseInt(kuantitasInput.value || 0) : 1;
        updateAll(current - 1);
    });

    if (increaseBtn) increaseBtn.addEventListener('click', (e) => {
        e.preventDefault();
        const current = kuantitasInput ? parseInt(kuantitasInput.value || 0) : 1;
        updateAll(current + 1);
    });

    // INPUT EVENTS
    if (kuantitasInput) {
        ['input', 'change', 'keyup', 'paste'].forEach(evt => {
            kuantitasInput.addEventListener(evt, () => updateAll(kuantitasInput.value));
        });
    }

    // Ensure sync before submit. Do not prevent default submission.
    const checkoutForm = document.getElementById('checkoutForm');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', (e) => {
            try { updateAll(kuantitasInput ? kuantitasInput.value : 1); } catch (err) { console.error(err); }
            // allow normal form submission to proceed to server
        });

        // Additionally ensure clicking the submit button synchronizes fields
        const submitBtn = checkoutForm.querySelector('button[type="submit"], input[type="submit"]');
        if (submitBtn) {
            submitBtn.addEventListener('click', function () {
                try { updateAll(kuantitasInput ? kuantitasInput.value : 1); } catch (err) { console.error(err); }
                // do not call preventDefault; let browser submit the form
            });
        }
    }

    if (kuantitasInput) {
        updateAll(kuantitasInput ? kuantitasInput.value : 1);
    }

});
