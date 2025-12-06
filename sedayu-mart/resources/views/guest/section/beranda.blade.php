<!-- HOME GUEST -->
<section id="beranda"
    class="pt-20 sm:pt-28 lg:pt-40 pb-12 sm:pb-16 lg:pb-24 min-h-screen bg-no-repeat bg-center bg-cover flex items-center"
    style="background-image: url('{{ asset('img/page/guest-dashboard.png') }}');">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 h-full items-center">

            <!-- Left column -->
            <div class="flex items-center h-full">
                <div class="w-full lg:w-11/12 p-4 sm:p-6 lg:p-0 flex flex-col justify-center">
                    <h1
                        class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-black mb-4 sm:mb-6 lg:mb-8 leading-tight">
                        <strong
                            class="font-black block whitespace-nowrap text-2xl sm:text-3xl lg:text-4xl xl:text-5xl">SELAMAT
                            DATANG DI</strong>
                        <span
                            class="block tracking-tight text-[#065f46] text-3xl sm:text-4xl lg:text-5xl xl:text-6xl">SEDAYU<span
                                class="text-[#FBBF24]">MART</span></span>
                    </h1>
                    <p class="text-xs sm:text-sm lg:text-base xl:text-lg mb-6 sm:mb-8 lg:mb-10 leading-relaxed">
                        Sedayu Mart adalah platform pasar lokal khas
                        <span class="font-bold text-green-600">Desa Brenggolo</span> yang menyediakan berbagai
                        produk unggulan hasil desa.
                    </p>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3 lg:gap-4">
                        <a href="{{ route('user.produk.index') }}"
                            class="inline-flex items-center gap-2 sm:gap-3 bg-green-600 hover:bg-green-700 text-white px-4 sm:px-6 lg:px-8 py-2 sm:py-3 lg:py-4 rounded-full font-semibold text-xs sm:text-sm lg:text-base xl:text-lg transition">
                            <span>Jelajahi Produk</span>
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right column -->
            <div class="hidden lg:flex items-center h-full"></div>
        </div>
    </div>
</section>
