document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById('modalProductQuick');
            var modalClose = document.getElementById('modalProductClose');
            var modalImg = document.getElementById('modalProductImg');
            var modalName = document.getElementById('modalProductName');
            var modalPrice = document.getElementById('modalProductPrice');
            var modalJumlah = document.getElementById('modalJumlahInput');
            var modalSubtotal = document.getElementById('modalSubtotalText');
            var modalDecrease = document.getElementById('modalDecrease');
            var modalIncrease = document.getElementById('modalIncrease');

            var formTambahProdukId = document.getElementById('formTambahProdukId');
            var formTambahJumlah = document.getElementById('formTambahJumlah');
            var formBeliProdukId = document.getElementById('formBeliProdukId');
            var formBeliKuantitas = document.getElementById('formBeliKuantitas');

            function formatRupiah(n) {
                return 'Rp ' + (n || 0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function openModalFor(button) {
                var id = button.dataset.id || '';
                var price = parseInt(button.dataset.price) || 0;
                var name = button.dataset.name || '';
                var img = button.dataset.img || '';

                modalImg.src = img;
                modalName.textContent = name;
                modalPrice.textContent = formatRupiah(price);
                modalJumlah.value = '1';
                modalSubtotal.textContent = formatRupiah(price);

                // set hidden fields
                if (formTambahProdukId) formTambahProdukId.value = id;
                if (formTambahJumlah) formTambahJumlah.value = 1;
                if (formBeliProdukId) formBeliProdukId.value = id;
                if (formBeliKuantitas) formBeliKuantitas.value = 1;

                // store price on modal element for calculations
                modal.dataset.price = price;

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            document.querySelectorAll('.show-modal-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    openModalFor(btn);
                });
            });

            function closeModal() {
                if (!modal) return;
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            if (modalClose) modalClose.addEventListener('click', closeModal);
            if (modal) modal.addEventListener('click', function(e) {
                if (e.target === modal) closeModal();
            });

            function updateSubtotal() {
                var price = parseInt(modal.dataset.price) || 0;
                var qty = parseInt((modalJumlah && modalJumlah.value) || 0) || 1;
                if (qty < 1) qty = 1;
                modalSubtotal.textContent = formatRupiah(price * qty);
                if (formTambahJumlah) formTambahJumlah.value = qty;
                if (formBeliKuantitas) formBeliKuantitas.value = qty;
            }

            if (modalDecrease) modalDecrease.addEventListener('click', function() {
                var q = parseInt(modalJumlah.value) || 1;
                q = Math.max(1, q - 1);
                modalJumlah.value = q;
                updateSubtotal();
            });
            if (modalIncrease) modalIncrease.addEventListener('click', function() {
                var q = parseInt(modalJumlah.value) || 1;
                q = q + 1;
                modalJumlah.value = q;
                updateSubtotal();
            });

            if (modalJumlah) {
                modalJumlah.addEventListener('input', function() {
                    modalJumlah.value = modalJumlah.value.replace(/\D+/g, '') || '1';
                    updateSubtotal();
                });
                modalJumlah.addEventListener('blur', updateSubtotal);
            }
        });