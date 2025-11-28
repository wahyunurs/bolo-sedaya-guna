<nav class="bg-[#e9ffe6] shadow-lg fixed w-full z-20 top-0 left-0 border-b-4 border-[#d3d3d3] h-20">
    <div class="max-w-screen-xl mx-auto p-4 flex items-center">

        <!-- Left: Logo + Mobile toggle -->
        <div class="flex items-center flex-1 md:flex-none">
            <a href="#beranda" class="inline-flex items-center">
                <img src="{{ asset('img/logo/goloka.png') }}" class="w-20" alt="Logo">
            </a>

            <!-- Mobile menu button -->
            <button data-collapse-toggle="navbar-default" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-black rounded-lg md:hidden hover:bg-gray-100 focus:outline-none ms-3"
                aria-controls="navbar-default" aria-expanded="false">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>

        <!-- Center: Navigation -->
        <div class="flex-1 flex justify-center">
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul
                    class="font-small flex flex-col p-3 md:p-0 mt-4 border rounded-lg  md:flex-row md:space-x-4 md:mt-0 md:border-0">
                    <li>
                        <a href="#beranda" class="relative block py-2 px-2 text-black hover:text-[#4CAF50] group">
                            Beranda
                            <span aria-hidden="true"
                                class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-[#4CAF50] origin-left transform transition-transform duration-300 scale-x-0 group-hover:scale-x-100"></span>
                        </a>
                    </li>
                    <li>
                        <a href="#tentang" class="relative block py-2 px-2 text-black hover:text-[#4CAF50] group">
                            Tentang
                            <span aria-hidden="true"
                                class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-[#4CAF50] origin-left transform transition-transform duration-300 scale-x-0 group-hover:scale-x-100"></span>
                        </a>
                    </li>
                    <li>
                        <a href="#produk" class="relative block py-2 px-2 text-black hover:text-[#4CAF50] group">
                            Produk
                            <span aria-hidden="true"
                                class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-[#4CAF50] origin-left transform transition-transform duration-300 scale-x-0 group-hover:scale-x-100"></span>
                        </a>
                    </li>
                    <li>
                        <a href="#kontak" class="relative block py-2 px-2 text-black hover:text-[#4CAF50] group">
                            Kontak
                            <span aria-hidden="true"
                                class="absolute left-0 -bottom-0.5 h-0.5 w-full bg-[#4CAF50] origin-left transform transition-transform duration-300 scale-x-0 group-hover:scale-x-100"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Right: Login button with right arrow icon -->
        <div class="flex items-center justify-end flex-1 md:flex-none">
            <div class="hidden sm:flex sm:items-center ms-3">
                <a href="{{ route('login') }}"
                    class="inline-flex items-center px-3 py-2 border-2 border-[#4CAF50] hover:border-transparent text-md font-medium rounded-3xl text-[#4CAF50] hover:text-white hover:bg-[#4CAF50] focus:outline-none focus:ring-2 transition ease-in-out duration-150">
                    <span class="mr-2">Masuk</span>
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</nav>
<script>
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
</script>
