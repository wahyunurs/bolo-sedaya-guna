// Admin Tarif Pengiriman - searchbar behavior (moved from blade)
(function(){
    function initSearch(){
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

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initSearch);
    else initSearch();
})();
