@extends('template.style')

@section('content')
<div class="container col-lg-12 col-md-12">

<div class="col-md-9 mx-auto">
<h2 class="text-center mb-4">Data Satuan</h2>

@if(session('success'))
<div class= "alert alert-success"> {{session('success')}} </div>
@endif

<div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('satuan.create') }}" class="btn btn-sm btn-primary">
                Tambah <i class="material-icons text-sm">add</i>
            </a>

            <!-- Form Pencarian -->
            <form action="{{ route('satuan.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Satuan..." class="form-control me-2" />
                <button type="submit" class="btn btn-sm btn-primary"><i class="material-icons text-sm">search</i> </button>
            </form>
        </div>

<div class="card">
            <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table text-center align-middle mb-0">
                        <thead class="thead-dark">
    <tr>
        <th>No</th>
        <th>Nama Satuan</th>
        <th> Aksi </th>
        
</tr>
</thead>
<tbody>
    @foreach($satuans as $item)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td> {{$item->NamaSatuan}}</td>
    
        <td>
            <a href="{{route('satuan.edit', $item->SatuanID) }}" class="btn btn-sm btn-info"> <i class="material-icons text-sm">edit</i> </a>

            <form action="{{route('satuan.destroy', $item->SatuanID)}}" method="POST" onsubmit="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?');" 
            class="d-inline">

            @csrf
            @method('DELETE')

            <button type= "submit" class="btn btn-sm btn-danger"><i class="material-icons text-sm">delete</i></button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>

{{ $satuans->links() }}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000); // Hilangkan notifikasi setelah 5 detik
</script>

@endsection