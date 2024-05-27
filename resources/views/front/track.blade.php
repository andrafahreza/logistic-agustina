@extends('front.layouts.app')

@section('content')
    <main id="main">
        <!-- ======= Breadcrumbs ======= -->
        <div class="breadcrumbs">
            <div class="page-header d-flex align-items-center"
                style="background-image: url('/front/assets/img/page-header.jpg');">
                <div class="container position-relative">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h2>Cek Harga</h2>
                        </div>
                    </div>
                </div>
            </div>
            <nav>
                <div class="container">
                    <ol>
                        <li><a href="{{ route('beranda') }}">Beranda</a></li>
                        <li>Cek Harga</li>
                    </ol>
                </div>
            </nav>
        </div><!-- End Breadcrumbs -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">
                <div class="row gy-4">
                    <div class="col-lg-12">
                        <h3 class="text-center">Lacak Pesanan</h3>
                        <center>
                            <form action="{{ route('track') }}" method="POST">
                                @csrf
                                <input type="text" class="form-control" name="no_resi" style="width: 50%" placeholder="Masukkan Nomor Resi" required>
                                <button type="submit" class="btn btn-primary mt-2">Cari</button>
                            </form>
                        </center>
                        <div class="row mt-4">
                            <table class="table table-striped @if ($search == false || count($data) < 1) d-none @endif" id="track">
                                <thead>
                                    <tr>
                                        <th>Waktu</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ date('d-m-Y H:i', strtotime($item->waktu)) }}</td>
                                            <td>{{ $item->note }}</td>
                                            <td>
                                                @if ($item->status == "process")
                                                    <span class="badge bg-warning">Proses</span>
                                                @elseif ($item->status == "denied")
                                                    <span class="badge bg-danger">Dibatalkan</span>
                                                @else
                                                    <span class="badge bg-success">Selesai</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if ($search == true && count($data) < 1)
                                <h5 class="text-center mt-4">Data tidak ditemukan</h5>
                            @endif
                        </div>
                    </div><!-- End Contact Form -->

                </div>

            </div>
        </section><!-- End Contact Section -->
    </main>
@endsection
