// Create modal behavior for Tarif Pengiriman
(function() {
	function initCreateModal() {
		const createModal = document.getElementById('createModal');
		if (!createModal) return;
		const createModalOverlay = document.getElementById('createModalOverlay');
		const createModalClose = document.getElementById('createModalClose');
		const createModalCancel = document.getElementById('createModalCancel');
		const createButton = document.getElementById('createButton');
		const createForm = document.getElementById('createTarifForm');

		function openModal() {
			createModal.classList.remove('hidden');
			createModal.classList.add('flex');
			document.body.classList.add('overflow-hidden');
		}

		function closeModal() {
			createModal.classList.remove('flex');
			createModal.classList.add('hidden');
			document.body.classList.remove('overflow-hidden');
			if (createForm) createForm.reset();
		}

		if (createButton) {
			createButton.addEventListener('click', function() { openModal(); });
		}

		if (createModalOverlay) createModalOverlay.addEventListener('click', function() { closeModal(); });
		if (createModalClose) createModalClose.addEventListener('click', function() { closeModal(); });
		if (createModalCancel) createModalCancel.addEventListener('click', function() { closeModal(); });

		document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeModal(); });

		if (createForm) createForm.addEventListener('click', function(e) { e.stopPropagation(); });
	}

	if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initCreateModal);
	else initCreateModal();
})();
