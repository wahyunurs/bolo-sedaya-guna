// Preview selected images for the 5 upload boxes
document.addEventListener('DOMContentLoaded', function () {
	function togglePreview(idx, fileUrl) {
		const preview = document.getElementById('preview-' + idx);
		const placeholder = document.getElementById('placeholder-' + idx);
		if (!preview || !placeholder) return;

		if (fileUrl) {
			preview.src = fileUrl;
			preview.classList.remove('hidden');
			placeholder.classList.add('hidden');
		} else {
			preview.src = '';
			preview.classList.add('hidden');
			placeholder.classList.remove('hidden');
		}
	}

	function onFileChange(e) {
		const input = e.currentTarget;
		const idx = input.dataset.index;
		const file = input.files && input.files[0];
		if (file) {
			togglePreview(idx, URL.createObjectURL(file));
		} else {
			togglePreview(idx, '');
		}
	}

	document.querySelectorAll('.gambar-input').forEach(function (inp) {
		inp.addEventListener('change', onFileChange);
	});
});
