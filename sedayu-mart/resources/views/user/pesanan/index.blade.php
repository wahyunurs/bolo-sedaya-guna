<x-app-layout>
    @include('user.components.navbar')

    <!-- SECTION PESANAN -->
    <section class="py-20 bg-[#CBF5BA] min-h-screen">

        <!-- JUDUL -->
        <h1 class="text-center text-4xl font-extrabold text-green-800 mt-6 mb-10">
            DAFTAR PESANAN
        </h1>

        <!-- SEARCH + FILTER + DELETE -->
        <div class="flex items-center justify-center gap-3 px-10 mb-12">

            <!-- SEARCH BAR -->
            <div class="flex items-center rounded-xl w-full max-w-3xl overflow-hidden">
                <div class="relative w-full">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35M11 19a8 8 0 1 1 0-16 8 8 0 0 1 0 16z" />
                    </svg>
                    <input type="text" placeholder="Cari pesanan..."
                        class="w-full pl-11 pr-4 py-3 text-gray-600 border-0 focus:outline-none focus:ring-0" />
                </div>
                <button class="bg-[#4CD137] px-6 py-3 text-white hover:bg-green-600 transition flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                    Cari
                </button>
            </div>

            <!-- FILTER STATUS -->
            <select
                class="h-12 px-4 bg-white rounded-xl border-gray-300 text-gray-700 focus:ring-green-600 focus:border-green-600">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="diproses">Diproses</option>
                <option value="dikirim">Dikirim</option>
                <option value="selesai">Selesai</option>
                <option value="batal">Batal</option>
            </select>

            <!-- DELETE ALL -->
            <button
                class="bg-red-500 hover:bg-red-600 text-white h-12 w-12 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10 11v6" />
                    <path d="M14 11v6" />
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                    <path d="M3 6h18" />
                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                </svg>
            </button>

        </div>

        <!-- LIST PESANAN -->
        <div class="px-20 space-y-8">

            <!-- CARD PESANAN -->
<div class="bg-white rounded-2xl shadow px-10 py-6 flex items-center justify-between">

    <!-- KIRI -->
    <div class="flex items-start gap-8">

        <!-- CHECKBOX -->
        <input type="checkbox" class="self-center w-7 h-7 rounded-lg">

        <!-- FOTO PRODUK -->
        <img src="{{ asset('img/card/produk1.png') }}" class="h-24 w-24 rounded-xl object-cover">

        <!-- INFO PESANAN -->
        <div>
            <p class="font-bold text-2xl text-gray-800">Olahan Jagung</p>

            <p class="text-gray-600 mt-1">
                Jumlah: <span class="font-semibold">10</span> pcs
            </p>

            <!-- STATUS PESANAN -->
            <span class="inline-block mt-3 bg-yellow-300 text-yellow-800 font-semibold px-3 py-1 rounded-lg">
                Diproses
            </span>
        </div>
    </div>

    <!-- KANAN (TOTAL HARGA + DELETE) -->
    <div class="flex items-center gap-10">

        <!-- TOTAL HARGA -->
        <p class="text-green-700 font-bold text-2xl whitespace-nowrap">
            Rp 200.000,-
        </p>

        <!-- ICON DELETE -->
        <button
            class="p-2 rounded-lg text-red-600 border border-red-600 hover:bg-red-600 hover:text-white transition">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                <path d="M3 6h18" />
                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
            </svg>
        </button>

    </div>
</div>


        </div>

    </section>

</x-app-layout>
