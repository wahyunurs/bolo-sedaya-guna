<x-app-layout>
    @include('user.components.navbar')

    <section class="py-16 bg-[#e9ffe1] min-h-screen">

        <!-- Modal Flash Message -->
        @include('user.components.message-modal')

        <div class="max-w-3xl mx-auto px-6">

            <div class="bg-white p-8 rounded-2xl shadow">
                <div class="flex items-center gap-3 mb-6">
                    <a href="{{ route('user.profil.index') }}" aria-label="Kembali ke profil"
                        class="text-green-700 hover:text-green-900 p-1 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-arrow-left-icon inline-block mr-1 w-5 h-5">
                            <path d="m12 19-7-7 7-7" />
                            <path d="M19 12H5" />
                        </svg>
                    </a>
                    <h2 class="text-2xl font-extrabold text-green-800">Ubah Profil</h2>
                </div>

                <form action="{{ route('user.profil.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="text-sm text-gray-600">Nama</label>
                            <input type="text" name="nama" value="{{ old('nama', $user->nama) }}"
                                class="w-full mt-1 p-3 border rounded-lg" required />
                        </div>

                        <div>
                            <label class="text-sm text-gray-600">Alamat</label>
                            <textarea name="alamat" rows="3" class="w-full mt-1 p-3 border rounded-lg" required>{{ old('alamat', $user->alamat) }}</textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm text-gray-600">Kabupaten</label>
                                <input type="text" name="kabupaten" value="{{ old('kabupaten', $user->kabupaten) }}"
                                    class="w-full mt-1 p-3 border rounded-lg" required />
                            </div>
                            <div>
                                <label class="text-sm text-gray-600">Provinsi</label>
                                <input type="text" name="provinsi" value="{{ old('provinsi', $user->provinsi) }}"
                                    class="w-full mt-1 p-3 border rounded-lg" />
                            </div>
                        </div>

                        <div>
                            <label class="text-sm text-gray-600">Nomor Telepon</label>
                            <input type="text" name="nomor_telepon"
                                value="{{ old('nomor_telepon', $user->nomor_telepon) }}"
                                class="w-full mt-1 p-3 border rounded-lg" required />
                        </div>

                        <div>
                            <label class="text-sm text-gray-600">Avatar (gambar)</label>
                            <div class="flex items-center gap-4 mt-2">
                                @if (!empty($user->avatar))
                                    <img src="{{ asset('storage/img/avatars/' . $user->avatar) }}" alt="avatar"
                                        class="w-20 h-20 rounded-full object-cover border" />
                                @else
                                    <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center">--
                                    </div>
                                @endif

                                <input type="file" name="avatar" accept="image/*" class="p-2" />
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 mt-4">
                            <a href="{{ route('user.profil.index') }}" class="px-4 py-2 rounded-lg border">Batal</a>
                            <button type="submit" class="px-6 py-2 rounded-lg bg-green-600 text-white">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </section>
</x-app-layout>
