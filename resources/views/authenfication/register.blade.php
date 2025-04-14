@extends('template.style')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>Daftar</title>
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
</head>

<body>

  <main class="main-content mt-0">
    <section class="d-flex align-items-center justify-content-center min-vh-100">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-10 col-lg-7 col-md-8"> <!-- Diperbesar -->
            <div class="card card-plain shadow-lg rounded-4">
              <div class="card-header text-center">
                @if ($errors->any())
                <div class="alert alert-danger">
                  <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
                @endif
                <h4 class="font-weight-bolder mb-3">Daftarkan Kasir</h4>
                <p class="mb-0 text-muted">Masukan Username, Email, dan Kata Sandi untuk Daftar</p>
              </div>
              <div class="card-body">
                <form method="POST" action="{{ route('register.post') }}">
                  @csrf
                  <div class="form-floating mb-3">
                    <input type="text" id="name" name="name" class="form-control" placeholder="Nama">
                    <label for="name">Nama</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email">
                    <label for="email">Email</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Kata Sandi">
                    <label for="password">Kata Sandi</label>
                  </div>
                  <div class="text-center">
                    <button class="btn btn-lg bg-gradient-primary w-100 mt-4 mb-0" type="submit">Daftar</button>
                  </div>
                </form>
              </div>
              <div class="card-footer text-center pt-0 px-lg-2 px-1"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), { damping: '0.5' });
    }
  </script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="../assets/js/material-dashboard.min.js?v=3.0.0"></script>
</body>

</html>
@endsection
