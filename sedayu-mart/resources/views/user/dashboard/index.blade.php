<x-app-layout>
    @include('user.components.navbar')

    <section class="py-20 bg-[#CBF5BA] min-h-screen">

            {{-- WELCOME --}}
            <div class="w-full bg-gradient-to-r from-[#209416] to-[#46de67] px-8 py-12 rounded-b-3xl">
                <h1 class="text-3xl md:text-4xl font-bold text-[#ffffff]">SELAMAT DATANG</h1>
                <p class="text-xl md:text-2xl font-semibold text-[#ffffff] mt-2">
                    {{ $user->nama }}
                </p>
            </div>

            {{-- KATEGORI PRODUK --}}
            <div class="mt-8 px-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-extrabold text-[#064D0A]">KATEGORI PRODUK</h2>

                    <a href="{{ route('user.produk.index') }}" class="text-[#064D0A] font-semibold text-lg">
                        Selengkapnya >
                    </a>
                </div>
            </div>

            {{-- SLIDER --}}
            <div class="mt-6 px-6">

                <div class="relative w-full overflow-hidden">

                    <!-- Slider Wrapper -->
                    <div id="slider" class="flex transition-transform duration-700">
                        <!-- Clone Last Slide (for infinite loop) -->
                        <img src="{{ asset('img/slide/dashboard-user3.png') }}"
                            class="w-full flex-shrink-0 object-cover h-56 md:h-80">

                        <!-- Slide 1 -->
                        <img src="{{ asset('img/slide/dashboard-user1.png') }}"
                            class="w-full flex-shrink-0 object-cover h-56 md:h-80">
                        <!-- Slide 2 -->
                        <img src="{{ asset('img/slide/dashboard-user2.png') }}"
                            class="w-full flex-shrink-0 object-cover h-56 md:h-80">
                        <!-- Slide 3 -->
                        <img src="{{ asset('img/slide/dashboard-user3.png') }}"
                            class="w-full flex-shrink-0 object-cover h-56 md:h-80">

                        <!-- Clone First Slide (for infinite loop) -->
                        <img src="{{ asset('img/slide/dashboard-user1.png') }}"
                            class="w-full flex-shrink-0 object-cover h-56 md:h-80">
                    </div>

                    <!-- Tombol Kiri -->
                    <button id="prevBtn"
                        class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/90 w-12 h-12 rounded-full shadow flex items-center justify-center hover:bg-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    <!-- Tombol Kanan -->
                    <button id="nextBtn"
                        class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/90 w-12 h-12 rounded-full shadow flex items-center justify-center hover:bg-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <!-- DOTS -->
                    <div id="dots" class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
                        <div class="w-3 h-3 rounded-full bg-white"></div>
                        <div class="w-3 h-3 rounded-full bg-gray-300"></div>
                        <div class="w-3 h-3 rounded-full bg-gray-300"></div>
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
                    "w-3 h-3 rounded-full bg-white" :
                    "w-3 h-3 rounded-full bg-gray-300";
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

</x-app-layout>
