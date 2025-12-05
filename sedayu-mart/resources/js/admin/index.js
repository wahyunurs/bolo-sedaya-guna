// Admin common JS: modal show for pengguna, search debounce, and dashboard chart
(function(){
	// --- Show pengguna modal ---
	function initShowButtons(){
		document.querySelectorAll('.showUserBtn').forEach(btn=>{
			if (btn.__showInit) return;
			btn.__showInit = true;

			btn.addEventListener('click', async function(e){
				e.preventDefault();
				const id = this.dataset.id;
				if (!id) return;

				// Prevent opening a second modal if one is already displayed
				if (document.getElementById('penggunaShowModal')) return;

				const url = new URL(`/admin/pengguna/${id}`, window.location.origin).toString();
				try {
					this.setAttribute('disabled', '');
					const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
					if (!res.ok) throw new Error('Network response was not ok');
					const html = await res.text();
					const wrapper = document.createElement('div');
					wrapper.innerHTML = html;
					const modal = wrapper.firstElementChild;
					if (modal) document.body.appendChild(modal);
				} catch (err) {
					console.error('Error fetching pengguna modal:', err);
				} finally {
					this.removeAttribute('disabled');
				}
			});
		});
	}

	// --- Search debounce & clear ---
	function initSearchFilter(){
		const form = document.getElementById('filterForm');
		const input = document.getElementById('searchInput');
		const clearBtn = document.getElementById('clearSearchBtn');
		if (!form || !input || !clearBtn) return;

		let timer = null;
		const DEBOUNCE = 500;

		function toggleClear() {
			if (input.value && input.value.trim().length) {
				clearBtn.classList.remove('hidden');
			} else {
				clearBtn.classList.add('hidden');
			}
		}

		input.addEventListener('input', function() {
			toggleClear();
			clearTimeout(timer);
			timer = setTimeout(function() { form.submit(); }, DEBOUNCE);
		});

		clearBtn.addEventListener('click', function() {
			input.value = '';
			toggleClear();
			form.submit();
		});

		// init
		toggleClear();
	}

	// --- Chart init (permintaanChart) ---
	function initPermintaanChart(){
		const diagramData = window.__diagramData || { labels: [], data: [] };
		const canvas = document.getElementById('permintaanChart');
		if (!canvas) return;

		function createChart(){
			if (typeof Chart === 'undefined') return;
			const ctx = canvas.getContext('2d');
			new Chart(ctx, {
				type: 'line',
				data: {
					labels: diagramData.labels,
					datasets: [{
						label: 'Total Pesanan',
						data: diagramData.data,
						borderColor: '#66BB6A',
						borderWidth: 2,
						tension: 0,
						fill: false
					}]
				},
				options: {
					responsive: true,
					maintainAspectRatio: false,
					plugins: {
						legend: { display: true, position: 'top' },
						tooltip: {
							callbacks: {
								label: function(context){
									const value = context.parsed.y;
									return `Total: ${value.toLocaleString()}`;
								}
							}
						}
					},
					scales: {
						x: { title: { display: true, text: 'Bulan' }, grid: { display: false } },
						y: { title: { display: true, text: 'Jumlah Pesanan' }, beginAtZero: true, grid: { display: false } }
					}
				}
			});
		}

		if (typeof Chart === 'undefined'){
			const interval = setInterval(function(){ if (typeof Chart !== 'undefined') { clearInterval(interval); createChart(); } }, 100);
		} else {
			createChart();
		}
	}

	// DOM ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function(){ initShowButtons(); initSearchFilter(); initPermintaanChart(); });
	} else {
		initShowButtons(); initSearchFilter(); initPermintaanChart();
	}

})();

