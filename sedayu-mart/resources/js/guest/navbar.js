document.addEventListener('DOMContentLoaded', function() {
        // select nav links that point to sections
        const navLinks = Array.from(document.querySelectorAll('nav a[href^="#"]'));

        // ensure spans exist and start collapsed where needed
        navLinks.forEach(a => {
            const span = a.querySelector('span[aria-hidden="true"]');
            if (span && !span.classList.contains('scale-x-0') && !span.classList.contains(
                    'scale-x-100')) {
                span.classList.add('scale-x-0');
            }
        });

        const idToLink = {};
        navLinks.forEach(a => {
            const href = a.getAttribute('href');
            if (href && href.startsWith('#')) idToLink[href] = a;
        });

        const options = {
            root: null,
            rootMargin: '0px 0px -45% 0px',
            threshold: 0
        };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const id = '#' + (entry.target.id || '');
                const link = idToLink[id];
                if (!link) return;
                const span = link.querySelector('span[aria-hidden="true"]');
                if (entry.isIntersecting) {
                    // reset all
                    navLinks.forEach(l => {
                        l.classList.remove('font-bold');
                        l.style.color = '';
                        const s = l.querySelector('span[aria-hidden="true"]');
                        if (s) {
                            s.classList.remove('scale-x-100');
                            s.classList.add('scale-x-0');
                        }
                    });
                    // set active
                    link.classList.add('font-bold');
                    link.style.color = '#4CAF50';
                    if (span) {
                        span.classList.remove('scale-x-0');
                        span.classList.add('scale-x-100');
                    }
                }
            });
        }, options);

        // observe existing sections only
        Object.keys(idToLink).forEach(id => {
            const el = document.querySelector(id);
            if (el) observer.observe(el);
        });

        // fallback: when clicking a nav link, update active immediately
        navLinks.forEach(a => {
            a.addEventListener('click', function() {
                navLinks.forEach(l => {
                    l.classList.remove('font-bold');
                    l.style.color = '';
                    const s = l.querySelector('span[aria-hidden="true"]');
                    if (s) {
                        s.classList.remove('scale-x-100');
                        s.classList.add('scale-x-0');
                    }
                });
                this.classList.add('font-bold');
                this.style.color = '#4CAF50';
                const sp = this.querySelector('span[aria-hidden="true"]');
                if (sp) {
                    sp.classList.remove('scale-x-0');
                    sp.classList.add('scale-x-100');
                }
            });
        });
    });