<x-app-layout>

    <!-- Sidebar toggle -->
    <input id="menu-toggle" type="checkbox" class="peer sr-only" />

    <!-- Sidebar -->
    @include('admin.components.sidebar')

    <!-- Navbar -->
    @include('admin.components.navbar')

    <!-- Main Content -->
    <main class="ml-0 md:ml-64 peer-checked:md:ml-0 mt-16 transition-all duration-300">
        <section class="py-10 bg-[#f0ffeb] min-h-screen">

            <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow border">

                <h1 class="text-2xl font-bold mb-6 text-gray-800">
                    Pin Lokasi & Ambil Kabupaten (FIX)
                </h1>

                <!-- FORM -->
                <form method="POST" action="#">
                    @csrf

                    <!-- Kabupaten -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Kabupaten / Kota</label>
                        <input type="text" id="kabupaten" name="kabupaten" readonly
                            class="w-full border rounded px-3 py-2 bg-gray-100"
                            placeholder="Kabupaten / Kota akan terisi otomatis">
                    </div>

                    <!-- Kecamatan -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Kecamatan</label>
                        <input type="text" id="kecamatan" name="kecamatan" readonly
                            class="w-full border rounded px-3 py-2 bg-gray-100"
                            placeholder="Kecamatan akan terisi otomatis">
                    </div>

                    <!-- LAT LNG (OPSIONAL) -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Latitude</label>
                            <input id="latitude" name="latitude" readonly
                                class="w-full border rounded px-3 py-2 bg-gray-100">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Longitude</label>
                            <input id="longitude" name="longitude" readonly
                                class="w-full border rounded px-3 py-2 bg-gray-100">
                        </div>
                    </div>

                    <!-- MAP -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Pin Lokasi</label>
                        <div id="map" class="w-full h-[400px] rounded border"></div>
                    </div>

                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Simpan
                    </button>
                </form>
            </div>
        </section>
    </main>

</x-app-layout>

<!-- GOOGLE MAPS -->
<script src="https://maps.googleapis.com/maps/api/js?key=API_KEY_ANDA&callback=initMap" async defer></script>

<script>
    let map, marker, geocoder;

    function initMap() {
        geocoder = new google.maps.Geocoder();

        const defaultLocation = {
            lat: -6.200000,
            lng: 106.816666
        }; // Jakarta

        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultLocation,
            zoom: 13,
        });

        marker = new google.maps.Marker({
            position: defaultLocation,
            map: map,
            draggable: true,
        });

        // Initial load
        reverseGeocode(defaultLocation);

        // Drag pin
        marker.addListener("dragend", function() {
            const pos = marker.getPosition();
            reverseGeocode(pos);
        });

        // Click map
        map.addListener("click", function(e) {
            marker.setPosition(e.latLng);
            reverseGeocode(e.latLng);
        });
    }

    function reverseGeocode(latlng) {
        geocoder.geocode({
            location: latlng
        }, function(results, status) {
            if (status === "OK" && results[0]) {
                fillAddress(results[0]);
                document.getElementById("latitude").value = latlng.lat();
                document.getElementById("longitude").value = latlng.lng();
            }
        });
    }

    function getComponent(components, type) {
        const found = components.find(c => c.types.includes(type));
        return found ? found.long_name : null;
    }

    function fillAddress(result) {
        const components = result.address_components;

        // ===============================
        // KABUPATEN / KOTA (LEVEL 2 ONLY)
        // ===============================
        let kabupaten =
            getComponent(components, "administrative_area_level_2") ||
            getComponent(components, "city") ||
            getComponent(components, "county");

        // ===============================
        // KECAMATAN (LEVEL 3)
        // ===============================
        let kecamatan =
            getComponent(components, "administrative_area_level_3") ||
            getComponent(components, "suburb");

        // ===============================
        // PROTEKSI KERAS
        // ===============================
        if (kabupaten && kecamatan &&
            kabupaten.toLowerCase() === kecamatan.toLowerCase()) {
            kabupaten = "";
        }

        document.getElementById("kabupaten").value = kabupaten ?? "";
        document.getElementById("kecamatan").value = kecamatan ?? "";
    }
</script>
