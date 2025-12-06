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
                            <li class="text-green-700 font-semibold">Profil</li>
                        </ol>
                        <h1 class="text-3xl font-bold text-gray-800 mt-2">Kelola Profil</h1>
                    </nav>
                </div>

                <!-- Konten Utama -->
                <div class="p-6 rounded-lg bg-white border border-gray-200 shadow-sm">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Avatar & Basic Info -->
                        <div
                            class="md:col-span-1 flex flex-col items-center text-center p-4 bg-green-50 border border-green-100 rounded-xl">
                            <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-white shadow">
                                @php
                                    $avatar = $profils->avatar
                                        ? asset('storage/img/avatars/' . $profils->avatar)
                                        : 'https://ui-avatars.com/api/?background=22c55e&color=fff&name=' .
                                            urlencode($profils->nama ?? 'Admin');
                                @endphp
                                <img src="{{ $avatar }}" alt="Avatar" class="w-full h-full object-cover">
                            </div>
                            <h3 class="mt-4 text-xl font-semibold text-gray-800">{{ $profils->nama ?? '-' }}</h3>
                            <p class="text-sm text-gray-500">{{ $profils->email ?? '-' }}</p>
                            <span
                                class="mt-2 inline-flex items-center px-3 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Admin</span>
                        </div>

                        <!-- Detail Info -->
                        <div class="md:col-span-2 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="p-4 rounded-lg border border-gray-200 bg-gray-50">
                                    <p class="text-xs uppercase tracking-wide text-gray-500">Nama Lengkap</p>
                                    <p class="text-base font-semibold text-gray-800">{{ $profils->nama ?? '-' }}</p>
                                </div>
                                <div class="p-4 rounded-lg border border-gray-200 bg-gray-50">
                                    <p class="text-xs uppercase tracking-wide text-gray-500">Email</p>
                                    <p class="text-base font-semibold text-gray-800">{{ $profils->email ?? '-' }}</p>
                                </div>
                                <div class="p-4 rounded-lg border border-gray-200 bg-gray-50">
                                    <p class="text-xs uppercase tracking-wide text-gray-500">Nomor Telepon</p>
                                    <p class="text-base font-semibold text-gray-800">
                                        {{ $profils->nomor_telepon ?? '-' }}</p>
                                </div>
                                <div class="p-4 rounded-lg border border-gray-200 bg-gray-50">
                                    <p class="text-xs uppercase tracking-wide text-gray-500">Kabupaten</p>
                                    <p class="text-base font-semibold text-gray-800">{{ $profils->kabupaten ?? '-' }}
                                    </p>
                                </div>
                                <div class="md:col-span-2 p-4 rounded-lg border border-gray-200 bg-gray-50">
                                    <p class="text-xs uppercase tracking-wide text-gray-500">Alamat</p>
                                    <p class="text-base font-semibold text-gray-800 leading-relaxed">
                                        {{ $profils->alamat ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <a href="{{ route('admin.profil.edit') }}"
                                    class="inline-flex items-center px-4 py-2 bg-green-500 text-white text-sm font-medium rounded-lg shadow hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M12 20h9" />
                                        <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                                    </svg>
                                    Ubah Profil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- JavaScript -->
    @vite('resources/js/admin/profil/index.js')
</x-app-layout>
