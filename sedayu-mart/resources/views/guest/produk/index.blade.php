<x-app-layout>
    @include('guest.components.navbar')

    <!-- SECTION KATEGORI PRODUK -->
    <section id="produk" class="py-20 bg-[#e4fadc] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Judul -->
            <header class="text-center mb-14 mt-10">
                <h2 class="text-4xl md:text-5xl font-extrabold text-black tracking-wide">
                    KATEGORI PRODUK
                </h2>
            </header>

            <!-- GRID KATEGORI PRODUK -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- PRODUK 1 -->
                <div
                    class="relative bg-[#dbdb02] bg-opacity-70 backdrop-blur-sm rounded-xl shadow-xl
                            p-8 group hover:bg-[#b5b800] transition-all duration-300 ease-in-out overflow-hidden h-56">

                    <!-- Judul -->
                    <h3
                        class="absolute top-5 left-4 text-2xl font-bold text-white
                               group-hover:text-white transition-colors duration-300">
                        Produk Asli Desa
                    </h3>

                    <!-- Selengkapnya -->
                    <a href="#"
                        class="absolute bottom-4 left-4 text-sm font-semibold text-white
                               group-hover:text-white underline transition-colors duration-300">
                        Selengkapnya →
                    </a>

                    <!-- Gambar -->
                    <div class="absolute bottom-6 right-4 w-32 h-32 sm:w-32 sm:h-32">
                        <img src="{{ asset('img/card/produk-1.png') }}" alt="Kategori Produk 1"
                            class="w-full h-full object-contain" />
                    </div>
                </div>

                <!-- PRODUK 2 -->
                <div
                    class="relative bg-[#d87700] bg-opacity-70 backdrop-blur-sm rounded-xl shadow-xl
                            p-8 group hover:bg-[#967800] transition-all duration-300 ease-in-out overflow-hidden h-56">

                    <!-- Judul -->
                    <h3
                        class="absolute top-5 left-4 text-2xl font-bold text-white
                               group-hover:text-white transition-colors duration-300">
                        Pemesanan Online
                    </h3>

                    <!-- Selengkapnya -->
                    <a href="#"
                        class="absolute bottom-4 left-4 text-sm font-semibold text-white
                               group-hover:text-white underline transition-colors duration-300">
                        Selengkapnya →
                    </a>

                    <!-- Gambar -->
                    <div class="absolute bottom-6 right-4 w-32 h-32 sm:w-32 sm:h-32">
                        <img src="{{ asset('img/card/produk-2.png') }}" alt="Kategori Produk 2"
                            class="w-full h-full object-contain" />
                    </div>
                </div>

                <!-- PRODUK 3 -->
                <div
                    class="relative bg-[#db0025] bg-opacity-70 backdrop-blur-sm rounded-xl shadow-xl
                            p-8 group hover:bg-[#ca001e] transition-all duration-300 ease-in-out overflow-hidden h-56">

                    <!-- Judul -->
                    <h3
                        class="absolute top-5 left-4 text-2xl font-bold text-white
                               group-hover:text-white transition-colors duration-300">
                        Pengiriman Sampai Tujuan
                    </h3>

                    <!-- Selengkapnya -->
                    <a href="#"
                        class="absolute bottom-4 left-4 text-sm font-semibold text-white
                               group-hover:text-white underline transition-colors duration-300">
                        Selengkapnya →
                    </a>

                    <!-- Gambar -->
                    <div class="absolute bottom-6 right-4 w-32 h-32 sm:w-32 sm:h-32">
                        <img src="{{ asset('img/card/produk-3.png') }}" alt="Kategori Produk 3"
                            class="w-full h-full object-contain" />
                    </div>
                </div>

            </div>

        </div>
    </section>

</x-app-layout>
