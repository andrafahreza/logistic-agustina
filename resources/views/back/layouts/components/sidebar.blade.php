<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link @if ($title == 'home') active @else collapsed @endif" href="{{ route('home') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        @if (auth()->user()->level->nama_level == "admin")
            <li class="nav-item">
                <a class="nav-link @if ($title === 'verifikasi') active @else collapsed @endif" href="{{ route('verifikasi') }}">
                    <i class="bi bi-person-check-fill"></i>
                    <span>Verifikasi pelanggan</span>
                </a>
            </li>
        @endif

        @if (auth()->user()->level->nama_level != "pelanggan")
            <li class="nav-heading">Master Data</li>

            <li class="nav-item">
                <a class="nav-link @if ($title != 'vendor' && $title != "operator" && $title != "kepala perusahaan" && $title != "admin") collapsed @endif" data-bs-target="#pengguna" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-person"></i><span>Pengguna</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="pengguna" class="nav-content collapse @if ($title == 'vendor' || $title == 'admin' || $title == 'kepala perusahaan' || $title == 'operator') show @endif" data-bs-parent="#sidebar-nav">
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
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link @if ($title === 'supir') active @else collapsed @endif" href="{{ route('supir') }}">
                    <i class="bi bi-person-badge"></i>
                    <span>Supir</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link @if ($title === 'biaya') active @else collapsed @endif" href="{{ route('biaya') }}">
                    <i class="bi bi-cash"></i>
                    <span>Biaya</span>
                </a>
            </li>
        @endif

    </ul>

</aside><!-- End Sidebar-->
