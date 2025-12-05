// Preview selected images for the 5 upload boxes (moved from inline Blade)
document.addEventListener('DOMContentLoaded', function () {
	// capture default src for each preview image so we can restore it when input cleared
	const defaults = {};
	document.querySelectorAll('[id^="preview-"]').forEach(function (img) {
		if (img && img.id) defaults[img.id] = img.src;
	});

	function onFileChange(e) {
		const input = e.currentTarget;
		const idx = input.dataset.index;
		const preview = document.getElementById('preview-' + idx);
		if (!preview) return;
		const file = input.files && input.files[0];
		if (file) {
			preview.src = URL.createObjectURL(file);
		} else {
			const def = defaults['preview-' + idx] || '';
			preview.src = def;
		}
	}

	document.querySelectorAll('.gambar-input').forEach(function (inp) {
		inp.addEventListener('change', onFileChange);
	});
});
