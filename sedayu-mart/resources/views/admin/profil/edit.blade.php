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
                            <li><a href="{{ route('admin.profil.index') }}"
                                    class="text-green-400 font-semibold">Profil</a></li>
                            <li><span class="text-green-400">></span></li>
                            <li class="text-green-700 font-semibold">Ubah Profil</li>
                        </ol>
                        <h1 class="text-3xl font-bold text-gray-800 mt-2">Ubah Profil</h1>
                    </nav>
                </div>

                <!-- Konten Utama -->
                <div class="p-6 rounded-lg bg-white border border-gray-200 shadow-sm">
                    <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Avatar Preview & Upload -->
                            <div
                                class="md:col-span-1 p-4 rounded-lg border border-gray-200 bg-gray-50 flex flex-col items-center">
                                <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-white shadow">
                                    @php
                                        $avatar = $profil->avatar
                                            ? asset('storage/img/avatars/' . $profil->avatar)
                                            : 'https://ui-avatars.com/api/?background=22c55e&color=fff&name=' .
                                                urlencode($profil->nama ?? 'Admin');
                                    @endphp
                                    <img src="{{ $avatar }}" alt="Avatar" class="w-full h-full object-cover">
                                </div>
                                <p class="mt-3 text-sm text-gray-600">Format: JPG/PNG, maks 5 MB</p>
                                <label
                                    class="mt-3 inline-flex items-center px-3 py-2 bg-green-500 text-white text-sm font-medium rounded-lg shadow hover:bg-green-600 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M12 5v14" />
                                        <path d="M5 12h14" />
                                    </svg>
                                    Pilih Avatar
                                    <input type="file" name="avatar" class="hidden"
                                        accept="image/png,image/jpeg,image/jpg">
                                </label>
                                @error('avatar')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Form Fields -->
                            <div class="md:col-span-2 space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                                    <input type="text" name="nama" value="{{ old('nama', $profil->nama) }}"
                                        required
                                        class="mt-1 w-full px-3 py-2 border rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                                    @error('nama')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Alamat</label>
                                    <textarea name="alamat" rows="3" required
                                        class="mt-1 w-full px-3 py-2 border rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">{{ old('alamat', $profil->alamat) }}</textarea>
                                    @error('alamat')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700">Kabupaten</label>
                                        <input type="text" name="kabupaten"
                                            value="{{ old('kabupaten', $profil->kabupaten) }}" required
                                            class="mt-1 w-full px-3 py-2 border rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                                        @error('kabupaten')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700">Nomor Telepon</label>
                                        <input type="text" name="nomor_telepon"
                                            value="{{ old('nomor_telepon', $profil->nomor_telepon) }}" required
                                            class="mt-1 w-full px-3 py-2 border rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                                        @error('nomor_telepon')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a href="{{ route('admin.profil.index') }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Batal</a>
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 shadow">Simpan
                                Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <!-- JavaScript -->
    @vite('resources/js/admin/profil/index.js')
</x-app-layout>
