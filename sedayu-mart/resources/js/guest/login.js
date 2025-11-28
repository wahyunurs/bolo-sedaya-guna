document.addEventListener('DOMContentLoaded', function() {
	// Toast auto-hide for login error (top-right)
	(function() {
		const toast = document.getElementById('toast-error');
		const closeBtn = document.getElementById('toastClose');
		if (!toast) return;

		function hideToast() {
			toast.classList.add('opacity-0', 'translate-x-2');
			setTimeout(() => toast.remove(), 300);
		}

		const timer = setTimeout(hideToast, 5000);
		if (closeBtn) {
			closeBtn.addEventListener('click', function() {
				clearTimeout(timer);
				hideToast();
			});
		}
	})();

	// Toggle Password Visibility
	const passwordInput = document.getElementById('password');
	const togglePassword = document.getElementById('togglePassword');
	const eyeIcon = document.getElementById('eyeIcon');
	const eyeClosedIcon = document.getElementById('eyeClosedIcon');

	if (togglePassword && passwordInput) {
		togglePassword.addEventListener('click', function() {
			const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
			passwordInput.setAttribute('type', type);

			if (eyeIcon) eyeIcon.classList.toggle('hidden');
			if (eyeClosedIcon) eyeClosedIcon.classList.toggle('hidden');
		});
	}

	// Unified Icon Color handler for email and password
	const iconFields = [
		{ inputId: 'email', wrapId: 'emailIconWrap' },
		{ inputId: 'password', wrapId: 'passwordIconWrap' }
	];

	iconFields.forEach(({ inputId, wrapId }) => {
		const input = document.getElementById(inputId);
		const wrap = document.getElementById(wrapId);
		if (!input || !wrap) return;

		// ensure smooth color transition
		wrap.classList.add('transition-colors', 'duration-150');

		function update() {
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
		}

		['focus', 'blur', 'input', 'change'].forEach(evt => input.addEventListener(evt, update));

		// initialize
		update();
	});
});
