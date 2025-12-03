
document.addEventListener('DOMContentLoaded', function () {
	var modal = document.getElementById('modalEditAlamat');
	if (!modal) return;

	var closeBtn = document.getElementById('btnCloseModalTop');

	function closeModal() {
		modal.classList.add('hidden');
		modal.classList.remove('flex');
	}

	if (closeBtn) {
		closeBtn.addEventListener('click', function () {
			closeModal();
		});
	}

	// close when clicking overlay
	modal.addEventListener('click', function (e) {
		if (e.target === modal) {
			closeModal();
		}
	});

	// Searchable dropdown
	var search = document.getElementById('kabupatenTujuanSearch');
	var hidden = document.getElementById('kabupatenTujuanHidden');
	var list = document.getElementById('kabupatenTujuanList');

	if (!search || !hidden || !list) return;

	function showList() { list.classList.remove('hidden'); }
	function hideList() { list.classList.add('hidden'); }

	search.addEventListener('input', function () {
		var q = (search.value || '').toLowerCase().trim();
		var items = list.querySelectorAll('li');
		var any = false;
		items.forEach(function (li) {
			// skip informational items that don't have data-value
			var v = (li.dataset.value || '').toLowerCase();
			var match = v.indexOf(q) !== -1;
			li.style.display = match ? '' : 'none';
			if (match) any = true;
		});
		if (any) showList(); else hideList();
	});

	list.addEventListener('click', function (e) {
		var li = e.target.closest('li');
		if (!li) return;
		var value = li.dataset.value || li.textContent.trim();
		hidden.value = value;
		search.value = value;
		hideList();
	});

	// prefill selection if hidden has value
	if (hidden.value) search.value = hidden.value;

	// hide on outside click
	document.addEventListener('click', function (e) {
		if (!list.contains(e.target) && e.target !== search) hideList();
	});

	// ensure hidden gets value before submit (in case user typed but didn't select)
	var form = modal.querySelector('form');
	if (form) {
		form.addEventListener('submit', function () {
			if (hidden && (!hidden.value || hidden.value.trim() === '')) {
				hidden.value = search.value || '';
			}
		});
	}
});
