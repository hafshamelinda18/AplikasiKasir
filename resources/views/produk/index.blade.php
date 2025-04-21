@extends('template.style')

@section('content')
<div class="container col-lg-12 col-md-12">

<div class="col-md-9 mx-auto">
    <h2 class="text-center mb-4">Data Produk</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif


    @if(Auth::check() && Auth::user()->role == 'admin')
    <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('produk.create') }}" class="btn btn-sm btn-primary">
                Tambah <i class="material-icons text-sm">add</i>
            </a>

            <!-- Form Pencarian -->
            <form action="{{ route('produk.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Produk..." class="form-control me-2" />
                <button type="submit" class="btn btn-sm btn-primary"><i class="material-icons text-sm">search</i> </button>
            </form>
        </div>
    @endif

    @if(Auth::check() && Auth::user()->role == 'kasir')
    <div class="d-flex justify-content-end mb-3">
    <form action="{{ route('produk.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Produk..." class="form-control me-2" />
                <button type="submit" class="btn btn-sm btn-primary"><i class="material-icons text-sm">search</i> </button>
            </form>
        </div>
        @endif

    <div class="card">
            <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table text-center align-middle mb-0">
                        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Tanggal Kadaluarsa</th>
                @if(Auth::check() && Auth::user()->role == 'admin')
                <th>Status</th>
                
                    <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($produks as $produk)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $produk->NamaProduk }}</td>
                    <td>{{ 'Rp' . number_format($produk->Harga, 2, ',', '.') }}</td>
                    <td>{{ $produk->Stok }}</td>
                    <td>
                        @if(isset($produk->DetailSup) && $produk->DetailSup->isNotEmpty())
                            @foreach($produk->DetailSup as $masuk)
                                @if ($masuk->tanggal_kadaluarsa)
                                    @php
                                        $kadaluarsa = \Carbon\Carbon::parse($masuk->tanggal_kadaluarsa);
                                        $selisihHari = now()->diffInDays($kadaluarsa, false); // false agar negatif kalau sudah lewat
                                        $class = '';

                                        if ($selisihHari <= 7) {
                                            $class = 'text-white bg-danger fw-bold p-1 rounded';
                                        } elseif ($selisihHari <= 30) {
                                            $class = 'text-danger fw-bold';
                                        }
                                    @endphp
                                    <p class="{{ $class }}">
                                        {{ $kadaluarsa->format('d-m-Y') }}
                                    </p>
                                @endif
                            @endforeach
                        @else
                            <p>Tidak ada data</p>
                        @endif
                    </td>

                        @if(Auth::check() && Auth::user()->role == 'admin')
                        <td>
                            @if(isset($produk->DetailSup) && $produk->DetailSup->isNotEmpty())
                                @foreach($produk->DetailSup as $masuk)
                                    @if ($masuk->tanggal_kadaluarsa) <!-- Hanya tampilkan tombol atau tanggal cek jika ada tanggal kadaluarsa -->
                                        <div style="margin-bottom: 10px;"> <!-- Memberikan jarak antar detail barang -->
                                            @if(is_null($masuk->tanggal_cek))
                                                <!-- Tombol untuk melakukan cek -->
                                                <form action="{{ route('produk.cek', $masuk->DetailSupID) }}" method="POST" style="display: inline;">

                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm" style="margin-top: 5px;"><i class="material-icons text-sm">check</i></button> <!-- Menambahkan margin atas untuk memisahkan tombol dari teks -->
                                                </form>
                                            @else
                                                <!-- Menampilkan keterangan sudah dicek -->
                                                <p>{{ \Carbon\Carbon::parse($masuk->tanggal_cek)->format('d-m-Y') }}</p>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <p>-</p>
                            @endif
                        </td>
                   
                        <td>
                            <a href="{{ route('produk.edit', $produk->ProdukID) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="material-icons text-sm">edit</i>
                            </a>
                            <a href="{{route('produk.show', $produk->ProdukID) }}" class="btn btn-sm btn-info">  <i class="material-icons text-sm">visibility</i> </a>
                            <form action="{{ route('produk.destroy', $produk->ProdukID) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="material-icons text-sm">delete</i>
                                </button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $produks->links() }}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000); // Hilangkan notifikasi setelah 5 detik
</script>

@endsection
