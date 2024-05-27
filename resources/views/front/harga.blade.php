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
                        <h3 class="text-center">Cari Tahu Biaya Pengiriman Disini</h3>
                        <div class="row mt-2">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tujuan</th>
                                        <th>Biaya</th>
                                        <th>Service</th>
                                        <th>Minimal Berat</th>
                                        <th>Jangka waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->cabang->nama_cabang }}</td>
                                            <td>Rp. {{ number_format($item->biaya) }}</td>
                                            <td>{{ $item->service }}</td>
                                            <td>{{ $item->minimal_berat }}</td>
                                            <td>{{ $item->jangka_waktu }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div><!-- End Contact Form -->

                </div>

            </div>
        </section><!-- End Contact Section -->
    </main>
@endsection
