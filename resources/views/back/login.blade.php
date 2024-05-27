<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>PT. PMH Express Login</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="/back/assets/img/favicon.png" rel="icon">
    <link href="/back/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/back/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/back/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/back/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/back/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="/back/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="/back/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="/back/assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="/back/assets/css/style.css" rel="stylesheet">
</head>

<body>
    <main>
        <div class="container">
            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="{{ route('beranda') }}" class="logo d-flex align-items-center w-auto">
                                    {{-- <img src="/back/assets/img/logo.png" alt=""> --}}
                                    <span class="d-none d-lg-block">PT. PMH Express</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        @if ($errors->any())
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong>  {{ $errors->first() }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif

                                        @if (Session::has('success'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong>  {{ Session::get('success'); }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif

                                        <h5 class="card-title text-center pb-0 fs-4">Login Disini</h5>
                                        <p class="text-center small">Silahkan login untuk memesan pengiriman barang</p>
                                    </div>

                                    <form action="{{ route('authenticate') }}" class="row g-3 needs-validation" method="POST" novalidate>
                                        @csrf
                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Username</label>
                                            <div class="input-group">
                                                <input type="text" name="username" class="form-control" id="yourUsername" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="yourPassword" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Login</button>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="credits">
                                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="/back/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="/back/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/back/assets/vendor/chart.js/chart.umd.js"></script>
    <script src="/back/assets/vendor/echarts/echarts.min.js"></script>
    <script src="/back/assets/vendor/quill/quill.min.js"></script>
    <script src="/back/assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="/back/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="/back/assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="/back/assets/js/main.js"></script>

</body>

</html>
