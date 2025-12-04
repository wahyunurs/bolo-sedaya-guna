document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('searchForm');
            var input = document.getElementById('searchInput');
            var clearBtn = document.getElementById('clearSearchBtn');
            if (!form || !input) return;

            // show clear button if input has value on load
            function updateClearVisibility() {
                if (!clearBtn) return;
                if (input.value && input.value.trim() !== '') {
                    clearBtn.classList.remove('hidden');
                } else {
                    clearBtn.classList.add('hidden');
                }
            }

            updateClearVisibility();

            var debounceTimeout = null;
            var DEBOUNCE_MS = 500;

            input.addEventListener('input', function() {
                updateClearVisibility();
                clearTimeout(debounceTimeout);
                debounceTimeout = setTimeout(function() {
                    form.submit();
                }, DEBOUNCE_MS);
            });

            // submit immediately on Enter
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    clearTimeout(debounceTimeout);
                    form.submit();
                }
            });

            if (clearBtn) {
                clearBtn.addEventListener('click', function() {
                    input.value = '';
                    updateClearVisibility();
                    clearTimeout(debounceTimeout);

                    // Build a URL without the 'search' query parameter and navigate there
                    var url = new URL(window.location.href);
                    url.searchParams.delete('search');
                    // Also remove empty search param if present
                    // Preserve other query params if any
                    var newUrl = url.pathname + (url.search ? url.search : '');
                    // navigate to the cleaned URL
                    window.location.href = newUrl;
                });
            }
        });

// Modal close handlers: close modal when clicking the top close button,
// the cancel button, clicking outside the modal content, or pressing Escape.
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('bulkDeleteModal');
    var btnCloseTop = document.getElementById('btnCloseModalTop');
    var bulkDeleteCancel = document.getElementById('bulkDeleteCancel');

    function hideModal() {
        try {
            if (!modal) return;
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        } catch (e) {
            // silent
        }
    }

    if (btnCloseTop) {
        btnCloseTop.addEventListener('click', function() {
            hideModal();
        });
    }

    if (bulkDeleteCancel) {
        bulkDeleteCancel.addEventListener('click', function() {
            hideModal();
        });
    }

    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                hideModal();
            }
        });
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' || e.key === 'Esc') {
            hideModal();
        }
    });
});