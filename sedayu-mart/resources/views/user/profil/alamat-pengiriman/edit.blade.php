@component('user.components.user-layout')
    @include('user.components.navbar')

    <section class="pt-16 sm:pt-20 pb-8 sm:pb-12 lg:pb-16 bg-[#e9ffe1] min-h-screen">
        @include('user.components.message-modal')
        <div class="w-full px-0 sm:px-0 max-w-2xl mx-auto">
            <!-- HEADER -->
            <div class="w-full flex items-center justify-between mb-6 px-4 sm:px-6">
                <h1 class="text-2xl font-bold text-green-800">Edit Alamat Pengiriman</h1>
            </div>

            <form method="POST" action="{{ route('user.profil.alamatPengiriman.update', $alamatPengiriman->id) }}"
                class="bg-white rounded-xl shadow p-6 space-y-5" id="alamatForm">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-4">
                    <!-- Hidden input untuk koordinat -->
                    <input type="hidden" name="latitude" id="latitudeInput"
                        value="{{ old('latitude', $alamatPengiriman->latitude) }}">
                    <input type="hidden" name="longitude" id="longitudeInput"
                        value="{{ old('longitude', $alamatPengiriman->longitude) }}">
                    <div>
                        <label class="font-semibold text-gray-700">Nama Penerima</label>
                        <input type="text" name="nama_penerima" class="mt-1 w-full border rounded-lg p-2" required
                            value="{{ old('nama_penerima', $alamatPengiriman->nama_penerima) }}">
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">Nomor Telepon</label>
                        <input type="text" name="nomor_telepon" class="mt-1 w-full border rounded-lg p-2" required
                            value="{{ old('nomor_telepon', $alamatPengiriman->nomor_telepon) }}">
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-gray-700">Pilih Lokasi di Peta (Jawa Tengah)</label>
                    <div id="map" class="w-full rounded-xl border mt-2" style="height: 300px;"></div>
                </div>

                <div>
                    <label class="font-semibold text-gray-700">Alamat (Nama Jalan)</label>
                    <input type="text" name="alamat" id="alamatInput" class="mt-1 w-full border rounded-lg p-2" required
                        value="{{ old('alamat', $alamatPengiriman->alamat) }}" readonly>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold text-gray-700">Kabupaten</label>
                        <input type="text" name="kabupaten" id="kabupatenInput" class="mt-1 w-full border rounded-lg p-2"
                            required value="{{ old('kabupaten', $alamatPengiriman->kabupaten) }}" readonly>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">Provinsi</label>
                        <input type="text" name="provinsi" id="provinsiInput" class="mt-1 w-full border rounded-lg p-2"
                            required value="{{ old('provinsi', $alamatPengiriman->provinsi) }}" readonly>
                    </div>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">Kode Pos</label>
                    <input type="text" name="kode_pos" class="mt-1 w-full border rounded-lg p-2" required
                        value="{{ old('kode_pos', $alamatPengiriman->kode_pos) }}">
                </div>
                <div>
                    <label class="font-semibold text-gray-700">Keterangan (Opsional)</label>
                    <input type="text" name="keterangan" class="mt-1 w-full border rounded-lg p-2"
                        value="{{ old('keterangan', $alamatPengiriman->keterangan) }}">
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="utama" id="utamaInput" value="1" class="rounded"
                        {{ old('utama', $alamatPengiriman->utama) ? 'checked' : '' }}>
                    <label for="utamaInput" class="font-semibold text-gray-700">Jadikan Alamat Utama</label>
                </div>
                <div class="flex justify-end">
                    <button
                        class="px-6 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold shadow transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </section>

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

        // Default ke alamat lama jika ada, fallback ke tengah Jateng
        var defaultLat = {{ $alamatPengiriman->latitude ?? '-7.150975' }};
        var defaultLng = {{ $alamatPengiriman->longitude ?? '110.140259' }};

        var map = L.map('map', {
            center: [defaultLat, defaultLng],
            zoom: 12,
            maxBounds: jatengBounds,
            maxBoundsViscosity: 1.0
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Pin marker
        var marker = L.marker([defaultLat, defaultLng], {
            draggable: true
        }).addTo(map);

        function setAlamatFields(alamat, kabupaten, provinsi) {
            document.getElementById('alamatInput').value = alamat || '';
            document.getElementById('kabupatenInput').value = kabupaten || '';
            document.getElementById('provinsiInput').value = provinsi || '';
        }

        function setLatLngFields(lat, lng) {
            document.getElementById('latitudeInput').value = lat;
            document.getElementById('longitudeInput').value = lng;
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
                marker.setLatLng([defaultLat, defaultLng]);
                map.panTo([defaultLat, defaultLng]);
                setAlamatFields('', '', '');
                setLatLngFields(defaultLat, defaultLng);
                alert('Pin hanya boleh di dalam area Provinsi Jawa Tengah!');
                return;
            }
            setLatLngFields(pos.lat, pos.lng);
            reverseGeocode(pos.lat, pos.lng);
        });

        // Set alamat awal dan koordinat awal
        setLatLngFields(defaultLat, defaultLng);
        reverseGeocode(defaultLat, defaultLng);
    </script>
@endcomponent
