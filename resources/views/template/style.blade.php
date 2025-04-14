<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
  <title>Penjualan</title>
  
  <!-- Fonts and icons -->
  <link href="{{ asset('fonts/roboto.css') }}" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.0.0') }}" rel="stylesheet" />
<style>
  body, html {
    overflow-x: hidden; /* Menghilangkan kemampuan untuk menggeser konten ke samping */
}

.container-fluid {
    max-width: 100%; /* Pastikan kontainer tidak melebihi lebar layar */
}

.row {
    margin-left: 0;
    margin-right: 0;
}

.col {
    padding-left: 0;
    padding-right: 0;
}

/* Jika terdapat elemen gambar atau elemen lain yang bisa meluap */
img, video, iframe {
    max-width: 100%;
    height: auto;
    display: block;
}

  .custom-navbar {
    background-color: #A9A9A9; /* Ganti dengan warna yang diinginkan */
}

.text-custom-white {
    color: #fff; /* Warna teks putih */
}

.navbar {
    padding: 6px; /* Kurangi padding navbar */
}

.btn {
    padding: 5px 8px; /* Kurangi padding tombol */
    font-size: 9px;
}

.container-fluid {
    padding: 8px; /* Kurangi padding kontainer */
}

.navbar-nav .nav-item .nav-link {
    font-size: 12px; /* Ukuran font untuk navbar */
}

.dropdown-menu .dropdown-item {
    font-size: 10px; /* Ukuran font untuk dropdown item */
}
  </style>

</head>

<body class="g-sidenav-show bg-gray-200">
  @include('template.sidebar')

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl custom-navbar" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <!-- Breadcrumb (optional) -->
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
           
          </div>
          <ul class="navbar-nav justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body font-weight-bold px-0 text-white">
                <i class="fa fa-user me-sm-1 text-white"></i>
                @if (Auth::check())
    <span class="d-sm-inline d-none text-white">{{ Auth::user()->name }}</span>
@else
    <span class="d-sm-inline d-none text-white">Guest</span>
@endif

              </a>
              
            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0 text-white" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line text-white"></i>
                  <i class="sidenav-toggler-line text-white"></i>
                  <i class="sidenav-toggler-line text-white"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0 text-white">
                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer text-white"></i>
              </a>
            </li>
            <li class="nav-item dropdown pe-2 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0 text-white" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-bell cursor-pointer text-white"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img src="{{ asset('assets/img/team-2.jpg') }}" class="avatar avatar-sm me-3">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">New message</span> from Laur
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          13 minutes ago
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
                <!-- More notifications here -->
              </ul>
            </li>
          </ul>
        </div>
      </div>
</nav>


    <!-- Main Content -->
    <div class="container-fluid py-4">
      <div class="row">
        @yield('content') <!-- This will load the content of each page -->
      </div>
    </div>
  </main>

  <!-- Core JS Files -->
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
  
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }

    document.getElementById('iconNavbarSidenav').addEventListener('click', function () {
      var sidenav = document.getElementById('sidenav-main');
      sidenav.classList.toggle('sidenav-collapsed');
    });

    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
  return new bootstrap.Dropdown(dropdownToggleEl)
});

  </script>
  
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  
  <!-- Control Center for Material Dashboard -->
  <script src="{{ asset('assets/js/material-dashboard.min.js?v=3.0.0') }}"></script>
</body>

</html>
