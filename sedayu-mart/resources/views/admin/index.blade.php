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
            <div class="max-w-5xl mx-auto px-6">
                <!-- Heading dan Breadcrumb -->
                <div class="mb-6">
                    <nav class="text-sm text-gray-500">
                        <ol class="list-reset flex items-center space-x-2">
                            <li><a href="{{ route('admin.dashboard') }}" class="hover:underline text-green-600">Admin</a>
                            </li>
                            <li><span class="text-green-400">></span></li>
                            <li class="text-green-700 font-semibold">Dashboard</li>
                        </ol>
                        <h1 class="text-3xl font-bold text-gray-800 mt-2">Admin Dashboard</h1>
                    </nav>
                </div>

                <div class="p-6 rounded-lg bg-white shadow-md border border-gray-200">
                    <!-- Total Count Data Tabel User, Produk, Pesanan -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                        <div
                            class="flex items-center h-28 rounded-lg bg-sky-50 shadow-sm border border-gray-200 p-4 hover:shadow-md hover:scale-105 transition duration-300 ease-in-out">
                            <div class="text-blue-500 ml-4">
                                <svg class="shrink-0 w-5 h-5 transition duration-75" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 20 18">
                                    <path
                                        d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                                </svg>
                            </div>
                            <div class="ml-6">
                                <p class="text-2xl font-bold text-gray-800">{{ $usersCount ?? 0 }}</p>
                                <p class="text-sm text-gray-500">Total Pengguna</p>
                            </div>
                        </div>
                        <div
                            class="flex items-center h-28 rounded-lg bg-amber-50 shadow-sm border border-gray-200 p-4 hover:shadow-md hover:scale-105 transition duration-300 ease-in-out">
                            <div class="text-red-500 ml-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="shrink-0 w-5 h-5 transition duration-75"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                    <path d="M3 9h18M9 21V9" />
                                </svg>
                            </div>
                            <div class="ml-6">
                                <p class="text-2xl font-bold text-gray-800">{{ $produkCount ?? 0 }}</p>
                                <p class="text-sm text-gray-500">Total Produk</p>
                            </div>
                        </div>
                        <div
                            class="flex items-center h-28 rounded-lg bg-yellow-50 shadow-sm border border-gray-200 p-4 hover:shadow-md hover:scale-105 transition duration-300 ease-in-out">
                            <div class="text-yellow-500 ml-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="shrink-0 w-5 h-5 transition duration-75"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <circle cx="9" cy="21" r="1" />
                                    <circle cx="20" cy="21" r="1" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 001.99-1.73L23 6H6" />
                                </svg>
                            </div>
                            <div class="ml-6">
                                <p class="text-2xl font-bold text-gray-800">{{ $pesananCount ?? 0 }}</p>
                                <p class="text-sm text-gray-500">Total Pesanan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Pesanan Terbaru -->
                    <div
                        class="rounded-lg bg-white shadow-md border border-gray-200 p-6 hover:shadow-lg hover:scale-105 transition duration-300 ease-in-out">
                        <a href="{{ route('admin.pesanan.index') }}">
                            <h2 class="text-lg font-semibold text-gray-700 mb-4">Pesanan Terbaru</h2>
                        </a>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead>
                                    <tr class="text-gray-600">
                                        <th class="px-4 py-2">#</th>
                                        <th class="px-4 py-2">User</th>
                                        <th class="px-4 py-2">Total</th>
                                        <th class="px-4 py-2">Status</th>
                                        <th class="px-4 py-2">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pesanans as $pesanan)
                                        <tr
                                            class="border-b hover:bg-gray-100 hover:shadow-sm transition duration-200 ease-in-out">
                                            <td class="px-4 py-2 text-gray-900">{{ $pesanan->id }}</td>
                                            <td class="px-4 py-2">{{ $pesanan->user->name ?? 'Tidak Diketahui' }}</td>
                                            <td class="px-4 py-2">
                                                {{ number_format($pesanan->total_bayar ?? 0, 0, ',', '.') }}</td>
                                            <td class="px-4 py-2 text-gray-500">{{ $pesanan->status }}</td>
                                            <td class="px-4 py-2 text-gray-500">
                                                {{ optional($pesanan->created_at)->format('d M Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-4 py-2 text-center text-gray-500">Belum ada
                                                pesanan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Statistik Pesanan -->
                <div
                    class="rounded-lg bg-white shadow-md border border-gray-200 p-6 mb-6 hover:shadow-lg hover:scale-105 transition duration-300 ease-in-out">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4 text-center">Statistik Pesanan Tahun
                        {{ $year ?? now()->year }}</h2>
                    <div class="relative w-full h-64">
                        <canvas id="permintaanChart" class="w-full h-full"></canvas>
                    </div>
                    {{-- Chart.js CDN (required before chart instantiation) --}}
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <!-- Diagram data (moved to admin JS) -->
                    <script>
                        window.__diagramData = @json($diagramData ?? ['labels' => [], 'data' => []]);
                    </script>
                </div>
            </div>
        </section>
    </main>

    <!-- Admin Dashboard JavaScript -->
    @vite('resources/js/admin/index.js')
</x-app-layout>
