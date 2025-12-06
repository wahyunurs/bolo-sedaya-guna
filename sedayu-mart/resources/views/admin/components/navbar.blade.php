<!-- Navbar -->
<header
    class="flex justify-between items-center bg-white shadow-sm px-6 py-3 fixed top-0 w-full md:w-[calc(100%-16rem)] md:ml-64 peer-checked:md:w-full peer-checked:md:ml-0 z-30 transition-all duration-300">

    <!-- Hamburger (toggle sidebar) -->
    <label for="menu-toggle"
        class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-600 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 cursor-pointer">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M1 1h15M1 7h15M1 13h15" />
        </svg>
    </label>

    <a href="{{ route('admin.dashboard') }}" id="navbar-logo"
        class="flex items-center transition-all duration-300 ml-3 md:hidden peer-checked:hidden">
        <img src="{{ asset('img/logo/sedayumart.png') }}" class="h-8 me-3" alt="Tani Desa Logo">
        <span class="self-center text-2xl font-bold text-green-600">Tani</span>
        <span class="self-center text-2xl font-bold text-gray-800">Desa</span>
    </a>

    <div class="flex items-center space-x-3">
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
                class="peer flex items-center p-0 border-2 border-[#065f46] rounded-full transition-all duration-200 ease-in-out focus:outline-none peer-focus:border-4">
                @if (!empty($profilePhoto))
                    <img src="{{ $profilePhoto }}" class="w-10 h-10 rounded-full object-cover cursor-pointer"
                        alt="Avatar">
                @else
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-user-round-icon lucide-user-round w-6 h-6">
                            <circle cx="12" cy="8" r="5" />
                            <path d="M20 21a8 8 0 0 0-16 0" />
                        </svg>
                    </span>
                @endif
            </button>

            <!-- Dropdown (muncul saat foto profil di klik/focus) -->
            <div
                class="absolute right-0 mt-2 w-56 z-50 hidden peer-focus:block group-hover:block bg-white divide-y divide-gray-200 rounded-lg shadow-lg">

                <div class="px-4 py-3 bg-gray-100 rounded-t-lg">
                    <span class="block text-sm font-semibold text-gray-800">
                        {{ Auth::user()->name ?? Auth::user()->nama }}
                    </span>
                    <span class="block text-sm text-gray-500 truncate">
                        {{ Auth::user()->email }}
                    </span>
                </div>

                <ul class="py-2 bg-white rounded-b-lg">
                    <li>
                        <a href="{{ route('admin.profil.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                            Profil
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-100 hover:text-red-700 transition">
                                Keluar
                            </button>
                        </form>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</header>
