@component('user.components.user-layout')
    @include('user.components.navbar')

    <section class="pt-16 sm:pt-20 pb-8 sm:pb-12 lg:pb-16 bg-[#e9ffe1] min-h-screen">
        <div class="w-full px-0 sm:px-0 max-w-2xl mx-auto">
            <!-- HEADER -->
            <div class="w-full flex items-center justify-between mb-6 px-4 sm:px-6">
                <h1 class="text-2xl font-bold text-green-800">Tambah Alamat Pengiriman</h1>
            </div>

            <form method="POST" action="{{ route('user.produk.alamatPengiriman.store') }}"
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
                    <input type="text" name="alamat" id="alamatInput" class="mt-1 w-full border rounded-lg p-2"
                        required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold text-gray-700">Kabupaten</label>

                        <div class="relative">
                            <input type="hidden" name="kabupaten" id="kabupatenInput">

                            <input type="text" id="kabupatenSearch" class="mt-1 w-full border rounded-lg p-2"
                                placeholder="Pilih Kabupaten">

                            <ul id="kabupatenList"
                                class="absolute left-0 right-0 mt-1 max-h-40 overflow-auto bg-white border rounded shadow z-50 hidden">
                                @foreach ($kabupatens as $kab)
                                    <li data-value="{{ $kab }}"
                                        class="px-3 py-2 text-sm cursor-pointer hover:bg-green-500 hover:text-white">
                                        {{ $kab }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
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

    <!-- LEAFLET -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        /* ================= MAP INIT ================= */
        const jatengCenter = [-7.150975, 110.140259];
        const jatengBounds = L.latLngBounds(
            L.latLng(-8.1, 108.8),
            L.latLng(-5.5, 111.5)
        );

        const map = L.map('map', {
            center: jatengCenter,
            zoom: 9,
            maxBounds: jatengBounds,
            maxBoundsViscosity: 1.0
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        const marker = L.marker(jatengCenter, {
            draggable: true
        }).addTo(map);

        /* ================= FIELD REF ================= */
        const alamatInput = document.getElementById('alamatInput');
        const kabupatenInput = document.getElementById('kabupatenInput');
        const provinsiInput = document.getElementById('provinsiInput');
        const kabupatenSearch = document.getElementById('kabupatenSearch');
        const kabupatenList = document.getElementById('kabupatenList');
        const kabupatenOptions = Array.from(kabupatenList.querySelectorAll('li'))
            .map(li => li.dataset.value);

        /* ================= UTIL ================= */
        function normalize(str) {
            return str.toLowerCase().replace(/kabupaten |kota /i, '').trim();
        }

        function matchKabupatenFromMap(rawKab) {
            if (!rawKab) return null;

            const key = normalize(rawKab);

            return kabupatenOptions.find(opt =>
                normalize(opt) === key
            );
        }

        /* ================= MAP → FIELD ================= */
        function reverseGeocode(lat, lng) {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&accept-language=id`)
                .then(res => res.json())
                .then(data => {
                    const addr = data.address || {};
                    const provinsi = addr.state || '';
                    const kabRaw = addr.county || addr.city || addr.town || '';

                    if (provinsi !== 'Jawa Tengah') {
                        alert('Lokasi harus di Jawa Tengah');
                        marker.setLatLng(jatengCenter);
                        map.panTo(jatengCenter);
                        return;
                    }

                    alamatInput.value = addr.road || data.display_name || '';
                    provinsiInput.value = provinsi;

                    const kabMatch = matchKabupatenFromMap(kabRaw);
                    if (kabMatch) {
                        setKabupaten(kabMatch);
                    }
                });
        }

        marker.on('dragend', e => {
            const pos = e.target.getLatLng();
            if (!jatengBounds.contains(pos)) {
                marker.setLatLng(jatengCenter);
                map.panTo(jatengCenter);
                return;
            }
            reverseGeocode(pos.lat, pos.lng);
        });

        reverseGeocode(jatengCenter[0], jatengCenter[1]);

        /* ================= KABUPATEN → MAP ================= */
        function moveMapByKabupaten(kab) {
            if (!kab) return;

            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${kab}+Jawa+Tengah`)
                .then(res => res.json())
                .then(data => {
                    if (data[0]) {
                        const lat = data[0].lat;
                        const lon = data[0].lon;
                        map.setView([lat, lon], 11);
                        marker.setLatLng([lat, lon]);
                    }
                });
        }

        function setKabupaten(val) {
            kabupatenInput.value = val;
            kabupatenSearch.value = val;
            moveMapByKabupaten(val);
        }

        /* ================= DROPDOWN ================= */
        kabupatenSearch.addEventListener('focus', () => kabupatenList.classList.remove('hidden'));

        kabupatenSearch.addEventListener('input', () => {
            const q = kabupatenSearch.value.toLowerCase();
            kabupatenList.querySelectorAll('li').forEach(li => {
                li.style.display = li.innerText.toLowerCase().includes(q) ? 'block' : 'none';
            });
        });

        kabupatenList.addEventListener('click', e => {
            if (e.target.tagName === 'LI') {
                setKabupaten(e.target.dataset.value);
                kabupatenList.classList.add('hidden');
            }
        });

        document.addEventListener('click', e => {
            if (!e.target.closest('#kabupatenSearch')) {
                kabupatenList.classList.add('hidden');
            }
        });
    </script>
@endcomponent
