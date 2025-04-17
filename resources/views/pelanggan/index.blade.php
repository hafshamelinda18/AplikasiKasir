
@extends('template.style')

@section('content')


<div class="container col-lg-12 col-md-12">

<div class="col-md-9 mx-auto">
<h2 class="text-center mb-4">Data Member</h2>

@if(session('success'))
<div class= "alert alert-success"> {{session('success')}} </div>
@endif

@if(Auth::check() && Auth::user()->role == 'admin')

<div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('pelanggan.create') }}" class="btn btn-sm btn-primary">
                Tambah <i class="material-icons text-sm">add</i>
            </a>

            <!-- Form Pencarian -->
            <form action="{{ route('pelanggan.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Pelanggan..." class="form-control me-2" />
                <button type="submit" class="btn btn-sm btn-primary"><i class="material-icons text-sm">search</i> </button>
            </form>
        </div>
@endif

@if(Auth::check() && Auth::user()->role == 'kasir')
    <div class="d-flex justify-content-end mb-3">
    <form action="{{ route('pelanggan.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Produk..." class="form-control me-2" />
                <button type="submit" class="btn btn-sm btn-primary"><i class="material-icons text-sm">search</i> </button>
            </form>
        </div>
        @endif
<p>
<div class="card">
            <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table text-center align-middle mb-0">
                        <thead class="thead-dark">
    <tr>
        <th>No</th>
        <th> Nama Pelanggan </th>
        <th> Email </th>
        <th> Alamat </th>
        <th>Nomor Telepon</th>
        @if(Auth::check() && Auth::user()->role == 'admin')
        <th> Aksi </th>
        @endif
</tr>
</thead>
<tbody>
    @foreach($pelanggans as $item)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td> {{$item->NamaPelanggan}}</td>
        <td> {{$item->email}}</td>
        <td style="white-space: normal; word-break: break-word; max-width: 200px;"> 
    {{ $item->Alamat }},
    {{ $item->village->name ?? '-' }},
    {{ $item->district->name ?? '-' }},
    {{ $item->regency->name ?? '-' }},
    {{ $item->province->name ?? '-' }}
</td>
        <td> {{$item->NoTelp}}</td>
        @if(Auth::check() && Auth::user()->role == 'admin')
        <td>
            <a href="{{route('pelanggan.edit', $item->PelangganID) }}" class="btn btn-sm btn-info"> <i class="material-icons text-sm">edit </i></a>

            <form action="{{route('pelanggan.destroy', $item->PelangganID)}}" method="POST" onsubmit="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?');" 
            class="d-inline">

            @csrf
            @method('DELETE')

            <button type= "submit" class="btn btn-sm btn-danger"><i class="material-icons text-sm">delete</i></button>
</form>
</td>
@endif
</tr>
@endforeach
</tbody>
</table>
</div>
{{ $pelanggans->links() }}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000); // Hilangkan notifikasi setelah 5 detik
</script>

@endsection