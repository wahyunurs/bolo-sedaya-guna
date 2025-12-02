<x-guest-layout>
    <!-- NAVBAR -->
    @include('guest.components.navbar')

    <!-- BERANDA GUEST -->
    @include('guest.section.beranda')

    <!-- TENTANG GUEST -->
    @include('guest.section.tentang')

    <!-- PRODUK GUEST -->
    @include('guest.section.produk')

    <!-- KONTAK GUEST -->
    @include('guest.section.kontak')

    <!-- FOOTER -->
    @include('guest.components.footer')
</x-guest-layout>
