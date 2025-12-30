@component('user.components.user-layout')
    @include('user.components.navbar')

    <section class="pt-16 sm:pt-20 pb-8 sm:pb-12 lg:pb-16 bg-[#e9ffe1] min-h-screen">

        <!-- Modal Flash Message -->
        @include('user.components.message-modal')

        <div class="max-w-5xl mx-auto px-4 sm:px-6">

            <!-- HEADER -->
            <div
                class="w-full bg-gradient-to-r from-[#209416] to-[#46de67] px-4 sm:px-6 lg:px-8 py-8 sm:py-10 lg:py-12 rounded-b-2xl sm:rounded-b-3xl relative overflow-hidden">
                <div class="w-full pr-20 sm:pr-24 lg:pr-0 lg:w-2/3">
                    <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight">Profil Saya
                    </h1>
                    <p class="font-semibold text-white mt-2 sm:mt-3 lg:mt-4 text-base sm:text-lg lg:text-xl line-clamp-2">
                        {{ $user->nama ?? '-' }}</p>
                </div>

                <!-- Avatar on the right -->
                <div class="absolute right-3 sm:right-4 lg:right-6 top-1/2 -translate-y-1/2 flex items-center">
                    @if (!empty($user->avatar))
                        <img src="{{ asset('storage/img/avatars' . $user->avatar) }}" alt="avatar"
                            class="w-16 h-16 sm:w-20 sm:h-20 lg:w-28 lg:h-28 rounded-full object-cover border-2 sm:border-3 lg:border-4 border-white shadow-lg">
                    @else
                        <div
                            class="w-16 h-16 sm:w-20 sm:h-20 lg:w-28 lg:h-28 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-lg sm:text-xl lg:text-2xl border-2 sm:border-3 lg:border-4 border-white shadow-lg">
                            {{ strtoupper(substr($user->nama ?? 'U', 0, 1)) }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- PROFILE DETAILS CARD -->
            <div class="bg-white p-4 sm:p-6 lg:p-8 rounded-xl sm:rounded-2xl shadow mt-4 sm:mt-6 lg:mt-8">
                <div class="flex items-center justify-between mb-4 sm:mb-6 gap-2">
                    <h2 class="text-lg sm:text-xl lg:text-2xl font-extrabold text-green-800">Informasi Akun</h2>
                    <a href="{{ route('user.profil.edit') ?? '#' }}"
                        class="text-sm sm:text-base text-green-700 hover:text-green-900 font-semibold whitespace-nowrap">Ubah
                        Profil</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label class="text-sm text-gray-600">Nama</label>
                        <p class="font-medium text-gray-800 mt-1">{{ $user->nama ?? '-' }}</p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Email</label>
                        <p class="font-medium text-gray-800 mt-1">{{ $user->email ?? '-' }}</p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Nomor Telepon</label>
                        <p class="font-medium text-gray-800 mt-1">{{ $user->nomor_telepon ?? '-' }}</p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Role</label>
                        <p class="font-medium text-gray-800 mt-1">{{ ucfirst($user->role ?? 'user') }}</p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-sm text-gray-600">Alamat</label>
                        <p class="font-medium text-gray-800 mt-1">{{ $user->alamat ?? '-' }}</p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Kabupaten</label>
                        <p class="font-medium text-gray-800 mt-1">{{ $user->kabupaten ?? '-' }}</p>
                    </div>

                    {{-- <div>
                        <label class="text-sm text-gray-600">Provinsi</label>
                        <p class="font-medium text-gray-800 mt-1">{{ $user->provinsi ?? '-' }}</p>
                    </div> --}}
                </div>
            </div>

        </div>
    </section>
@endcomponent
