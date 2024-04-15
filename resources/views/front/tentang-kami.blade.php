@extends('front.layouts.app')

@section('content')
    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <div class="breadcrumbs">
            <div class="page-header d-flex align-items-center" style="background-image: url('/front/assets/img/page-header.jpg');">
                <div class="container position-relative">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h2>Tentang Kami</h2>
                        </div>
                    </div>
                </div>
            </div>
            <nav>
                <div class="container">
                    <ol>
                        <li><a href="{{ route('beranda') }}">Beranda</a></li>
                        <li>Tentang Kami</li>
                    </ol>
                </div>
            </nav>
        </div><!-- End Breadcrumbs -->

        <!-- ======= About Us Section ======= -->
        <section id="about" class="about">
            <div class="container" data-aos="fade-up">

                <div class="row gy-4">
                    <div class="col-lg-6 position-relative align-self-start order-lg-last order-first">
                        <img src="/front/assets/img/warehousing-service.jpg" class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-6 content order-last  order-lg-first">
                        <h3>PT. PMH Express</h3>
                        <p>
                            PT. Miduk Arta merupakan induk usaha Perusahaan atau bus PT. Pengangkutan Motor Horas yang lebih dikenal dengan sebutan Bus PMH. PT. Miduk Arta berdiri pada Tanggal 29 September 1984. Perusahaan ini didirikan oleh bapak Raja Pangihutan Sirait dan keluarga. Miduk Arta berkantor pusat di jl. Jendral Ahmad Yani no. 58 Pematang Siantar dan memiliki kantor cabang utama di jl. Sisingamangaraja km 6,3 no.40 Medan.
                        </p>
                        <br>
                        <h3>VISI</h3>
                        <h5>Menjadi Perusahaan yang terpercaya dan menjadi pilihan utama pelanggan dalam bidang transportasi migas, dan transportasi pada umumnya</h5>
                        <br>
                        <h3>MISI</h3>
                        <ul>
                            <li data-aos="fade-up" data-aos-delay="100">
                                <div>
                                    <h5>Progresif melayani secara professional</h5>
                                </div>
                            </li>
                            <li data-aos="fade-up" data-aos-delay="200">
                                <div>
                                    <h5>Jaminan terhadap mutu dan ketepatan waktu dan mengutamakan pelayanan pelanggan</h5>
                                </div>
                            </li>
                            <li data-aos="fade-up" data-aos-delay="300">
                                <div>
                                    <h5>Sarana dan prasarana transportasi modern</h5>
                                </div>
                            </li>
                            <li data-aos="fade-up" data-aos-delay="400">
                                <div>
                                    <h5>Adaptasi terhadap kemajuan teknologi transportasi</h5>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </section><!-- End About Us Section -->
    </main>
@endsection
