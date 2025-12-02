<x-guest-layout>
    <!-- NAVBAR -->
    @include('guest.components.navbar')

    <!-- Dashboard Guest -->
    <section id="beranda" class="pt-40 pb-24 min-h-screen bg-no-repeat bg-center bg-cover"
        style="background-image: url('{{ asset('img/page/guest-dashboard.png') }}');">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">

            <!-- Tambahkan h-full flex items-center -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 h-full items-center">

                <!-- Left column -->
                <div class="flex items-center h-full">
                    <div class="w-full lg:w-11/12 p-6 md:p-1 flex flex-col justify-center">
                        <h1 class="text-5xl md:text-6xl font-black mb-6 leading-tight">
                            <strong class="font-black block whitespace-nowrap">SELAMAT DATANG DI</strong>
                            <span class="text-[#065f46]">Sedayu</span><span class="text-[#FBBF24]">Mart</span>
                        </h1>
                        <p class="text-base md:text-md mb-8 leading-relaxed">
                            Sendayu Mart adalah platform pasar lokal khas
                            <span class="font-bold text-green-600">Desa Brenggolo</span> yang menyediakan berbagai
                            produk unggulan hasil desa.
                        </p>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                            <a href="{{ route('user.produk.index') }}"
                                class="inline-flex items-center gap-3 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-full font-semibold text-md">
                                <span>Jelajahi Produk</span>
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right column -->
                <div></div>
            </div>
        </div>
    </section>
</x-guest-layout>
