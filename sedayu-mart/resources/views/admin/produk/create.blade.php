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
                            <li><a href="{{ route('admin.produk.index') }}"
                                    class="text-green-600 font-semibold">Produk</a></li>
                            <li><span class="text-green-400">></span></li>
                            <li class="text-green-700">Buat</li>
                        </ol>
                        <h1 class="text-3xl font-bold text-gray-800 mt-2">Buat Produk</h1>
                    </nav>
                </div>

                <!-- Form Tambah / Edit Produk -->
                <div class="p-6 rounded-lg bg-white shadow-lg border border-gray-200">
                    @if (isset($produk))
                        <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST"
                            enctype="multipart/form-data" class="space-y-6">
                            @method('PUT')
                        @else
                            <form action="{{ route('admin.produk.store') }}" method="POST"
                                enctype="multipart/form-data" class="space-y-6">
                    @endif
                    @csrf

                    <!-- Nama -->
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                        <input type="text" name="nama" id="nama" required
                            value="{{ old('nama', $produk->nama ?? '') }}"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Masukkan nama produk">
                    </div>

                    <!-- Harga -->
                    <div>
                        <label for="harga" class="block text-sm font-medium text-gray-700">Harga</label>
                        <input type="number" name="harga" id="harga" required
                            value="{{ old('harga', $produk->harga ?? '') }}"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Masukkan harga (tanpa pemisah)">
                    </div>

                    <!-- Berat -->
                    <div>
                        <label for="berat" class="block text-sm font-medium text-gray-700">Berat (gram)</label>
                        <input type="number" name="berat" id="berat" required
                            value="{{ old('berat', $produk->berat ?? '') }}"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Berat dalam gram">
                    </div>

                    <!-- Stok -->
                    <div>
                        <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                        <input type="number" name="stok" id="stok" required
                            value="{{ old('stok', $produk->stok ?? 0) }}"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Jumlah stok">
                    </div>

                    <!-- Satuan -->
                    <div>
                        <label for="satuan_produk" class="block text-sm font-medium text-gray-700">Satuan</label>
                        <input type="text" name="satuan_produk" id="satuan_produk" required
                            value="{{ old('satuan_produk', $produk->satuan_produk ?? '') }}"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Contoh: Kg, Liter, Pcs">
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Deskripsi produk">{{ old('deskripsi', $produk->deskripsi ?? '') }}</textarea>
                    </div>

                    <!-- Gambar Produk (maks 5) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gambar Produk (maks 5)</label>
                        <p class="text-sm italic text-gray-500 mt-1">Unggah maksimal 5 gambar. Pilih salah satu
                            sebagai gambar utama.</p>

                        <div class="grid grid-cols-5 gap-3 mt-3">
                            @for ($i = 0; $i < 5; $i++)
                                <div class="border rounded p-2 text-center">
                                    <div
                                        class="w-full h-24 bg-gray-100 rounded mb-2 overflow-hidden flex items-center justify-center">
                                        <img id="preview-{{ $i }}" src="" alt="preview"
                                            class="object-cover w-full h-full hidden">
                                        <div id="placeholder-{{ $i }}"
                                            class="flex items-center justify-center w-full h-full text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-upload">
                                                <path d="M12 3v12" />
                                                <path d="m17 8-5-5-5 5" />
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                            </svg>
                                        </div>
                                    </div>

                                    <input type="file" name="gambar[]" accept="image/*"
                                        data-index="{{ $i }}" class="gambar-input text-sm w-full" />

                                    <div class="text-sm mt-2">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="utama_gambar"
                                                value="new_{{ $i }}" class="mr-2"
                                                {{ $i === 0 ? 'checked' : '' }}>
                                            Utama
                                        </label>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    @if (isset($produk) && $produk->gambarProduks->count())
                        <div>
                            <p class="text-sm font-medium text-gray-700">Gambar Saat Ini</p>
                            <div class="grid grid-cols-3 gap-3 mt-3">
                                @foreach ($produk->gambarProduks as $gambar)
                                    <div class="border rounded p-2 text-center">
                                        @php $img = $gambar->gambar; @endphp
                                        <img src="{{ $img ? asset('storage/img/produk/' . $img) : asset('img/card/produk1.png') }}"
                                            class="mx-auto mb-2 h-24 w-24 object-cover rounded" />
                                        <div class="text-sm">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="utama_gambar"
                                                    value="{{ $gambar->id }}" {{ $gambar->utama ? 'checked' : '' }}
                                                    class="mr-2">
                                                Utama
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Tombol Submit -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.produk.index') }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200">Batal</a>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition duration-200">{{ isset($produk) ? 'Perbarui' : 'Simpan' }}</button>
                    </div>

                    </form>
                </div>
            </div>
            </div>
        </section>
    </main>
</x-app-layout>

<!-- Create Produk JavaScript -->
@vite('resources/js/admin/produk/create.js')
