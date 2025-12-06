@component('user.components.user-layout')
    @include('user.components.navbar')

    <section class="pt-16 sm:pt-20 pb-8 bg-[#e9ffe0] min-h-screen">
        <!-- Modal Flash Message -->
        @include('user.components.message-modal')

        {{-- WELCOME --}}
        <div
            class="w-full bg-gradient-to-r from-[#209416] to-[#46de67] px-4 sm:px-6 md:px-8 py-8 sm:py-10 md:py-12 rounded-b-3xl relative overflow-hidden">
            <div class="w-full md:w-2/3 lg:w-1/2 ml-2 sm:ml-4 md:ml-8 z-10 relative">
                <h1 class="text-2xl sm:text-3xl md:text-5xl lg:text-6xl xl:text-7xl font-bold text-white leading-tight">
                    SELAMAT DATANG
                </h1>

                <p
                    class="font-semibold text-white mt-3 sm:mt-4 text-xl sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl truncate">
                    {{ $user->nama }}
                </p>
            </div>

            <!-- Icon di paling kanan, setinggi card -->
            <div
                class="absolute right-2 sm:right-4 md:right-8 lg:right-14 top-0 bottom-0 flex items-center justify-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-crown-icon lucide-crown text-white opacity-20 sm:opacity-30 md:opacity-100 h-20 w-20 sm:h-28 sm:w-28 md:h-40 md:w-40 lg:h-48 lg:w-48 xl:h-56 xl:w-56 max-w-none">
                    <path
                        d="M11.562 3.266a.5.5 0 0 1 .876 0L15.39 8.87a1 1 0 0 0 1.516.294L21.183 5.5a.5.5 0 0 1 .798.519l-2.834 10.246a1 1 0 0 1-.956.734H5.81a1 1 0 0 1-.957-.734L2.02 6.02a.5.5 0 0 1 .798-.519l4.276 3.664a1 1 0 0 0 1.516-.294z" />
                    <path d="M5 21h14" />
                </svg>
            </div>
        </div>

        {{-- KATEGORI PRODUK --}}
        <div class="mt-6 sm:mt-8 px-4 sm:px-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl sm:text-2xl font-extrabold text-[#064D0A]">KATEGORI PRODUK</h2>

                <a href="{{ route('user.produk.index') }}"
                    class="text-[#064D0A] font-semibold text-sm sm:text-base lg:text-lg hover:text-[#4CAF50] transition-colors">
                    Selengkapnya >
                </a>
            </div>
        </div>

        {{-- SLIDER --}}
        <div class="mt-4 sm:mt-6 px-4 sm:px-6">

            <div class="relative w-full overflow-hidden rounded-lg sm:rounded-xl">

                <!-- Slider Wrapper -->
                <div id="slider" class="flex transition-transform duration-700">
                    <!-- Clone Last Slide (for infinite loop) -->
                    <img src="{{ asset('img/slide/dashboard-user3.png') }}"
                        class="w-full flex-shrink-0 object-cover h-48 sm:h-56 md:h-64 lg:h-80 xl:h-96">

                    <!-- Slide 1 -->
                    <img src="{{ asset('img/slide/dashboard-user1.png') }}"
                        class="w-full flex-shrink-0 object-cover h-48 sm:h-56 md:h-64 lg:h-80 xl:h-96">
                    <!-- Slide 2 -->
                    <img src="{{ asset('img/slide/dashboard-user2.png') }}"
                        class="w-full flex-shrink-0 object-cover h-48 sm:h-56 md:h-64 lg:h-80 xl:h-96">
                    <!-- Slide 3 -->
                    <img src="{{ asset('img/slide/dashboard-user3.png') }}"
                        class="w-full flex-shrink-0 object-cover h-48 sm:h-56 md:h-64 lg:h-80 xl:h-96">

                    <!-- Clone First Slide (for infinite loop) -->
                    <img src="{{ asset('img/slide/dashboard-user1.png') }}"
                        class="w-full flex-shrink-0 object-cover h-48 sm:h-56 md:h-64 lg:h-80 xl:h-96">
                </div>

                <!-- Tombol Kiri -->
                <button id="prevBtn"
                    class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 bg-white/90 w-10 h-10 sm:w-12 sm:h-12 rounded-full shadow-lg flex items-center justify-center hover:bg-white hover:scale-110 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <!-- Tombol Kanan -->
                <button id="nextBtn"
                    class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 bg-white/90 w-10 h-10 sm:w-12 sm:h-12 rounded-full shadow-lg flex items-center justify-center hover:bg-white hover:scale-110 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- DOTS -->
                <div id="dots" class="absolute bottom-3 sm:bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
                    <div class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-white shadow-md"></div>
                    <div class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-gray-300 shadow-md"></div>
                    <div class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-gray-300 shadow-md"></div>
                </div>
            </div>
        </div>

    </section>

    {{-- SWIPER LIB --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Script Slider -->
    <script>
        const slider = document.getElementById("slider");
        const dots = document.querySelectorAll("#dots div");

        const totalSlides = 3;
        let index = 1;
        let autoSlideInterval;

        const updateDots = () => {
            dots.forEach((dot, i) => {
                dot.className = i === index - 1 ?
                    "w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-white shadow-md" :
                    "w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-gray-300 shadow-md";
            });
        };

        let isAnimating = false;

        const moveToIndex = (duration = 800) => {
            if (isAnimating) return;
            isAnimating = true;
            // smoother easing for nicer animation
            slider.style.transition = `transform ${duration}ms cubic-bezier(.22,.9,.37,1)`;
            slider.style.transform = `translateX(-${index * 100}%)`;
            updateDots();
        };

        const nextSlide = () => {
            if (isAnimating) return;
            index++;
            moveToIndex();
        };

        // transitionend handler used to perform wrap-around snap exactly when animation finishes
        slider.addEventListener('transitionend', (e) => {
            if (e.propertyName !== 'transform') return;
            isAnimating = false;

            if (index === totalSlides + 1) {
                // jump to first real slide without animation
                slider.style.transition = 'none';
                index = 1;
                slider.style.transform = `translateX(-100%)`;
                updateDots();
                // force reflow so future transitions work
                void slider.offsetWidth;
            }
        });

        // Per user request: navigation always shifts slides to the left (advance)
        const advance = () => {
            nextSlide();
            restartAutoSlide();
        };

        document.getElementById("nextBtn").addEventListener("click", () => {
            advance();
        });

        // Make the left (prev) button also advance slides to left
        document.getElementById("prevBtn").addEventListener("click", () => {
            advance();
        });

        const startAutoSlide = () => {
            autoSlideInterval = setInterval(nextSlide, 4000);
        };

        const restartAutoSlide = () => {
            clearInterval(autoSlideInterval);
            startAutoSlide();
        };

        // initialize position to first real slide
        slider.style.transition = "none";
        slider.style.transform = "translateX(-100%)";

        // small delay to allow initial paint, then start animation and autoplay
        setTimeout(() => {
            startAutoSlide();
        }, 50);
    </script>
@endcomponent
