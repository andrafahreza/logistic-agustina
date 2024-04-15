<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>
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
    @stack('styles')
</head>

<body>
    @include('back.layouts.components.header')

    @include('back.layouts.components.sidebar')

    <main id="main" class="main">
        @yield('contents')
    </main><!-- End #main -->

    @include('back.layouts.components.footer')

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
    @stack("scripts")

</body>

</html>
