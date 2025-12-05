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
                            <li class="text-green-700 font-semibold">Rekening</li>
                        </ol>
                        <h1 class="text-3xl font-bold text-gray-800 mt-2">Kelola Rekening</h1>
                    </nav>
                </div>

                <div class="p-4 rounded-lg bg-white border border-gray-200">
                    <div class="flex items-center justify-between space-x-4 mb-4">
                        <!-- Search form (left) -->
                        {{-- <form id="filterForm" method="GET" action="{{ route('admin.rekening.index') }}"
                            class="flex items-center w-full max-w-xl">
                            <div class="relative w-full">
                                <input id="searchInput" type="search" name="search" value="{{ request('search') }}"
                                    placeholder="Cari kabupaten..."
                                    class="mt-1 block w-full p-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                                <button id="clearSearchBtn" type="button"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 hidden"
                                    aria-label="Clear search">&times;</button>
                            </div>
                            <button type="submit"
                                class="ml-3 px-3 py-2 bg-green-500 text-white rounded-md hidden sm:inline-block">Cari</button>
                        </form> --}}

                        <!-- Button Tambah (open create modal) -->
                        <button id="createButton" type="button"
                            class="ml-4 px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah
                        </button>
                    </div>

                    <!-- Tabel Rekening -->
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
                                        Nama Bank
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-sm font-medium uppercase tracking-wider border-b">
                                        Nomor Rekening
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-sm font-medium uppercase tracking-wider border-b">
                                        Atas Nama
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-sm font-medium uppercase tracking-wider border-b">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($rekening as $index => $rek)
                                    <tr class="hover:bg-green-50 hover:shadow-md transition duration-200 ease-in-out">
                                        <td class="px-6 py-4 text-center text-sm text-gray-700">{{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $rek->nama_bank }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $rek->nomor_rekening }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $rek->atas_nama }}</td>
                                        <td class="h-full px-6 py-4 text-sm text-gray-700">
                                            <div class="flex items-center justify-center space-x-4 h-full">
                                                <!-- Tombol Edit (buka modal) -->
                                                <button type="button"
                                                    class="editButton text-yellow-500 hover:text-yellow-700 transition duration-200 ease-in-out"
                                                    aria-label="Edit rekening" data-id="{{ $rek->id }}"
                                                    data-nama_bank="{{ $rek->nama_bank }}"
                                                    data-nomor_rekening="{{ $rek->nomor_rekening }}"
                                                    data-atas_nama="{{ $rek->atas_nama }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15.232 5.232l3.536 3.536M9 11l6.364-6.364a2 2 0 012.828 0l1.172 1.172a2 2 0 010 2.828L13 15l-4 1 1-4z" />
                                                    </svg>
                                                </button>

                                                <!-- Tombol Delete -->
                                                <button type="button" data-id="{{ $rek->id }}"
                                                    data-url="{{ route('admin.rekening.destroy', $rek->id) }}"
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
                                            rekening ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- Script Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </main>

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

    <!-- Create Rekening Modal -->
    @include('admin.rekening.create-modal')

    <!-- Edit Modal Rekening -->
    @include('admin.rekening.edit-modal')

    <!-- Konfirmasi Hapus Modal -->
    @include('admin.rekening.konfirmasi-hapus')

    <!-- Rekening JavaScript -->
    @vite(['resources/js/admin/rekening/index.js', 'resources/js/admin/rekening/create-modal.js', 'resources/js/admin/rekening/edit-modal.js'])

</x-app-layout>
