// Edit modal behavior for Tarif Pengiriman
(function() {
	function initEditModal() {
		const editModal = document.getElementById('editModal');
		if (!editModal) return;
		const editModalOverlay = document.getElementById('editModalOverlay');
		const editModalClose = document.getElementById('editModalClose');
		const editModalCancel = document.getElementById('editModalCancel');
		const editTarifForm = document.getElementById('editTarifForm');
		const baseUrl = editModal.dataset.baseUrl || '/admin/tarif-pengiriman';

		function openModal() {
			editModal.classList.remove('hidden');
			editModal.classList.add('flex');
			document.body.classList.add('overflow-hidden');
		}

		function closeModal() {
			editModal.classList.remove('flex');
			editModal.classList.add('hidden');
			document.body.classList.remove('overflow-hidden');
		}

		if (editModalOverlay) editModalOverlay.addEventListener('click', closeModal);
		if (editModalClose) editModalClose.addEventListener('click', closeModal);
		if (editModalCancel) editModalCancel.addEventListener('click', closeModal);

		document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeModal(); });

		if (editTarifForm) editTarifForm.addEventListener('click', function(e) { e.stopPropagation(); });

		// delegation to handle edit button clicks
		document.addEventListener('click', function(e) {
			const btn = e.target.closest('.editButton');
			if (!btn) return;
			const id = btn.dataset.id;
			const kabupaten = btn.dataset.kabupaten || '';
			const tarif = btn.dataset.tarif || '';

			// fill form
			const idInput = document.getElementById('edit_tarif_id');
			const kabInput = document.getElementById('edit_kabupaten');
			const tarifInput = document.getElementById('edit_tarif_per_kg');
			if (idInput) idInput.value = id;
			if (kabInput) kabInput.value = kabupaten;
			if (tarifInput) tarifInput.value = tarif;

			if (editTarifForm) editTarifForm.action = baseUrl + '/update/' + id;

			openModal();
		});
	}

	if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initEditModal);
	else initEditModal();
})();

