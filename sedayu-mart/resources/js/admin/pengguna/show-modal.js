// Initializes behavior for a pengguna show modal element.
// Call as: window.initPenggunaModal(modalElement)
(function(){
    window.initPenggunaModal = function(modal){
        if (!modal) modal = document.getElementById('penggunaShowModal');
        if (!modal) return;

        // avoid attaching twice
        if (modal.__penggunaInit) return;
        modal.__penggunaInit = true;

        function close(){
            modal.remove();
        }

        function onKey(e){ if (e.key === 'Escape') close(); }

        document.addEventListener('keydown', onKey);

        // close on overlay click
        modal.addEventListener('click', function(e){ if (e.target === modal) close(); });

        // bind any internal close buttons if present
        const closeBtn = modal.querySelector('[data-pengguna-close]');
        if (closeBtn) closeBtn.addEventListener('click', close);

        // cleanup when modal removed
        const observer = new MutationObserver(function(mutations){
            for (const m of mutations){
                for (const node of Array.from(m.removedNodes||[])){
                    if (node === modal){
                        document.removeEventListener('keydown', onKey);
                        observer.disconnect();
                        return;
                    }
                }
            }
        });
        observer.observe(document.body, { childList: true });
    };
})();
