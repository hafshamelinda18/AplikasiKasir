<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>KasirCaine</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700&family=Rubik:wght@400;500&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">

    <!-- Bootstrap & Custom CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar & Hero Start -->
    <div class="container-fluid header position-relative overflow-hidden p-0">
        <nav class="navbar navbar-expand-lg fixed-top navbar-light px-4 px-lg-5 py-2 py-lg-1">
            <a href="index.html" class="navbar-brand p-0">
                <h1 class="display-6 text-primary m-0">
                    <i class="fas fa-shopping-basket me-3"></i>KasirCaine
                </h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0">
                    <!-- Tambahkan menu navbar jika diperlukan -->
                </div>
            </div>
        </nav>

        <!-- Hero Header Start -->
        <div class="hero-header overflow-hidden px-5">
            <div class="row gy-5 align-items-center">
                <div class="col-lg-6 wow animate__animated animate__fadeInLeft" data-wow-delay="0.1s">
                    <h1 class="display-4 text-dark mb-4 animate__animated animate__fadeInUp" data-wow-delay="0.3s">Aplikasi Kasir</h1>
                    <p class="fs-4 mb-4 animate__animated animate__fadeInUp" data-wow-delay="0.5s">
                        Kelola toko Anda dengan mudah dan efisien menggunakan KasirCaine – aplikasi kasir modern untuk pencatatan penjualan, stok barang, hingga laporan keuangan secara real-time.
                    </p>
                    <a href="login" class="btn btn-primary rounded-pill py-3 px-5 animate__animated animate__fadeInUp" data-wow-delay="0.7s">Masuk</a>
                </div>
                <div class="col-lg-6 wow animate__animated animate__fadeInRight" data-wow-delay="0.2s">
                    <img src="assets/img/cashier.jpg" class="img-fluid w-100 h-100" alt="Aplikasi Kasir CaineMart">
                </div>
            </div>
        </div>
        <!-- Hero Header End -->
    </div>
    <!-- Navbar & Hero End -->

    <!-- Sections lainnya bisa ditambahkan di sini -->
    <!-- About / Services / Features / FAQ / Pricing / Blog / Testimonial / Footer -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- WOW JS -->
    <script src="{{ asset('assets/lib/wow/wow.min.js') }}"></script>
    <script>
        new WOW({
            boxClass: 'wow', // default
            animateClass: 'animate__animated', // animate.css class prefix
            offset: 0,
            mobile: true,
            live: true
        }).init();
    </script>

    <!-- Plugin Libraries -->
    <script src="{{ asset('assets/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('assets/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/lib/lightbox/js/lightbox.min.js') }}"></script>

    <!-- Template Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>
