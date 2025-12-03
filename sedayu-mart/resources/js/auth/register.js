document.addEventListener('DOMContentLoaded', () => {
    // ----------------------------
    // Toast auto-hide (top-right)
    // ----------------------------
    (function () {
        const toast = document.getElementById('toast-error');
        const closeBtn = document.getElementById('toastClose');
        if (!toast) return;

        const hideToast = () => {
            toast.classList.add('opacity-0', 'translate-x-2');
            setTimeout(() => toast.remove(), 300);
        };

        const timer = setTimeout(hideToast, 5000);
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                clearTimeout(timer);
                hideToast();
            });
        }
    })();

    // ----------------------------
    // Password toggle
    // ----------------------------
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    const eyeIcon = document.getElementById('eyeIcon');
    const eyeClosedIcon = document.getElementById('eyeClosedIcon');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', () => {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            if (eyeIcon) eyeIcon.classList.toggle('hidden');
            if (eyeClosedIcon) eyeClosedIcon.classList.toggle('hidden');
        });
    }

    // ----------------------------
    // Icon color handling for inputs
    // ----------------------------
    const iconFields = [
        { inputId: 'nama', wrapId: 'nameIconWrap' },
        { inputId: 'email', wrapId: 'emailIconWrap' },
        { inputId: 'alamat', wrapId: 'alamatIconWrap' },
        { inputId: 'nomor_telepon', wrapId: 'nomorTeleponIconWrap' },
        { inputId: 'password', wrapId: 'passwordIconWrap' }
    ];

    iconFields.forEach(({ inputId, wrapId }) => {
        const input = document.getElementById(inputId);
        const wrap = document.getElementById(wrapId);
        if (!input || !wrap) return;

        wrap.classList.add('transition-colors', 'duration-150');

        const update = () => {
            const active = (document.activeElement === input || input.value.trim() !== '');

            if (active) {
                wrap.classList.remove('text-gray-400');
                wrap.classList.add('text-green-500');
                if (wrapId === 'passwordIconWrap') {
                    if (eyeIcon) {
                        eyeIcon.classList.remove('text-gray-400');
                        eyeIcon.classList.add('text-green-500');
                    }
                    if (eyeClosedIcon) {
                        eyeClosedIcon.classList.remove('text-gray-400');
                        eyeClosedIcon.classList.add('text-green-500');
                    }
                }
            } else {
                wrap.classList.remove('text-green-500');
                wrap.classList.add('text-gray-400');
                if (wrapId === 'passwordIconWrap') {
                    if (eyeIcon) {
                        eyeIcon.classList.remove('text-green-500');
                        eyeIcon.classList.add('text-gray-400');
                    }
                    if (eyeClosedIcon) {
                        eyeClosedIcon.classList.remove('text-green-500');
                        eyeClosedIcon.classList.add('text-gray-400');
                    }
                }
            }
        };

        ['focus', 'blur', 'input', 'change'].forEach(evt => input.addEventListener(evt, update));
        update();
    });

    // ----------------------------
    // Kabupaten search dropdown
    // ----------------------------
    const search = document.getElementById('kabupatenSearch');
    const hidden = document.getElementById('kabupaten');
    const list = document.getElementById('kabupatenList');
    if (search && hidden && list) {
        const items = Array.from(list.querySelectorAll('li'));

        if (hidden.value) search.value = hidden.value;

        const openList = () => list.classList.remove('hidden');
        const closeList = () => list.classList.add('hidden');

        search.addEventListener('focus', () => {
            items.forEach(li => (li.style.display = ''));
            openList();
        });

        search.addEventListener('input', () => {
            const q = search.value.trim().toLowerCase();
            let any = false;
            items.forEach(li => {
                const txt = li.textContent.trim().toLowerCase();
                const visible = txt.indexOf(q) !== -1;
                li.style.display = visible ? '' : 'none';
                if (visible) any = true;
                li.classList.remove('bg-green-500', 'text-white');
            });
            if (any) openList();
            else closeList();
        });

        items.forEach(li => {
            li.addEventListener('click', () => {
                const v = li.getAttribute('data-value');
                hidden.value = v;
                search.value = v;
                closeList();
            });
            li.addEventListener('mouseenter', () => {
                items.forEach(i => i.classList.remove('bg-green-500', 'text-white'));
                li.classList.add('bg-green-500', 'text-white');
            });
        });

        document.addEventListener('click', e => {
            if (!e.target.closest('#kabupatenList') && !e.target.closest('#kabupatenSearch')) closeList();
        });

        // keyboard navigation
        let focusedIndex = -1;
        search.addEventListener('keydown', e => {
            const visible = items.filter(li => li.style.display !== 'none');
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                focusedIndex = Math.min(focusedIndex + 1, visible.length - 1);
                visible.forEach((li, i) => {
                    li.classList.toggle('bg-green-500', i === focusedIndex);
                    li.classList.toggle('text-white', i === focusedIndex);
                });
                if (visible[focusedIndex]) visible[focusedIndex].scrollIntoView({ block: 'nearest' });
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                focusedIndex = Math.max(focusedIndex - 1, 0);
                visible.forEach((li, i) => {
                    li.classList.toggle('bg-green-500', i === focusedIndex);
                    li.classList.toggle('text-white', i === focusedIndex);
                });
                if (visible[focusedIndex]) visible[focusedIndex].scrollIntoView({ block: 'nearest' });
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (visible[focusedIndex]) visible[focusedIndex].click();
            } else {
                focusedIndex = -1;
            }
        });
    }
});
