<x-app-layout>
    <!-- Unit Organisasi Content -->
    <main class="ml-0 md:ml-64 peer-checked:md:ml-0 transition-all duration-300">
        <section class="pt-24 px-8 pb-10 bg-gradient-to-br from-gray-50 via-green-50 to-indigo-50 min-h-screen">
            <div class="max-w-7xl mx-auto px-3">
                <!-- Heading dan Breadcrumb -->
                <div class="mb-8">
                    <nav class="text-sm mb-4">
                        <ol class="flex items-center space-x-2">
                            <li>
                                <a href="{{ route('admin.dashboard') }}"
                                    class="text-green-600 hover:text-green-700 font-medium transition duration-150 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                        <polyline points="9 22 9 12 15 12 15 22" />
                                    </svg>
                                    Admin
                                </a>
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                    <polyline points="9 18 15 12 9 6" />
                                </svg>
                            </li>
                            <li>
                                <a href="{{ route('admin.produk.index') }}"
                                    class="text-green-600 hover:text-green-700 font-medium transition duration-150">
                                    Produk
                                </a>
                            </li>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                    <polyline points="9 18 15 12 9 6" />
                                </svg>
                            </li>
                            <li class="text-gray-700 font-semibold">Kelola Varian Produk</li>
                        </ol>
                    </nav>
                    <div>
                        <p class="text-xs font-semibold text-green-600 uppercase tracking-wider mb-1">Manajemen Data
                        </p>
                        <h1 class="text-3xl font-bold text-gray-900">Kelola Varian Produk</h1>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="mb-6">
                    <a href="{{ route('admin.produk.index') }}"
                        class="inline-flex items-center text-gray-700 hover:bg-green-100 border border-green-300 focus:ring-4 focus:outline-none focus:ring-green-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="group-hover:-translate-x-1 transition-transform duration-300">
                            <polyline points="15 18 9 12 15 6" />
                        </svg>
                        <span class="tracking-wide">Kembali ke Produk</span>
                    </a>
                </div>

                <!-- Main Content -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-5">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                    @if ($gambarProduks->gambar)
                                        <img src="{{ asset('storage/img/produk/' . $gambarProduks->gambar) }}"
                                            alt="{{ $produk->nama }}" class="w-5 h-5 object-contain">
                                    @else
                                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                            <circle cx="9" cy="7" r="4" />
                                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-white">{{ $produk->nama }}
                                    </h2>
                                    <p class="text-xs text-blue-100">Daftar varian dalam {{ $produk->nama }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table Section -->
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold text-gray-900">Daftar Varian</h3>
                                <button type="button" data-modal-target="add-varian-modal"
                                    data-modal-toggle="add-varian-modal"
                                    class="text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 font-semibold rounded-lg text-sm px-5 py-2.5 transition-all duration-150 flex items-center gap-2 shadow-lg hover:shadow-xl">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Tambah Varian
                                </button>
                            </div>

                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gradient-to-r from-gray-50 to-blue-50 border-b border-gray-200">
                                        <th scope="col" class="px-4 py-4 text-center font-bold w-24">
                                            <span
                                                class="text-xs font-extrabold text-gray-700 uppercase tracking-wider">Gambar</span>
                                        </th>
                                        <th scope="col" class="px-4 py-4 text-center font-bold">
                                            <span
                                                class="text-xs font-extrabold text-gray-700 uppercase tracking-wider">Nama</span>
                                        </th>
                                        <th scope="col" class="px-4 py-4 text-center font-bold">
                                            <span
                                                class="text-xs font-extrabold text-gray-700 uppercase tracking-wider">Harga</span>
                                        </th>
                                        <th scope="col" class="px-4 py-4 text-center font-bold">
                                            <span
                                                class="text-xs font-extrabold text-gray-700 uppercase tracking-wider">Berat</span>
                                        </th>
                                        <th scope="col" class="px-4 py-4 text-center font-bold">
                                            <span
                                                class="text-xs font-extrabold text-gray-700 uppercase tracking-wider">Stok</span>
                                        </th>
                                        <th scope="col" class="px-4 py-4 text-center font-bold">
                                            <span
                                                class="text-xs font-extrabold text-gray-700 uppercase tracking-wider">Default</span>
                                        </th>
                                        <th scope="col" class="px-4 py-4 text-center font-bold w-40">
                                            <span
                                                class="text-xs font-extrabold text-gray-700 uppercase tracking-wider">Aksi</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($varians as $varian)
                                        <tr
                                            class="group border-b border-gray-100 hover:bg-gradient-to-r hover:from-green-50 hover:to-indigo-50 hover:shadow-lg hover:!border-l-4 hover:!border-l-green-600 border-l-4 border-l-white transition-all duration-300">
                                            <td class="px-4 py-5 text-center">
                                                @if ($varian->gambar)
                                                    <div class="flex justify-center">
                                                        <img src="{{ asset('storage/img/varian/' . $varian->gambar) }}"
                                                            alt="{{ $varian->nama }}"
                                                            class="w-20 h-20 object-cover rounded-xl shadow-md border-2 border-gray-200 group-hover:border-blue-500 group-hover:shadow-xl group-hover:scale-105 transition-all duration-300">
                                                    </div>
                                                @else
                                                    <div class="flex justify-center">
                                                        <div
                                                            class="w-12 h-12 rounded-full bg-gradient-to-br from-green-100 to-indigo-100 flex items-center justify-center">
                                                            <svg class="w-6 h-6 text-green-600"
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-5">
                                                <p class="text-sm font-semibold text-gray-900">{{ $varian->nama }}
                                                </p>
                                            </td>
                                            <td class="px-4 py-5 text-center">
                                                <p class="text-sm font-semibold text-gray-900">{{ $varian->harga }}
                                                </p>
                                            </td>
                                            <td class="px-4 py-5 text-center">
                                                <p class="text-sm font-semibold text-gray-900">{{ $varian->berat }}
                                                </p>
                                            </td>
                                            <td class="px-4 py-5 text-center">
                                                <p class="text-sm font-semibold text-gray-900">{{ $varian->stok }}
                                                </p>
                                            </td>
                                            <td class="px-4 py-5 text-center">
                                                <span
                                                    class="text-sm text-gray-700 font-medium">{{ $varian->is_default }}</span>
                                            </td>
                                            <td class="px-4 py-5">
                                                <div class="flex items-center justify-center gap-2">
                                                    {{-- <button type="button"
                                                        data-modal-target="show-varian-modal-{{ $varian->id }}"
                                                        data-modal-toggle="show-varian-modal-{{ $varian->id }}"
                                                        class="group p-2 rounded-lg bg-blue-50 hover:bg-blue-100 transition-all duration-200 hover:shadow-md"
                                                        title="Lihat">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                            height="18" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="text-blue-600 group-hover:text-blue-700 transition-colors">
                                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                                            <circle cx="12" cy="12" r="3" />
                                                        </svg>
                                                    </button> --}}
                                                    <button type="button"
                                                        data-modal-target="edit-varian-modal-{{ $varian->id }}"
                                                        data-modal-toggle="edit-varian-modal-{{ $varian->id }}"
                                                        class="group p-2 rounded-lg bg-amber-50 hover:bg-amber-100 transition-all duration-200 hover:shadow-md"
                                                        title="Edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                            height="18" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="text-amber-600 group-hover:text-amber-700 transition-colors">
                                                            <path
                                                                d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                                            <path d="m15 5 4 4" />
                                                        </svg>
                                                    </button>
                                                    <button type="button"
                                                        data-modal-target="delete-varian-modal-{{ $varian->id }}"
                                                        data-modal-toggle="delete-varian-modal-{{ $varian->id }}"
                                                        class="group p-2 rounded-lg bg-red-50 hover:bg-red-100 transition-all duration-200 hover:shadow-md"
                                                        title="Hapus">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                            height="18" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="text-red-600 group-hover:text-red-700 transition-colors">
                                                            <path d="M3 6h18" />
                                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                                            <line x1="10" x2="10" y1="11"
                                                                y2="17" />
                                                            <line x1="14" x2="14" y1="11"
                                                                y2="17" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- Include Modals --}}
                                        {{-- @include('admin.produk.varian.show', [
                                            'varian' => $varian,
                                        ]) --}}
                                        @include('admin.produk.varian.edit', [
                                            'varian' => $varian,
                                        ])
                                        @include('admin.produk.varian.delete', [
                                            'varian' => $varian,
                                        ])
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-16 text-center">
                                                <div class="flex flex-col items-center justify-center">
                                                    <div
                                                        class="w-20 h-20 rounded-2xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center mb-4 shadow-inner">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="40"
                                                            height="40" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="1.5"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="text-gray-400">
                                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                                            <circle cx="9" cy="7" r="4" />
                                                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                                        </svg>
                                                    </div>
                                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Tidak Ada Data
                                                        Varian
                                                    </h3>
                                                    <p class="text-sm text-gray-500">Belum ada varian dalam produk ini.
                                                        Klik tombol "Tambah Varian" untuk menambah data.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    {{-- Include Create Modal --}}
    @include('admin.produk.varian.create')
</x-app-layout>
