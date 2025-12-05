// Edit modal behavior for Rekening
(function() {
    function initEditModal() {
        const editModal = document.getElementById('editModal');
        if (!editModal) return;
        const editModalOverlay = document.getElementById('editModalOverlay');
        const editModalClose = document.getElementById('editModalClose');
        const editModalCancel = document.getElementById('editModalCancel');
        const editForm = document.getElementById('editRekeningForm');

        function openModal() {
            editModal.classList.remove('hidden');
            editModal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closeModal() {
            editModal.classList.remove('flex');
            editModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            if (editForm) editForm.reset();
        }

        // attach close handlers
        if (editModalOverlay) editModalOverlay.addEventListener('click', closeModal);
        if (editModalClose) editModalClose.addEventListener('click', closeModal);
        if (editModalCancel) editModalCancel.addEventListener('click', closeModal);
        document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeModal(); });

        // prevent clicks inside content from bubbling
        const modalContent = editModal.querySelector('.relative');
        if (modalContent) modalContent.addEventListener('click', function(e) { e.stopPropagation(); });

        // Attach edit button listeners (delegation)
        document.querySelectorAll('.editButton').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const id = btn.getAttribute('data-id');
                if (!id) return;

                fetch(`/admin/rekening/edit/${id}`)
                    .then(function(res) { return res.json(); })
                    .then(function(data) {
                        // populate fields
                        const namaBank = document.getElementById('edit_nama_bank');
                        const nomorRek = document.getElementById('edit_nomor_rekening');
                        const atasNama = document.getElementById('edit_atas_nama');

                        if (namaBank) namaBank.value = data.nama_bank || '';
                        if (nomorRek) nomorRek.value = data.nomor_rekening || '';
                        if (atasNama) atasNama.value = data.atas_nama || '';

                        // set form action
                        if (editForm) editForm.action = `/admin/rekening/update/${id}`;

                        openModal();
                    })
                    .catch(function(err) { console.error('Error fetching rekening:', err); });
            });
        });
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initEditModal);
    else initEditModal();
})();
