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
                            <h2>Syarat dan Ketentuan</h2>
                        </div>
                    </div>
                </div>
            </div>
            <nav>
                <div class="container">
                    <ol>
                        <li><a href="{{ route('beranda') }}">Beranda</a></li>
                        <li>Syarat dan Ketentuan</li>
                    </ol>
                </div>
            </nav>
        </div><!-- End Breadcrumbs -->

        <!-- ======= Pricing Section ======= -->
        <section id="pricing" class="pricing pt-0">
            <div class="container" data-aos="fade-up">

                <div class="section-header">
                    <span>Syarat & Ketentuan</span>
                    <h2>Syarat & Ketentuan</h2>

                </div>

                <div class="row gy-4">

                    <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                        <div class="pricing-item featured">
                            <h3>Nama Paket</h3>
                            <h4><i class="bi bi-cart"></i></h4>
                            <ul>
                                <li><i class="bi bi-check"></i> Quam adipiscing vitae proin</li>
                                <li><i class="bi bi-check"></i> Nec feugiat nisl pretium</li>
                                <li><i class="bi bi-check"></i> Nulla at volutpat diam uteera</li>
                            </ul>
                        </div>
                    </div><!-- End Pricing Item -->

                    <div class="col-lg-3" data-aos="fade-up" data-aos-delay="200">
                        <div class="pricing-item featured">
                            <h3>Nama Paket</h3>
                            <h4><i class="bi bi-airplane"></i></h4>
                            <ul>
                                <li><i class="bi bi-check"></i> Quam adipiscing vitae proin</li>
                                <li><i class="bi bi-check"></i> Nec feugiat nisl pretium</li>
                                <li><i class="bi bi-check"></i> Nulla at volutpat diam uteera</li>
                                <li><i class="bi bi-check"></i> Pharetra massa massa ultricies</li>
                                <li><i class="bi bi-check"></i> Massa ultricies mi quis hendrerit</li>
                            </ul>
                        </div>
                    </div><!-- End Pricing Item -->

                    <div class="col-lg-3" data-aos="fade-up" data-aos-delay="200">
                        <div class="pricing-item featured">
                            <h3>Nama Paket</h3>
                            <h4><i class="bi bi-tsunami"></i></h4>
                            <ul>
                                <li><i class="bi bi-check"></i> Quam adipiscing vitae proin</li>
                                <li><i class="bi bi-check"></i> Nec feugiat nisl pretium</li>
                                <li><i class="bi bi-check"></i> Nulla at volutpat diam uteera</li>
                                <li><i class="bi bi-check"></i> Pharetra massa massa ultricies</li>
                                <li><i class="bi bi-check"></i> Massa ultricies mi quis hendrerit</li>
                            </ul>
                        </div>
                    </div><!-- End Pricing Item -->

                    <div class="col-lg-3" data-aos="fade-up" data-aos-delay="300">
                        <div class="pricing-item featured">
                            <h3>Nama Paket</h3>
                            <h4><i class="bi bi-truck"></i></h4>
                            <ul>
                                <li><i class="bi bi-check"></i> Quam adipiscing vitae proin</li>
                                <li><i class="bi bi-check"></i> Nec feugiat nisl pretium</li>
                                <li><i class="bi bi-check"></i> Nulla at volutpat diam uteera</li>
                                <li><i class="bi bi-check"></i> Pharetra massa massa ultricies</li>
                                <li><i class="bi bi-check"></i> Massa ultricies mi quis hendrerit</li>
                            </ul>
                        </div>
                    </div><!-- End Pricing Item -->

                </div>

            </div>
        </section><!-- End Pricing Section -->
    </main>
@endsection
