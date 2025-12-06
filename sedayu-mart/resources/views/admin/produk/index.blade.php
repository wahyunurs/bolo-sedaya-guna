<x-app-layout>
    <!-- Sidebar toggle controller (peer) -->
    <input id="menu-toggle" type="checkbox" class="peer sr-only" />

    <!-- Sidebar Admin -->
    @include('admin.components.sidebar')

    <!-- Navbar Admin -->
    @include('admin.components.navbar')

    <!-- Main Content -->
    <main class="ml-0 md:ml-64 peer-checked:md:ml-0 mt-16 transition-all duration-300">
        <section class="py-16 bg-[#f0ffeb] min-h-screen">
            <!-- Flash Message -->
            @include('admin.components.message-modal')

            <div class="max-w-5xl mx-auto px-6">
                <!-- Heading dan Breadcrumb -->
                <div class="mb-6">
                    <nav class="text-sm text-gray-500">
                        <ol class="list-reset flex items-center space-x-2">
                            <li><a href="{{ route('admin.dashboard') }}" class="hover:underline text-green-600">Admin</a>
                            </li>
                            <li><span class="text-green-400">></span></li>
                            <li class="text-green-700 font-semibold">Produk</li>
                        </ol>
                        <h1 class="text-3xl font-bold text-gray-800 mt-2">Kelola Produk</h1>
                    </nav>
                </div>

                <div class="p-4 rounded-lg bg-white border border-gray-200">
                    <div class="flex items-center justify-between space-x-4 mb-4">
                        <!-- Search form (left) -->
                        <form id="filterForm" method="GET" action="{{ route('admin.produk.index') }}"
                            class="flex items-center w-full max-w-xl">
                            <div class="relative w-full">
                                <input id="searchInput" type="search" name="search" value="{{ request('search') }}"
                                    placeholder="Cari nama produk..."
                                    class="mt-1 block w-full p-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                                <button id="clearSearchBtn" type="button"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 hidden"
                                    aria-label="Clear search">&times;</button>
                            </div>
                            <button type="submit"
                                class="ml-3 px-3 py-2 bg-green-500 text-white rounded-md hidden sm:inline-block">Cari</button>
                        </form>

                        <!-- Button Tambah (right) -->
                        <a href="{{ route('admin.produk.create') }}"
                            class="ml-4 px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah
                        </a>
                    </div>

                    <!-- Tabel Produk -->
                    <div class="overflow-x-auto mb-4">
                        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-lg">
                            <thead class="bg-gradient-to-r from-green-400 to-green-600 text-white">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-center text-sm font-medium uppercase tracking-wider border-b">
                                        No
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-sm font-medium uppercase tracking-wider border-b">
                                        Gambar Produk
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-sm font-medium uppercase tracking-wider border-b">
                                        Nama Produk
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-sm font-medium uppercase tracking-wider border-b">
                                        Harga
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-sm font-medium uppercase tracking-wider border-b">
                                        Berat
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-sm font-medium uppercase tracking-wider border-b">
                                        Stok
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-sm font-medium uppercase tracking-wider border-b">
                                        Satuan
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-sm font-medium uppercase tracking-wider border-b">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($produks as $index => $produk)
                                    <tr class="hover:bg-green-50 hover:shadow-md transition duration-200 ease-in-out">
                                        <td class="px-6 py-4 text-center text-sm text-gray-700">{{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            @php $thumb = optional($produk->gambarProduks->first())->gambar; @endphp
                                            <div class="w-16 h-16 rounded border flex items-center justify-center overflow-hidden bg-gray-50">
                                                @if ($thumb)
                                                    <img src="{{ asset('/storage/img/produk/' . $thumb) }}"
                                                        alt="{{ $produk->nama }}" class="w-full h-full object-cover">
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                                        <path d="M12 3v12" />
                                                        <path d="m17 8-5-5-5 5" />
                                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                                    </svg>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $produk->nama }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $produk->harga }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $produk->berat }} g</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $produk->stok }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $produk->satuan_produk }}</td>
                                        <td class="h-full px-6 py-4 text-sm text-gray-700">
                                            <div class="flex items-center justify-center space-x-4 h-full">
                                                <!-- Tombol Show (button triggers AJAX modal) -->
                                                <button type="button" data-id="{{ $produk->id }}"
                                                    class="showProdukBtn text-gray-500 hover:text-gray-700 transition duration-200 ease-in-out cursor-pointer"
                                                    aria-label="Lihat produk">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.522 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7s-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </button>

                                                <!-- Tombol Edit -->
                                                <form action="{{ route('admin.produk.edit', $produk->id) }}"
                                                    method="GET">
                                                    <button type="submit"
                                                        class="text-yellow-500 hover:text-yellow-700 transition duration-200 ease-in-out"
                                                        aria-label="Edit produk">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15.232 5.232l3.536 3.536M9 11l6.364-6.364a2 2 0 012.828 0l1.172 1.172a2 2 0 010 2.828L13 15l-4 1 1-4z" />
                                                        </svg>
                                                    </button>
                                                </form>

                                                <!-- Tombol Delete -->
                                                <button type="button" data-id="{{ $produk->id }}"
                                                    data-url="{{ route('admin.produk.destroy', $produk->id) }}"
                                                    class="deleteButton text-red-500 hover:text-red-700 transition duration-200 ease-in-out"
                                                    aria-label="Hapus produk">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m5 0H6" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada
                                            produk ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <style>
                /* Hide native search clear/cancel icon so only our custom clear button shows */
                #searchInput::-webkit-search-cancel-button,
                #searchInput::-webkit-search-decoration {
                    -webkit-appearance: none;
                }

                #searchInput::-ms-clear {
                    display: none;
                    width: 0;
                    height: 0;
                }
            </style>

            <!-- Script Chart.js -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <!-- Produk JavaScript -->
            @vite('resources/js/admin/produk/index.js')

            {{-- Konfirmasi Hapus Modal --}}
            @include('admin.produk.konfirmasi-hapus')
        </section>
    </main>
</x-app-layout>
