// Pesanan index search and filter behavior
document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filterForm');
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const clearSearchBtn = document.getElementById('clearSearchBtn');

    if (!filterForm || !searchInput) return;

    // Show/hide clear button based on input value
    function updateClearVisibility() {
        if (!clearSearchBtn) return;
        if (searchInput.value && searchInput.value.trim() !== '') {
            clearSearchBtn.classList.remove('hidden');
        } else {
            clearSearchBtn.classList.add('hidden');
        }
    }

    updateClearVisibility();

    // Debounce timer for search
    let debounceTimeout = null;
    const DEBOUNCE_MS = 500;

    // Auto-submit on search input (debounced)
    searchInput.addEventListener('input', function() {
        updateClearVisibility();
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(function() {
            filterForm.submit();
        }, DEBOUNCE_MS);
    });

    // Submit immediately on Enter key
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            clearTimeout(debounceTimeout);
            filterForm.submit();
        }
    });

    // Auto-submit on status filter change
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            filterForm.submit();
        });
    }

    // Clear search and submit
    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', function() {
            searchInput.value = '';
            updateClearVisibility();
            clearTimeout(debounceTimeout);
            filterForm.submit();
        });
    }
});
