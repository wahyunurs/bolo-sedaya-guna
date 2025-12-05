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
                            <li class="text-green-700 font-semibold">Pengguna</li>
                        </ol>
                        <h1 class="text-3xl font-bold text-gray-800 mt-2">Kelola Pengguna</h1>
                    </nav>
                </div>

                <div class="p-4 rounded-lg bg-white border border-gray-200">
                    <div
                        class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 space-y-4 sm:space-y-0 sm:space-x-4">
                        <form method="GET" action="{{ route('admin.pengguna.index') }}"
                            class="flex items-center w-full sm:w-auto" id="filterForm">
                            <div class="w-full sm:w-80 relative">
                                <input id="searchInput" type="search" name="q" value="{{ request('q') }}"
                                    placeholder="Cari nama atau email..."
                                    class="mt-1 block w-full p-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                                <button id="clearSearchBtn" type="button"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 hidden"
                                    aria-label="Clear search">&times;</button>
                            </div>
                            <button type="submit"
                                class="ml-3 px-3 py-2 bg-green-500 text-white rounded-md hidden sm:inline-block">Cari</button>
                        </form>
                    </div>

                    <!-- Tabel Pengguna -->
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
                                        Nama
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-sm font-medium uppercase tracking-wider border-b">
                                        Email
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-sm font-medium uppercase tracking-wider border-b">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($users as $index => $user)
                                    <tr class="hover:bg-green-50 hover:shadow-md transition duration-200 ease-in-out">
                                        <td class="px-6 py-4 text-center text-sm text-gray-700">{{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $user->nama }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $user->email }}</td>
                                        <td class="h-full px-6 py-4 text-sm text-gray-700">
                                            <div class="flex items-center justify-center space-x-4 h-full">
                                                <!-- Tombol Show (button triggers AJAX modal) -->
                                                <button type="button" data-id="{{ $user->id }}"
                                                    class="showUserBtn text-gray-500 hover:text-gray-700 transition duration-200 ease-in-out cursor-pointer"
                                                    aria-label="Lihat pengguna">
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
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada
                                            pengguna ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Show Modal will be loaded via AJAX. JS loaded from Vite bundle below. -->

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
            </div>
        </section>
    </main>

    <!-- Pengguna JavaScript -->
    @vite(['resources/js/admin/pengguna/index.js', 'resources/js/admin/pengguna/show-modal.js'])
</x-app-layout>
