<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link @if ($title == 'home') active @else collapsed @endif" href="{{ route('home') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        @if (auth()->user()->level->nama_level == "operator" || auth()->user()->level->nama_level == "keuangan" || auth()->user()->level->nama_level == "kepala_perusahaan")
            <li class="nav-item">
                <a class="nav-link @if ($title != 'request pengiriman' && $title != 'pengelola pengiriman' && $title != 'daftar pesanan') collapsed @endif" data-bs-target="#pengiriman" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-truck"></i><span>Pengiriman</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="pengiriman" class="nav-content collapse @if ($title == 'request pengiriman' || $title == 'pengelola pengiriman' || $title == 'daftar pesanan' || $title == 'pengelola penjemputan') show @endif" data-bs-parent="#sidebar-nav">
                    @if (auth()->user()->level->nama_level == "keuangan" || auth()->user()->level->nama_level == "kepala_perusahaan")
                        <li>
                            <a href="{{ route('daftar-pesanan') }}" @if ($title == 'daftar pesanan') class="active" @endif>
                                <i class="bi bi-circle"></i><span>Daftar Pesanan</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->level->nama_level == "operator")
                        <li>
                            <a href="{{ route('pengelola-penjemputan') }}" @if ($title == 'pengelola penjemputan') class="active" @endif>
                                <i class="bi bi-circle"></i><span>Pengelola Penjemputan Barang</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pengelola-pengiriman') }}" @if ($title == 'pengelola pengiriman') class="active" @endif>
                                <i class="bi bi-circle"></i><span>Pengelola Pengiriman Barang</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if (auth()->user()->level->nama_level == "admin" || auth()->user()->level->nama_level == "kepala_perusahaan")
            <li class="nav-item">
                <a class="nav-link @if ($title != 'vendor' && $title != "operator" && $title != "kepala perusahaan" && $title != "admin" || $title == 'users' || $title == 'keuangan') collapsed @endif" data-bs-target="#pengguna" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-person"></i><span>Employeed</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="pengguna" class="nav-content collapse @if ($title == 'vendor' || $title == 'admin' || $title == 'kepala perusahaan' || $title == 'operator' || $title == 'users' || $title == 'keuangan') show @endif" data-bs-parent="#sidebar-nav">
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
                        <a href="{{ route('keuangan') }}" @if ($title == 'keuangan') class="active" @endif>
                            <i class="bi bi-circle"></i><span>Keuangan</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if (auth()->user()->level->nama_level != "kepala_perusahaan")
            <li class="nav-item">
                <a class="nav-link @if ($title != 'biaya' && $title != 'cabang' && $title != 'supir') collapsed @endif" data-bs-target="#pesanan" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-archive-fill"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="pesanan" class="nav-content collapse @if ($title == 'biaya' || $title == 'cabang' || $title == 'supir') show @endif" data-bs-parent="#sidebar-nav">
                    <li>
                        @if (auth()->user()->level->nama_level == "admin" || auth()->user()->level->nama_level == "keuangan")
                            @if (auth()->user()->level->nama_level == "admin")
                                <a href="{{ route('cabang') }}" @if ($title == 'cabang') class="active" @endif>
                                    <i class="bi bi-circle"></i><span>Cabang</span>
                                </a>
                            @endif
                            <a href="{{ route('biaya') }}" @if ($title == 'biaya') class="active" @endif>
                                <i class="bi bi-circle"></i><span>Biaya Pengiriman</span>
                            </a>
                        @endif

                        @if (auth()->user()->level->nama_level != "keuangan")
                            <a href="{{ route('supir') }}" @if ($title == 'supir') class="active" @endif>
                                <i class="bi bi-circle"></i><span>Supir</span>
                            </a>
                        @endif
                    </li>
                </ul>
            </li>
        @endif

        @if (auth()->user()->level->nama_level == 'keuangan' || auth()->user()->level->nama_level == "kepala_perusahaan")
            <li class="nav-item">
                <a class="nav-link @if ($title != 'hutang & piutang') collapsed @endif" data-bs-target="#keuangan" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-cash"></i><span>Keuangan</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="keuangan" class="nav-content collapse @if ($title == 'laporan keuangan') show @endif" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('laporan-keuangan') }}" @if ($title == 'laporan keuangan') class="active" @endif>
                            <i class="bi bi-circle"></i><span>Laporan Keuangan</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

    </ul>

</aside><!-- End Sidebar-->
