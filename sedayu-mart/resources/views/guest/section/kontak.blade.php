<!-- KONTAK GUEST -->
<section id="kontak" class="py-20 bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <!-- Judul -->
        <header class="text-center mb-20 mt-6">
            <h2 class="text-4xl md:text-5xl font-extrabold text-black tracking-wide">
                KONTAK <span class="text-[#40b344]">KAMI</span>
            </h2>
        </header>

        <!-- Grid Card -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

            <!-- Card Informasi Kantor -->
            <div class="p-10 rounded-2xl border border-[#bdbdbd]">
                <h3 class="text-3xl font-bold text-green-900 mb-6 text-center">Informasi Kantor</h3>

                <div class="space-y-4 text-gray-800 text-lg">
                    <p>
                        <span class="font-semibold text-green-800">Nama</span> :
                        Sedayu Mart - Desa Brenggolo
                    </p>
                    <p>
                        <span class="font-semibold text-green-800">Alamat Kantor</span> : <br>
                        Dusun Brenggolo, Kecamatan Jatiroto, <br>
                        Kabupaten Wonogiri
                    </p>
                    <p>
                        <span class="font-semibold text-green-800">Email</span> :
                        sedayumart@example.com
                    </p>
                    <p>
                        <span class="font-semibold text-green-800">Telepon</span> :
                        +62 812-3456-7890
                    </p>
                </div>

                <!-- Tombol WA -->
                <div class="mt-10 flex justify-center">
                    <a href="https://wa.me/6281234567890" target="_blank"
                        class="flex items-center justify-center gap-3 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-8 rounded-full text-lg shadow-md transition">
                        <img src="{{ asset('img/icons/whatsapp.png') }}" class="w-6 h-6" alt="WA">
                        Hubungi Via WhatsApp
                    </a>
                </div>
            </div>

            <!-- Card Maps -->
            <div class="rounded-2xl overflow-hidden border border-[#bdbdbd]">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31614.06564588271!2d111.14592534288492!3d-7.920305994592108!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e797f5fec7a61a1%3A0x5027a76e356a090!2sBrenggolo%2C%20Kec.%20Jatiroto%2C%20Kabupaten%20Wonogiri%2C%20Jawa%20Tengah!5e0!3m2!1sid!2sid!4v1764351153265!5m2!1sid!2sid"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

    </div>
</section>
