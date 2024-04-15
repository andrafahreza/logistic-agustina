@extends('front.layouts.app')

@section('content')
    <main id="main">
        <!-- ======= Breadcrumbs ======= -->
        <div class="breadcrumbs">
            <div class="page-header d-flex align-items-center" style="background-image: url('/front/assets/img/page-header.jpg');">
                <div class="container position-relative">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h2>Layanan</h2>
                        </div>
                    </div>
                </div>
            </div>
            <nav>
                <div class="container">
                    <ol>
                        <li><a href="{{ route('beranda') }}">Beranda</a></li>
                        <li>Layanan</li>
                    </ol>
                </div>
            </nav>
        </div><!-- End Breadcrumbs -->

        <!-- ======= Featured Services Section ======= -->
        <section id="featured-services" class="featured-services">
            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up">
                        <div class="icon flex-shrink-0"><i class="fa-solid fa-cart-flatbed"></i></div>
                        <div>
                            <h4 class="title">Packing</h4>
                            <p class="description">Packing rapi, aman dan terjamin</p>
                        </div>
                    </div>
                    <!-- End Service Item -->

                    <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="100">
                        <div class="icon flex-shrink-0"><i class="fa-solid fa-truck"></i></div>
                        <div>
                            <h4 class="title">Pengantaran</h4>
                            <p class="description">Pengantaran Cepat, Mudah, Murah</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="200">
                        <div class="icon flex-shrink-0"><i class="fa-solid fa-truck-ramp-box"></i></div>
                        <div>
                            <h4 class="title">Tepat Waktu</h4>
                            <p class="description">Pengantaran paket tepat waktu</p>
                        </div>
                    </div><!-- End Service Item -->

                </div>

            </div>
        </section><!-- End Featured Services Section -->

        <!-- ======= Services Section ======= -->
        <section id="service" class="services pt-0">
            <div class="container" data-aos="fade-up">

                <div class="section-header">
                    <span>Jasa Pengantaran Paket</span>
                    <h2>Jasa Pengantaran Paket</h2>

                </div>

                <div class="row gy-4">

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="card">
                            <div class="card-img">
                                <img src="/front/assets/img/storage-service.jpg" alt="" class="img-fluid">
                            </div>
                            <h3><a href="service-details.html" class="stretched-link">Gudang</a></h3>
                            <p>Mempunyai gudang yang cukup luas untuk mengamankan paket pelanggan</p>
                        </div>
                    </div><!-- End Card Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="card">
                            <div class="card-img">
                                <img src="/front/assets/img/trucking-service.jpg" alt="" class="img-fluid">
                            </div>
                            <h3><a href="service-details.html" class="stretched-link">Kendaraan</a></h3>
                            <p>Mempunyai banyak penyedia kendaraan vendor</p>
                        </div>
                    </div><!-- End Card Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                        <div class="card">
                            <div class="card-img">
                                <img src="/front/assets/img/packaging-service.jpg" alt="" class="img-fluid">
                            </div>
                            <h3><a href="service-details.html" class="stretched-link">Packaging</a></h3>
                            <p>Packaging Rapi, aman, dan terjamin</p>
                        </div>
                    </div><!-- End Card Item -->

                </div>

            </div>
        </section><!-- End Services Section -->
    </main>
@endsection
