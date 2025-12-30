<!-- Navbar -->
<header
    class="flex justify-between items-center bg-white/80 backdrop-blur-md shadow-lg border-b border-gray-100 px-4 sm:px-6 h-16 fixed top-0 w-full md:w-[calc(100%-16rem)] md:ml-64 peer-checked:md:w-full peer-checked:md:ml-0 z-30 transition-all duration-300">

    <!-- Hamburger (toggle sidebar) -->
    <label for="menu-toggle"
        class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 focus:outline-none focus:ring-2 focus:ring-blue-300 cursor-pointer transition-all duration-300 hover:shadow-md">
        <span class="sr-only">Open main menu</span>
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M4 6C4 5.44772 4.44772 5 5 5H19C19.5523 5 20 5.44772 20 6C20 6.55228 19.5523 7 19 7H5C4.44772 7 4 6.55228 4 6Z"
                fill="currentColor" />
            <path
                d="M4 12C4 11.4477 4.44772 11 5 11H19C19.5523 11 20 11.4477 20 12C20 12.5523 19.5523 13 19 13H5C4.44772 13 4 12.5523 4 12Z"
                fill="currentColor" />
            <path
                d="M5 17C4.44772 17 4 17.4477 4 18C4 18.5523 4.44772 19 5 19H19C19.5523 19 20 18.5523 20 18C20 17.4477 19.5523 17 19 17H5Z"
                fill="currentColor" />
        </svg>
    </label>

    <a href="{{ route('admin.dashboard') }}" id="navbar-logo"
        class="flex items-center gap-3 transition-all duration-300 ml-3 md:hidden peer-checked:hidden hover:scale-105">
        <img src="{{ asset('img/logo/sedayumart.png') }}" alt="SedayuMart Logo" class="w-10 h-10 object-contain" />
        <div class="leading-tight text-xl font-semibold">
            <span class="text-[#079100]">Sedayu</span><span class="text-[#ffea00]">Mart</span>
        </div>
    </a>

    <div class="flex items-center space-x-2 sm:space-x-3">
        <!-- Wrapper untuk menggunakan focus-within -->
        <div class="relative group focus-within:block">

            @php
                $user = Auth::user();
                $avatar = $user->avatar ?? null;
                if ($avatar) {
                    $profilePhoto = \Illuminate\Support\Str::startsWith($avatar, ['http://', 'https://'])
                        ? $avatar
                        : asset($avatar);
                } elseif (!empty($user->profile_photo_url)) {
                    $profilePhoto = $user->profile_photo_url;
                } else {
                    // no avatar available, render inline SVG instead of default image
                    $profilePhoto = null;
                }
            @endphp

            <!-- Tombol Foto Profil -->
            <button
                class="peer flex items-center p-0 border-2 border-blue-500 rounded-full transition-all duration-300 ease-in-out focus:outline-none hover:border-blue-600 hover:shadow-lg hover:scale-105 focus:ring-4 focus:ring-blue-200">
                @if (!empty($profilePhoto))
                    <img src="{{ $profilePhoto }}" class="w-10 h-10 rounded-full object-cover cursor-pointer"
                        alt="Avatar">
                @else
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-white font-semibold text-sm shadow-md">
                        {{ strtoupper(substr($user->name ?? $user->nama, 0, 1)) }}
                    </span>
                @endif
            </button>

            <!-- Dropdown (muncul saat foto profil di klik/focus) -->
            <div
                class="absolute right-0 mt-2 w-56 z-50 hidden peer-focus:block group-hover:block bg-white divide-y divide-gray-100 rounded-xl shadow-2xl border border-gray-100 overflow-hidden">

                <div class="px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600">
                    <span class="block text-sm font-semibold text-white">
                        {{ $user->name ?? $user->nama }}
                    </span>
                    <span class="block text-sm text-blue-100 truncate">
                        {{ $user->email }}
                    </span>
                </div>

                <ul class="py-2 bg-white">
                    <li>
                        <a href="#"
                            class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="text-blue-600">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            Profil
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="text-red-600">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                    <polyline points="16 17 21 12 16 7" />
                                    <line x1="21" y1="12" x2="9" y2="12" />
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</header>
