<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

        <a href="index.html" class="logo d-flex align-items-center">
            <h1>PT. PMH Express</h1>
        </a>

        <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
        <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a href="{{ route('beranda') }}" class="@if ($title == 'beranda') active @endif">Beranda</a></li>
                <li><a href="{{ route('tentang-kami') }}" class="@if ($title == 'tentang kami') active @endif">Tentang Kami</a></li>
                <li><a href="{{ route('layanan') }}" class="@if ($title == 'layanan') active @endif">Layanan</a></li>
                <li><a href="{{ route('cek-harga') }}" class="@if ($title == 'cek harga') active @endif">Cek Harga</a></li>
                <li><a href="{{ route('syarat') }}" class="@if ($title == 'syarat') active @endif">Syarat dan Ketentuan</a></li>
                <li><a href="{{ route('kontak-kami') }}" class="@if ($title == 'kontak kami') active @endif">Kontak Kami</a></li>
                <li><a class="get-a-quote" href="{{ route('kontak-kami') }}">Login</a></li>
            </ul>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->
