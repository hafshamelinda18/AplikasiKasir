
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="https://demos.creative-tim.com/material-dashboard/pages/dashboard" target="_blank">
     
      <span class="ms-1 font-weight-bold text-white">KasirCaine</span>
    </a>
  </div>
  <hr class="horizontal light mt-0 mb-2">
  <div class="collapse navbar-collapse w-auto max-height-vh-100" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <!-- Beranda -->
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('home') ? 'active' : '' }}" href="{{ route('home') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">dashboard</i>
          </div>
          <span class="nav-link-text ms-1">Beranda</span>
        </a>
      </li>

      @if(Auth::check() && Auth::user()->role == 'kasir')
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Kasir</h6>
      </li>
      <li class="nav-item">
      <a class="nav-link text-white {{ request()->is('penjualan') ? 'active' : '' }}" href="{{ route('penjualan.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">point_of_sale</i>
          </div>
          <span class="nav-link-text ms-1">Penjualan</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('produk') ? 'active' : '' }}" href="{{ route('produk.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">shopping_bag</i>
          </div>
          <span class="nav-link-text ms-1">Produk</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('pelanggan') ? 'active' : '' }}" href="{{ route('pelanggan.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">people</i>
          </div>
          <span class="nav-link-text ms-1">Pelanggan</span>
        </a>
      </li>
      @endif

      @if(Auth::check() && Auth::user()->role == 'admin')
      <!-- Produk Section -->
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Produk</h6>
      </li>
      <!-- Kategori -->
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('kategori') ? 'active' : '' }}" href="{{ route('kategori.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">category</i>
          </div>
          <span class="nav-link-text ms-1">Kategori</span>
        </a>
      </li>
      <!-- Satuan -->
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('satuan') ? 'active' : '' }}" href="{{ route('satuan.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">straighten</i>
          </div>
          <span class="nav-link-text ms-1">Satuan</span>
        </a>
      </li>
      <!-- Pemasok -->
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('pemasok') ? 'active' : '' }}" href="{{ route('pemasok.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">store</i>
          </div>
          <span class="nav-link-text ms-1">Pemasok</span>
        </a>
      </li>
      <!-- Produk -->
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('produk') ? 'active' : '' }}" href="{{ route('produk.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">shopping_bag</i>
          </div>
          <span class="nav-link-text ms-1">Produk</span>
        </a>
      </li>
      <!-- Produk Supply -->
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('produksupply') ? 'active' : '' }}" href="{{ route('produksupply.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">inventory_2</i>
          </div>
          <span class="nav-link-text ms-1">Produk Masuk</span>
        </a>
      </li>
      <li class="nav-item">
  <a class="nav-link text-white {{ request()->is('produkkeluar') ? 'active' : '' }}" href="{{ route('produkkeluar.index') }}">
    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
      <i class="material-icons opacity-10">logout</i> {{-- Icon diganti dari inventory_2 ke logout --}}
    </div>
    <span class="nav-link-text ms-1">Produk Keluar</span>
  </a>
</li>

      <!-- Kasir Section -->
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Kasir</h6>
      </li>
      <!-- Pelanggan -->
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('pelanggan') ? 'active' : '' }}" href="{{ route('pelanggan.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">people</i>
          </div>
          <span class="nav-link-text ms-1">Member</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('metodebayar') ? 'active' : '' }}" href="{{ route('metodebayar.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">credit_card</i>
          </div>
          <span class="nav-link-text ms-1">Metode Bayar</span>
        </a>
      </li>
      <!-- Penjualan -->
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('penjualan') ? 'active' : '' }}" href="{{ route('penjualan.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">point_of_sale</i>
          </div>
          <span class="nav-link-text ms-1">Penjualan</span>
        </a>
      </li>
      @endif

      <li class="nav-item mt-3">
  <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Laporan</h6>
</li>

<!-- Laporan Produk Masuk -->
<li class="nav-item">
  <a class="nav-link text-white {{ request()->is('laporan-produk-supply') ? 'active' : '' }}" href="{{ route('laporan-produk-supply') }}">
    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
      <i class="material-icons opacity-10">inventory_2</i> {{-- Icon untuk produk masuk --}}
    </div>
    <span class="nav-link-text ms-1">Laporan Produk Masuk</span>
  </a>
</li>

<!-- Laporan Penjualan -->
<li class="nav-item">
  <a class="nav-link text-white {{ request()->is('laporan-penjualan') ? 'active' : '' }}" href="{{ route('laporan-penjualan') }}">
    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
      <i class="material-icons opacity-10">bar_chart</i> {{-- Icon untuk laporan penjualan --}}
    </div>
    <span class="nav-link-text ms-1">Laporan Penjualan</span>
  </a>
</li>

<!-- Laporan Produk Keluar -->
<li class="nav-item">
  <a class="nav-link text-white {{ request()->is('laporan-produk-keluar') ? 'active' : '' }}" href="{{ route('laporan-produk-keluar') }}">
    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
      <i class="material-icons opacity-10">logout</i> {{-- Icon untuk produk keluar --}}
    </div>
    <span class="nav-link-text ms-1">Laporan Produk Keluar</span>
  </a>
</li>

      <!-- Akun Section -->
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Akun</h6>
      </li>
  
      <!-- Profile -->
      
      @if(Auth::check() && Auth::user()->role == 'admin')


      @php
  $profil = \App\ProfilToko::find(1);
@endphp

<li class="nav-item">
  <a 
    class="nav-link text-white {{ request()->is('profiltoko') ? 'active' : '' }}" 
    href="{{ $profil ? route('profiltoko.show', 1) : route('profiltoko.create') }}">
    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
      <i class="material-icons opacity-10">person_add</i>
    </div>
    <span class="nav-link-text ms-1">Profil Toko</span>
  </a>
</li>
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('user') ? 'active' : '' }}" href="{{ route('user.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
          <i class="material-icons">account_circle</i>
          </div>
          <span class="nav-link-text ms-1">Akun Kasir</span>
        </a>
      </li>
      

      <!-- Daftar -->
      <li class="nav-item">
        <a class="nav-link text-white" href="register">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">person_add</i>
          </div>
          <span class="nav-link-text ms-1">Daftar Kasir</span>
        </a>
      </li>
      @endif
      <!-- Logout -->
      <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
          @csrf
          <button type="submit" class="nav-link text-white border-0 bg-transparent" onclick="return confirm('Apakah Anda yakin ingin keluar?');">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">exit_to_app</i>
            </div>
            <span class="nav-link-text ms-1" >Keluar</span>
          </button>
        </form>
      </li>
    </ul>
  </div>

  <div class="sidenav-footer position-absolute w-100 bottom-0">
    <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
      <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
        <div class="sidenav-toggler-inner">
          <i class="sidenav-toggler-line"></i>
          <i class="sidenav-toggler-line"></i>
          <i class="sidenav-toggler-line"></i>
        </div>
      </a>
    </li>
  </div>
</aside>
