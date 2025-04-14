
@extends('template.style')

@section('content')


<div class="container col-lg-12 col-md-12">

<div class="col-md-9 mx-auto">
<h2 class="text-center mb-4">Data Toko</h2>

@if(session('success'))
<div class= "alert alert-success"> {{session('success')}} </div>
@endif

@if(Auth::check() && Auth::user()->role == 'admin')

<div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('profiltoko.create') }}" class="btn btn-sm btn-primary">
                Tambah <i class="material-icons text-sm">add</i>
            </a>

            <!-- Form Pencarian -->
            <form action="{{ route('profiltoko.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Profil Toko..." class="form-control me-2" />
                <button type="submit" class="btn btn-sm btn-primary"><i class="material-icons text-sm">search</i> </button>
            </form>
        </div>
@endif

@if(Auth::check() && Auth::user()->role == 'kasir')
    <div class="d-flex justify-content-end mb-3">
    <form action="{{ route('profiltoko.index') }}" method="GET" class="d-flex">
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
        <th> Nama Toko </th>
        <th> Alamat </th>
        <th>Nomor Telepon</th>
        <th>Email</th>
        @if(Auth::check() && Auth::user()->role == 'admin')
        <th> Aksi </th>
        @endif
</tr>
</thead>
<tbody>
    @foreach($tokos as $item)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td> {{$item->NamaToko}}</td>
        <td> {{$item->Alamat}}</td>
        <td> {{$item->NoTelp}}</td>
        <td> {{$item->email}}</td>
        @if(Auth::check() && Auth::user()->role == 'admin')
        <td>
            <a href="{{route('profiltoko.edit', $item->IdToko) }}" class="btn btn-sm btn-info"> <i class="material-icons text-sm">edit </i></a>

            <form action="{{route('profiltoko.destroy', $item->IdToko)}}" method="POST" onsubmit="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?');" 
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
{{ $tokos->links() }}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000); // Hilangkan notifikasi setelah 5 detik
</script>

@endsection