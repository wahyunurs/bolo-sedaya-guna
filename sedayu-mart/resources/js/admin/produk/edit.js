// Edit page: image preview, delete-slot handling and tombol visibility
(function() {
	function onFileChange(e) {
		const input = e.currentTarget;
		const idx = input.dataset.index;
		const preview = document.getElementById('preview-' + idx);
		if (!preview) return;
		const file = input.files && input.files[0];
		if (file) {
			preview.src = URL.createObjectURL(file);
		} else {
			// restore to captured default for this slot
			if (window.defaultPreviewSrcs && window.defaultPreviewSrcs.hasOwnProperty(idx)) {
				preview.src = window.defaultPreviewSrcs[idx];
			}
		}
	}

	document.addEventListener('DOMContentLoaded', function() {
		// capture default preview src for each slot so we can restore it later
		window.defaultPreviewSrcs = {};
		document.querySelectorAll('.slot-item').forEach(function(slotDiv) {
			const idx = slotDiv.dataset.slot;
			const preview = document.getElementById('preview-' + idx);
			if (preview) window.defaultPreviewSrcs[idx] = preview.src;
		});

		// wire change handlers for file inputs
		document.querySelectorAll('.gambar-input').forEach(function(inp) {
			inp.addEventListener('change', function(e) {
				onFileChange(e);

				// show/hide delete button depending on whether a file is selected
				const idx = e.currentTarget.dataset.index;
				const btn = document.querySelector('.hapus-slot[data-slot="' + idx + '"]');
				if (btn) {
					const file = e.currentTarget.files && e.currentTarget.files[0];
					if (file) {
						btn.classList.remove('hidden');
					} else {
						const exist = document.getElementById('slot_existing_id_' + idx);
						if (!exist || !exist.value) btn.classList.add('hidden');
					}
				}
			});
		});

		// initialize delete button visibility for each slot
		document.querySelectorAll('.slot-item').forEach(function(slotDiv) {
			const idx = slotDiv.dataset.slot;
			const exist = document.getElementById('slot_existing_id_' + idx);
			const btn = slotDiv.querySelector('.hapus-slot');
			if (btn) {
				if (exist && exist.value) {
					btn.classList.remove('hidden');
				} else {
					btn.classList.add('hidden');
				}
			}
		});

		// handle delete slot clicks
		document.querySelectorAll('.hapus-slot').forEach(function(btn) {
			btn.addEventListener('click', function(ev) {
				const slot = btn.dataset.slot;
				// mark delete flag for slot
				const del = document.getElementById('delete_slot_' + slot);
				if (del) del.value = '1';
				// read existing id, then remove existing id mapping so it's not submitted
				const exist = document.getElementById('slot_existing_id_' + slot);
				const existingId = exist ? exist.value : '';
				if (exist) exist.remove();
				// hide this delete button
				btn.classList.add('hidden');
				// also clear file input for this slot if any
				const fileInput = document.querySelector('input.gambar-input[data-index="' + slot + '"]');
				if (fileInput) {
					fileInput.value = '';
				}
				// reset preview to captured default
				const preview = document.getElementById('preview-' + slot);
				if (preview) {
					if (window.defaultPreviewSrcs && window.defaultPreviewSrcs.hasOwnProperty(slot)) {
						preview.src = window.defaultPreviewSrcs[slot];
					} else {
						preview.src = '';
					}
				}
				// if utama radio pointed to this existing, clear it and set to 'new_{i}'
				if (existingId) {
					const radio = document.querySelector('input[name="utama_gambar"][value="existing_' + existingId + '"]');
					if (radio) {
						if (radio.checked) radio.checked = false;
						radio.value = 'new_' + slot;
					}
				}
			});
		});
	});
})();
