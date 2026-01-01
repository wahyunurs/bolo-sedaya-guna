@component('user.components.user-layout')
    @include('user.components.navbar')

    <section class="pt-16 sm:pt-20 pb-8 sm:pb-12 lg:pb-16 bg-[#e9ffe1] min-h-screen">
        @include('user.components.message-modal')
        <div class="w-full px-0 sm:px-0">
            <!-- HEADER -->
            <div
                class="w-full bg-gradient-to-r from-[#209416] to-[#46de67] px-4 sm:px-6 py-8 rounded-2xl relative overflow-hidden flex flex-col items-center mb-6">
                <div
                    class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-3xl border-4 border-white shadow-lg mb-2">
                    {{ strtoupper(substr($user->nama ?? 'U', 0, 1)) }}
                </div>
                <div class="text-center">
                    <h1 class="text-2xl font-bold text-white leading-tight">{{ $user->nama ?? '-' }}</h1>
                    <p class="text-white text-base mt-1">{{ $user->email ?? '-' }}</p>
                    <p class="text-white text-base mt-1">{{ $user->nomor_telepon ?? '-' }}</p>
                </div>
            </div>

            <!-- MENU LIST -->
            <div class="bg-white rounded-xl shadow divide-y w-full">
                <a href="{{ route('user.profil.dataDiri.edit') }}"
                    class="flex items-center gap-4 px-4 sm:px-6 py-5 hover:bg-gray-50 transition">
                    <span class="bg-green-100 text-green-700 rounded-xl p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536M9 11l6 6M3 21h18" />
                        </svg>
                    </span>
                    <div class="flex-1">
                        <div class="font-bold text-base text-gray-900">Edit Profil</div>
                        <div class="text-sm text-gray-500">Ubah informasi profil Anda</div>
                    </div>
                    <span class="text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                </a>
                <a href="{{ route('user.profil.alamatPengiriman') }}"
                    class="flex items-center gap-4 px-4 sm:px-6 py-5 hover:bg-gray-50 transition">
                    <span class="bg-green-100 text-green-700 rounded-xl p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 12.414a4 4 0 10-5.657 5.657l4.243 4.243a8 8 0 0011.314-11.314l-4.243-4.243a4 4 0 00-5.657 5.657l4.243 4.243z" />
                        </svg>
                    </span>
                    <div class="flex-1">
                        <div class="font-bold text-base text-gray-900">Alamat</div>
                        <div class="text-sm text-gray-500">Kelola alamat pengiriman</div>
                    </div>
                    <span class="text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                </a>
                <a href="{{ route('user.profil.gantiPassword') }}"
                    class="flex items-center gap-4 px-4 sm:px-6 py-5 hover:bg-gray-50 transition">
                    <span class="bg-green-100 text-green-700 rounded-xl p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 11c0-1.104.896-2 2-2s2 .896 2 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </span>
                    <div class="flex-1">
                        <div class="font-bold text-base text-gray-900">Ganti Password</div>
                        <div class="text-sm text-gray-500">Perbarui password Anda</div>
                    </div>
                    <span class="text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    </section>
@endcomponent
