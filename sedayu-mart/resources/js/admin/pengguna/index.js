// JS for Admin Pengguna page
(function(){
    function initShowButtons(){
        document.querySelectorAll('.showUserBtn').forEach(btn=>{
            if (btn.__showInit) return;
            btn.__showInit = true;

            btn.addEventListener('click', async function(e){
                e.preventDefault();
                const id = this.dataset.id;
                if (!id) return;

                // avoid duplicate modal
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
                    if (modal) {
                        document.body.appendChild(modal);
                        // initialize modal behavior if initializer available
                        if (window.initPenggunaModal && typeof window.initPenggunaModal === 'function') {
                            try { window.initPenggunaModal(modal); } catch (err) { console.error(err); }
                        }
                    }
                } catch (err) {
                    console.error('Error loading pengguna modal:', err);
                } finally {
                    this.removeAttribute('disabled');
                }
            });
        });
    }

    function initSearchFilter(){
        const form = document.getElementById('filterForm');
        const input = document.getElementById('searchInput');
        const clearBtn = document.getElementById('clearSearchBtn');
        if (!form || !input || !clearBtn) return;

        let timer = null;
        const DEBOUNCE = 500;

        function toggleClear(){
            if (input.value && input.value.trim().length) clearBtn.classList.remove('hidden');
            else clearBtn.classList.add('hidden');
        }

        input.addEventListener('input', function(){
            toggleClear();
            clearTimeout(timer);
            timer = setTimeout(function(){ form.submit(); }, DEBOUNCE);
        });

        clearBtn.addEventListener('click', function(){
            input.value = '';
            toggleClear();
            form.submit();
        });

        toggleClear();
    }

    // init
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', function(){ initShowButtons(); initSearchFilter(); });
    else { initShowButtons(); initSearchFilter(); }

})();
