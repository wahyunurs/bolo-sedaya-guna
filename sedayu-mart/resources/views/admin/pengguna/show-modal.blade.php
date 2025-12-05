<!-- Pengguna detail modal -->
<div id="penggunaShowModal" onclick="if(event.target===this) this.remove()"
    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-[1000]">
    <div class="bg-white w-[95%] max-w-2xl p-6 rounded-2xl shadow-lg relative">
        <button id="penggunaShowClose" onclick="document.getElementById('penggunaShowModal')?.remove()" type="button"
            aria-label="Tutup" class="absolute top-4 right-4 p-2 rounded-md border hover:bg-gray-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
        </button>

        <h2 class="text-2xl font-bold text-green-800 mb-3">Detail Pengguna</h2>
        <div class="-mx-6 h-px bg-gray-200 mb-6"></div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="col-span-1 flex items-center justify-center">
                @if (!empty($user->avatar))
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="avatar"
                        class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-lg">
                @else
                    <div
                        class="w-28 h-28 rounded-full bg-gray-100 flex items-center justify-center text-gray-700 font-bold text-2xl border-4 border-white shadow-lg">
                        {{ strtoupper(substr($user->nama ?? ($user->name ?? 'U'), 0, 1)) }}
                    </div>
                @endif
            </div>

            <div class="col-span-2">
                <div class="space-y-2 text-sm text-gray-700">
                    <div>
                        <p class="text-sm text-gray-500">Nama</p>
                        <p class="font-semibold text-gray-900">{{ $user->nama ?? ($user->name ?? '-') }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-semibold text-gray-900">{{ $user->email ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Nomor Telepon</p>
                        <p class="font-semibold text-gray-900">{{ $user->nomor_telepon ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Role</p>
                        <p class="font-semibold text-gray-900">{{ $user->role ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Alamat</p>
                        <p class="font-medium text-gray-800">{{ $user->alamat ?? '-' }}</p>
                    </div>

                    <div class="pt-3 border-t mt-6">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Terdaftar</span>
                            <span
                                class="text-sm text-gray-700">{{ optional($user->created_at)->format('d M Y') ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
