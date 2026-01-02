@component('user.components.user-layout')
    @include('user.components.navbar')

    <section class="pt-20 sm:pt-24 pb-8 bg-[#e9ffe1] min-h-screen">

        <!-- Modal Flash Message -->
        @include('user.components.message-modal')

        <div class="max-w-3xl mx-auto px-4 sm:px-6">

            <div class="bg-white p-4 sm:p-6 lg:p-8 rounded-xl sm:rounded-2xl shadow mt-4 sm:mt-6">
                <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                    <a href="{{ route('user.profil.index') }}" aria-label="Kembali ke profil"
                        class="text-green-700 hover:text-green-900 p-1 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="sm:w-6 sm:h-6"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-arrow-left-icon inline-block mr-1">
                            <path d="m12 19-7-7 7-7" />
                            <path d="M19 12H5" />
                        </svg>
                    </a>
                    <h2 class="text-lg sm:text-xl lg:text-2xl font-extrabold text-green-800">Ubah Profil</h2>
                </div>

                <form action="{{ route('user.produk.alamatPengiriman.update', $alamatPengiriman->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-3 sm:gap-4">
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Nama Penerima</label>
                            <input type="text" name="nama_penerima"
                                value="{{ old('nama_penerima', $alamatPengiriman->nama_penerima) }}"
                                class="w-full p-2 sm:p-2.5 border rounded-lg text-xs sm:text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                required />
                        </div>
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Pilih Lokasi di Peta
                                (Jawa Tengah)</label>
                            <div id="map" class="w-full rounded-xl border mt-2 mb-2" style="height: 300px;"></div>
                        </div>
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Alamat</label>
                            <textarea name="alamat" id="alamatInput" rows="3"
                                class="w-full p-2 sm:p-2.5 border rounded-lg text-xs sm:text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                required>{{ old('alamat', $alamatPengiriman->alamat) }}</textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Kabupaten</label>
                                <input type="text" name="kabupaten" id="kabupatenInput"
                                    value="{{ old('kabupaten', $alamatPengiriman->kabupaten) }}"
                                    class="w-full p-2 sm:p-2.5 border rounded-lg text-xs sm:text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    required readonly />
                            </div>
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                                <input type="text" name="provinsi" id="provinsiInput"
                                    value="{{ old('provinsi', $alamatPengiriman->provinsi) }}"
                                    class="w-full p-2 sm:p-2.5 border rounded-lg text-xs sm:text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    required readonly />
                            </div>
                        </div>
                        <!-- LEAFLET MAPS -->
                        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
                        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
                        <script>
                            // Koordinat tengah Jawa Tengah
                            const jatengCenter = [-7.150975, 110.140259];
                            const jatengBounds = L.latLngBounds(
                                L.latLng(-8.1, 108.8), // Southwest
                                L.latLng(-5.5, 111.5) // Northeast
                            );

                            // Gunakan koordinat dari alamat jika tersedia (opsional, jika ada field lat/lng di model)
                            let initialLat = jatengCenter[0];
                            let initialLng = jatengCenter[1];
                            // Jika Anda punya field lat/lng di $alamatPengiriman, gunakan di sini
                            // Contoh: initialLat = $alamatPengiriman->lat ?? jatengCenter[0];
                            //         initialLng = $alamatPengiriman->lng ?? jatengCenter[1];

                            var map = L.map('map', {
                                center: [initialLat, initialLng],
                                zoom: 9,
                                maxBounds: jatengBounds,
                                maxBoundsViscosity: 1.0
                            });

                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '© OpenStreetMap contributors'
                            }).addTo(map);

                            // Pin marker
                            var marker = L.marker([initialLat, initialLng], {
                                draggable: true
                            }).addTo(map);

                            function setAlamatFields(alamat, kabupaten, provinsi) {
                                document.getElementById('alamatInput').value = alamat || '';
                                document.getElementById('kabupatenInput').value = kabupaten || '';
                                document.getElementById('provinsiInput').value = provinsi || '';
                            }

                            function reverseGeocode(lat, lng) {
                                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&accept-language=id`)
                                    .then(res => res.json())
                                    .then(data => {
                                        let alamat = data.address.road || data.display_name || '';
                                        let kabupaten = data.address.county || data.address.city || data.address.town || data.address
                                            .village || '';
                                        let provinsi = data.address.state || '';
                                        // Filter hanya Jawa Tengah
                                        if (provinsi !== 'Jawa Tengah') {
                                            setAlamatFields('', '', '');
                                            alert('Lokasi harus di dalam Provinsi Jawa Tengah!');
                                            return;
                                        }
                                        setAlamatFields(alamat, kabupaten, provinsi);
                                    });
                            }

                            marker.on('dragend', function(e) {
                                let pos = marker.getLatLng();
                                // Cek apakah masih dalam bounds
                                if (!jatengBounds.contains(pos)) {
                                    marker.setLatLng([initialLat, initialLng]);
                                    map.panTo([initialLat, initialLng]);
                                    setAlamatFields('', '', '');
                                    alert('Pin hanya boleh di dalam area Provinsi Jawa Tengah!');
                                    return;
                                }
                                reverseGeocode(pos.lat, pos.lng);
                            });

                            // Set alamat awal
                            reverseGeocode(initialLat, initialLng);
                        </script>
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                            <input type="text" name="kode_pos" value="{{ old('kode_pos', $alamatPengiriman->kode_pos) }}"
                                class="w-full p-2 sm:p-2.5 border rounded-lg text-xs sm:text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                required />
                        </div>
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                            <input type="text" name="nomor_telepon"
                                value="{{ old('nomor_telepon', $alamatPengiriman->nomor_telepon) }}"
                                class="w-full p-2 sm:p-2.5 border rounded-lg text-xs sm:text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                required />
                        </div>
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                            <textarea name="keterangan" rows="2"
                                class="w-full p-2 sm:p-2.5 border rounded-lg text-xs sm:text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('keterangan', $alamatPengiriman->keterangan) }}</textarea>
                        </div>
                        <div class="flex items-center gap-2 mt-2">
                            <input type="checkbox" name="utama" id="utama" value="1"
                                {{ old('utama', $alamatPengiriman->utama) ? 'checked' : '' }}>
                            <label for="utama" class="text-sm">Jadikan alamat utama</label>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-end gap-2 sm:gap-3 mt-4 sm:mt-6">
                            <a href="{{ route('user.produk.alamatPengiriman') }}"
                                class="w-full sm:w-auto text-center px-4 sm:px-5 py-2 sm:py-2.5 rounded-lg border text-xs sm:text-sm font-medium hover:bg-gray-50 transition-colors">Batal</a>
                            <button type="submit"
                                class="w-full sm:w-auto px-5 sm:px-6 py-2 sm:py-2.5 rounded-lg bg-green-600 text-white text-xs sm:text-sm font-medium hover:bg-green-700 transition-colors">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </section>
@endcomponent
