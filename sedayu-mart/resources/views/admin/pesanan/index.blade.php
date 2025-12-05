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
                            <li class="text-green-700 font-semibold">Pesanan</li>
                        </ol>
                        <h1 class="text-3xl font-bold text-gray-800 mt-2">Kelola Pesanan</h1>
                    </nav>
                </div>

                <div class="p-4 rounded-lg bg-white border border-gray-200">
                    <div class="flex items-center justify-between space-x-4 mb-4">
                        <!-- Search form (left) -->
                        <form id="filterForm" method="GET" action="{{ route('admin.pesanan.index') }}"
                            class="flex items-center w-full max-w-xl">
                            <div class="relative w-full">
                                <input id="searchInput" type="search" name="search" value="{{ request('search') }}"
                                    placeholder="Cari nama pesanan..."
                                    class="mt-1 block w-full p-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                                <button id="clearSearchBtn" type="button"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 hidden"
                                    aria-label="Clear search">&times;</button>
                            </div>
                            <button type="submit"
                                class="ml-3 px-3 py-2 bg-green-500 text-white rounded-md hidden sm:inline-block">Cari</button>
                        </form>

                        <!-- Filter Status Pesanan -->
                        <form id="statusFilterForm" method="GET" action="{{ route('admin.pesanan.index') }}">
                            <select name="status" id="statusFilter"
                                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Semua Status</option>
                                <option value="Menunggu Verifikasi"
                                    {{ request('status') == 'Menunggu Verifikasi' ? 'selected' : '' }}>Menunggu
                                    Verifikasi
                                </option>
                                <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>
                                    Diterima
                                </option>
                                <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak
                                </option>
                                <option value="Dalam Pengiriman"
                                    {{ request('status') == 'Dalam Pengiriman' ? 'selected' : '' }}>Dalam Pengiriman
                                </option>
                                <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>
                                    Selesai</option>
                            </select>
                    </div>

                    <!-- Tabel Pesanan -->
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
                                        Nama Pengguna
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-sm font-medium uppercase tracking-wider border-b">
                                        Nama Produk
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-sm font-medium uppercase tracking-wider border-b">
                                        Jumlah Pesanan
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-sm font-medium uppercase tracking-wider border-b">
                                        Total Bayar
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-sm font-medium uppercase tracking-wider border-b">
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-sm font-medium uppercase tracking-wider border-b">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($pesanans as $index => $pesanan)
                                    <tr class="hover:bg-green-50 hover:shadow-md transition duration-200 ease-in-out">
                                        <td class="px-6 py-4 text-center text-sm text-gray-700">{{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $pesanan->user->nama }}</td>
                                        @php
                                            $firstItem = $pesanan->items->first();
                                        @endphp
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $firstItem ? $firstItem->produk->nama ?? '-' : '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $firstItem ? $firstItem->kuantitas : '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $pesanan->total_bayar }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $pesanan->status }}</td>
                                        <td class="h-full px-6 py-4 text-sm text-gray-700">
                                            <div class="flex items-center justify-center space-x-4 h-full">
                                                @if ($pesanan->status === 'Menunggu Verifikasi')
                                                    <a href="{{ route('admin.pesanan.verifikasi', $pesanan->id) }}"
                                                        class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                                        Verifikasi
                                                    </a>
                                                @elseif(in_array($pesanan->status, ['Diterima', 'Dalam Pengiriman']))
                                                    <a href="{{ route('admin.pesanan.perbaruiStatus', $pesanan->id) }}"
                                                        class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                                        Perbarui Status
                                                    </a>
                                                @else
                                                    <span class="px-3 py-1 text-gray-500 rounded-md">-</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada
                                            pesanan ditemukan.
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
