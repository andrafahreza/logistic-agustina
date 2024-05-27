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
                            <h2>Kontak</h2>
                        </div>
                    </div>
                </div>
            </div>
            <nav>
                <div class="container">
                    <ol>
                        <li><a href="{{ route('beranda') }}">Beranda</a></li>
                        <li>Kontak</li>
                    </ol>
                </div>
            </nav>
        </div><!-- End Breadcrumbs -->
        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">
                <div class="row gy-4 mt-4">
                    <div class="col-lg-4">
                        <div class="info-item d-flex">
                            <i class="bi bi-geo-alt flex-shrink-0"></i>
                            <div>
                                <h4>Lokasi</h4>
                                <p>Jl. Brigjen Katamso No. 30 Medan</p>
                            </div>
                        </div>

                        <div class="info-item d-flex">
                            <i class="bi bi-phone flex-shrink-0"></i>
                            <div>
                                <h4>Telepon:</h4>
                                <p>(061) 4147784</p>
                            </div>
                        </div><!-- End Info Item -->

                    </div>
                </div>
            </div>
        </section><!-- End Contact Section -->
    </main>
@endsection
