<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link @if ($title == 'home') active @else collapsed @endif" href="{{ route('home') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link @if ($title != 'request pengiriman') collapsed @endif" data-bs-target="#pengiriman" data-bs-toggle="collapse" href="#">
                <i class="bi bi-truck"></i><span>Pengiriman</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="pengiriman" class="nav-content collapse @if ($title == 'request pengiriman') show @endif" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('request-pengiriman') }}" @if ($title == 'request pengiriman') class="active" @endif>
                        <i class="bi bi-circle"></i><span>Request Pengiriman Barang</span>
                    </a>
                </li>
            </ul>
        </li>

        @if (auth()->user()->level->nama_level == "operasional" || auth()->user()->level->nama_level == "admin")
            <li class="nav-item">
                <a class="nav-link @if ($title === 'verifikasi') active @else collapsed @endif" href="{{ route('verifikasi') }}">
                    <i class="bi bi-person-check-fill"></i>
                    <span>Verifikasi pelanggan</span>
                </a>
            </li>
        @endif

        @if (auth()->user()->level->nama_level == "operasional" || auth()->user()->level->nama_level == "admin")
            <li class="nav-item">
                <a class="nav-link @if ($title != 'vendor' && $title != "operator" && $title != "kepala perusahaan" && $title != "admin" || $title == 'users') collapsed @endif" data-bs-target="#pengguna" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-person"></i><span>Employeed</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="pengguna" class="nav-content collapse @if ($title == 'vendor' || $title == 'admin' || $title == 'kepala perusahaan' || $title == 'operator' || $title == 'users') show @endif" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('admin') }}" @if ($title == 'admin') class="active" @endif>
                            <i class="bi bi-circle"></i><span>Admin</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('operator') }}" @if ($title == 'operator') class="active" @endif>
                            <i class="bi bi-circle"></i><span>Operator</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kepala') }}" @if ($title == 'kepala perusahaan') class="active" @endif>
                            <i class="bi bi-circle"></i><span>Kepala Perusahaan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('vendor') }}" @if ($title == 'vendor') class="active" @endif>
                            <i class="bi bi-circle"></i><span>Vendor</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users') }}" @if ($title == 'users') class="active" @endif>
                            <i class="bi bi-circle"></i><span>Users</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link @if ($title != 'biaya' && $title != 'kendaraan' && $title != 'supir') collapsed @endif" data-bs-target="#pesanan" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-archive-fill"></i><span>Pesanan</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="pesanan" class="nav-content collapse @if ($title == 'biaya' || $title == 'kendaraan' || $title == 'supir') show @endif" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('biaya') }}" @if ($title == 'biaya') class="active" @endif>
                            <i class="bi bi-circle"></i><span>Biaya Pengiriman</span>
                        </a>
                        <a href="{{ route('kendaraan') }}" @if ($title == 'kendaraan') class="active" @endif>
                            <i class="bi bi-circle"></i><span>Kendaraan</span>
                        </a>
                        <a href="{{ route('supir') }}" @if ($title == 'supir') class="active" @endif>
                            <i class="bi bi-circle"></i><span>Supir</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

    </ul>

</aside><!-- End Sidebar-->
