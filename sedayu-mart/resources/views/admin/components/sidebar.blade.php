<!-- Sidebar -->
<aside
    class="w-64 bg-white h-screen shadow-md fixed left-0 top-0 flex flex-col transform transition-transform duration-300 -translate-x-full md:translate-x-0 peer-checked:translate-x-0 md:peer-checked:-translate-x-full z-40">
    <!-- Logo -->
    <div class="flex items-center gap-2 px-6 py-4 border-b">
        <h1 class="text-xl text-gray-600">Portal<span class="text-xl font-bold text-blue-800">BEMKM</span></h1>
    </div>

    <!-- Menu -->
    <nav class="flex-1 mt-4">
        <ul class="space-y-2">
            <li class="border-l-4 border-blue-900">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center mx-6 p-3 text-sm font-medium rounded-lg group bg-blue-800 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6m-6 0l2 2m-2-2H9m12 0v6a2 2 0 01-2 2h-4m-6 0H5a2 2 0 01-2-2v-6" />
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <!-- Kabinet with dropdown -->
                <input type="checkbox" id="kabinet-toggle" class="peer hidden" />
                <label for="kabinet-toggle"
                    class="flex items-center justify-between mx-6 p-3 text-gray-700 hover:bg-gray-100 rounded-lg cursor-pointer select-none">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M3 4h18v18H3z" />
                        </svg>
                        Kabinet
                    </span>
                    <svg class="w-4 h-4 text-gray-500 transition-transform duration-200 peer-checked:rotate-180"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7" />
                    </svg>
                </label>
                <ul class="mt-1 ml-12 space-y-1 hidden peer-checked:block">
                    <li>
                        <a href="#"
                            class="block px-3 py-2 text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-md">Sambutan
                            Presma</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-3 py-2 text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-md">Visi
                            & Misi</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-3 py-2 text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-md">Struktural</a>
                    </li>
                </ul>
            </li>
            <li>
                <!-- Program Kerja with dropdown -->
                <input type="checkbox" id="kegiatan-toggle" class="peer hidden" />
                <label for="kegiatan-toggle"
                    class="flex items-center justify-between mx-6 p-3 text-gray-700 hover:bg-gray-100 rounded-lg cursor-pointer select-none">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M3 4h18v18H3z" />
                        </svg>
                        Kegiatan
                    </span>
                    <svg class="w-4 h-4 text-gray-500 transition-transform duration-200 peer-checked:rotate-180"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7" />
                    </svg>
                </label>
                <ul class="mt-1 ml-12 space-y-1 hidden peer-checked:block">
                    <li>
                        <a href="#"
                            class="block px-3 py-2 text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-md">Program
                            Kerja</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-3 py-2 text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-md">Pendaftaran</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" class="flex items-center mx-6 p-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M4 4h16v16H4z" />
                    </svg>
                    Postingan
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center mx-6 p-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M4 4h16v16H4z" />
                    </svg>
                    Partnership
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center mx-6 p-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M3 3h18v18H3z" />
                    </svg>
                    Kontak
                </a>
            </li>
        </ul>
    </nav>
</aside>
