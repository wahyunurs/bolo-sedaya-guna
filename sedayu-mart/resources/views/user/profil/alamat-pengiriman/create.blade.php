@component('user.components.user-layout')
    @include('user.components.navbar')

    <section class="pt-16 sm:pt-20 pb-8 sm:pb-12 lg:pb-16 bg-[#e9ffe1] min-h-screen">
        @include('user.components.message-modal')
        <div class="w-full px-0 sm:px-0 max-w-2xl mx-auto">
            <!-- HEADER -->
            <div class="w-full flex items-center justify-between mb-6 px-4 sm:px-6">
                <h1 class="text-2xl font-bold text-green-800">Tambah Alamat Pengiriman</h1>
            </div>

            <form method="POST" action="{{ route('user.profil.alamatPengiriman.store') }}"
                class="bg-white rounded-xl shadow p-6 space-y-5" id="alamatForm">
                @csrf

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="font-semibold text-gray-700">Nama Penerima</label>
                        <input type="text" name="nama_penerima" class="mt-1 w-full border rounded-lg p-2" required>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">Nomor Telepon</label>
                        <input type="text" name="nomor_telepon" class="mt-1 w-full border rounded-lg p-2" required>
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-gray-700">Pilih Lokasi di Peta (Jawa Tengah)</label>
                    <div id="map" class="w-full rounded-xl border mt-2" style="height: 300px;"></div>
                </div>

                <div>
                    <label class="font-semibold text-gray-700">Alamat (Nama Jalan)</label>
                    <input type="text" name="alamat" id="alamatInput" class="mt-1 w-full border rounded-lg p-2" required
                        readonly>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold text-gray-700">Kabupaten</label>
                        <input type="text" name="kabupaten" id="kabupatenInput" class="mt-1 w-full border rounded-lg p-2"
                            required readonly>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">Provinsi</label>
                        <input type="text" name="provinsi" id="provinsiInput" class="mt-1 w-full border rounded-lg p-2"
                            required readonly>
                    </div>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">Kode Pos</label>
                    <input type="text" name="kode_pos" class="mt-1 w-full border rounded-lg p-2" required>
                </div>
                <div>
                    <label class="font-semibold text-gray-700">Keterangan (Opsional)</label>
                    <input type="text" name="keterangan" class="mt-1 w-full border rounded-lg p-2">
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="utama" id="utamaInput" value="1" class="rounded">
                    <label for="utamaInput" class="font-semibold text-gray-700">Jadikan Alamat Utama</label>
                </div>
                <div class="flex justify-end">
                    <button
                        class="px-6 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold shadow transition">
                        Simpan Alamat
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

        var map = L.map('map', {
            center: jatengCenter,
            zoom: 9,
            maxBounds: jatengBounds,
            maxBoundsViscosity: 1.0
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Pin marker
        var marker = L.marker(jatengCenter, {
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
                marker.setLatLng(jatengCenter);
                map.panTo(jatengCenter);
                setAlamatFields('', '', '');
                alert('Pin hanya boleh di dalam area Provinsi Jawa Tengah!');
                return;
            }
            reverseGeocode(pos.lat, pos.lng);
        });

        // Set alamat awal
        reverseGeocode(jatengCenter[0], jatengCenter[1]);
    </script>
@endcomponent
