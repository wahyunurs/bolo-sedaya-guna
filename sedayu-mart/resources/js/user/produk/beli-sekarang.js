document.addEventListener("DOMContentLoaded", function () {

    const btnOpenModal = document.getElementById("openBeliSekarang");
    const modal = document.getElementById("modalBeliSekarang");
    const btnCloseModal = document.getElementById("btnCloseModalBeli");

    const btnPlus = document.getElementById("btnIncreaseBeli");
    const btnMinus = document.getElementById("btnDecreaseBeli");
    const inputQty = document.getElementById("kuantitasInputBeli");
    const subtotalText = document.getElementById("subtotalTextBeli");

    const btnCheckout = document.getElementById("btnCheckoutBeliSekarang");

    if (!modal) return;

    const hargaProduk = parseInt(modal.dataset.price);
    const checkoutRoute = modal.dataset.checkoutRoute;
    const produkId = modal.dataset.produkId;

    // ========= SHOW MODAL =========
    btnOpenModal?.addEventListener("click", () => {
        modal.classList.remove("hidden");
        modal.classList.add("flex");
    });

    // ========= CLOSE MODAL =========
    btnCloseModal?.addEventListener("click", () => {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
    });

    // ========= UPDATE SUBTOTAL =========
    function updateSubtotal() {
        let qty = parseInt(inputQty.value) || 1;
        if (qty < 1) qty = 1;

        const subtotal = hargaProduk * qty;
        subtotalText.textContent = "Rp " + subtotal.toLocaleString("id-ID");

        // Update tombol checkout agar kirim data benar
        btnCheckout.href = `${checkoutRoute}?produk_id=${produkId}&kuantitas=${qty}`;
    }

    // ========= BUTTON + =========
    btnPlus?.addEventListener("click", () => {
        inputQty.value = parseInt(inputQty.value || 1) + 1;
        updateSubtotal();
    });

    // ========= BUTTON - =========
    btnMinus?.addEventListener("click", () => {
        let qty = parseInt(inputQty.value || 1);
        if (qty > 1) qty--;
        inputQty.value = qty;
        updateSubtotal();
    });

    // ========= MANUAL INPUT =========
    inputQty?.addEventListener("input", () => updateSubtotal());

    // Set awal
    updateSubtotal();
});
