@component('user.components.user-layout')
    @include('user.components.navbar')

    <section class="pt-16 sm:pt-20 pb-8 sm:pb-12 lg:pb-16 bg-[#e9ffe1] min-h-screen">
        @include('user.components.message-modal')
        <div class="w-full px-0 sm:px-0 max-w-2xl mx-auto">
            <!-- HEADER -->
            <div class="w-full flex items-center justify-between mb-6 px-4 sm:px-6">
                <h1 class="text-2xl font-bold text-green-800">Alamat Pengiriman</h1>
                <a href="{{ route('user.profil.alamatPengiriman.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold shadow transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Alamat
                </a>
            </div>

            <!-- DAFTAR ALAMAT -->
            <div class="space-y-4 px-4 sm:px-6">
                @forelse($alamatPengirimans as $alamat)
                    <div
                        class="bg-white rounded-xl shadow flex flex-col sm:flex-row items-start sm:items-center gap-4 p-5 relative">
                        <span class="bg-green-100 text-green-700 rounded-xl p-3 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 12.414a4 4 0 10-5.657 5.657l4.243 4.243a8 8 0 0011.314-11.314l-4.243-4.243a4 4 0 00-5.657 5.657l4.243 4.243z" />
                            </svg>
                        </span>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-gray-900 text-base flex items-center gap-2">
                                {{ $alamat->nama_penerima }}
                                @if ($alamat->utama)
                                    <span
                                        class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded font-semibold">Utama</span>
                                @endif
                            </div>
                            <div class="text-sm text-gray-700 mt-1 break-words">{{ $alamat->alamat }}</div>
                            <div class="text-sm text-gray-500 mt-1">
                                {{ $alamat->kabupaten }}, {{ $alamat->provinsi }} {{ $alamat->kode_pos }}
                            </div>
                            <div class="text-sm text-gray-500 mt-1">
                                Telp: {{ $alamat->nomor_telepon }}
                            </div>
                            @if ($alamat->keterangan)
                                <div class="text-xs text-gray-400 mt-1 italic">{{ $alamat->keterangan }}</div>
                            @endif
                        </div>
                        <div class="flex flex-row gap-2 mt-2 sm:mt-0">
                            <a href="{{ route('user.profil.alamatPengiriman.edit', $alamat->id) }}"
                                class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-gray-100 hover:bg-green-100 text-green-700 transition"
                                title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536M9 11l6 6M3 21h18" />
                                </svg>
                            </a>
                            <button type="button" data-modal-target="delete-alamat-modal-{{ $alamat->id }}"
                                data-modal-toggle="delete-alamat-modal-{{ $alamat->id }}"
                                class="group p-2 rounded-lg bg-red-50 hover:bg-red-100 transition-all duration-200 hover:shadow-md"
                                title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="text-red-600 group-hover:text-red-700 transition-colors">
                                    <path d="M3 6h18" />
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                    <line x1="10" x2="10" y1="11" y2="17" />
                                    <line x1="14" x2="14" y1="11" y2="17" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Delete Alamat Modal -->
                    @include('user.profil.alamat-pengiriman.delete', ['alamat' => $alamat])
                @empty
                    <div class="bg-white rounded-xl shadow p-6 text-center text-gray-500">
                        Belum ada alamat pengiriman.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endcomponent
