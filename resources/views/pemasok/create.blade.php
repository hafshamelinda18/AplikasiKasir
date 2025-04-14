@extends('template.style')

@section('content')

<div class="container col-8">
<h3> Tambah Data Pemasok </h3>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li> {{ $error }} </li>
        @endforeach
</ul>
</div>
@endif

<div class="card mx-auto" style="max-width: 700px; border: 2px solid #000; border-radius: 8px;">
    <div class="card-body">
<form action="{{ route('pemasok.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="Nama"> Nama Pemasok </label>
        <input type="text" name="Nama" id="Nama" class="form-control" value="{{ old('Nama') }}" required>
</div>

<div class="form-group">
    <label for="Alamat"> Alamat </label>
    <input type="text" name="Alamat" id="Alamat" class="form-control" value="{{ old('Alamat') }}" required>
</div>

<div class="form-group">
    <label for="NoTelp">Nomor Telepon</label>
    <input type="number" name="NoTelp" id="NoTelp" class="form-control" value="{{ old('Alamat') }}" required>
</div>

<div class="form-group">
    <label for="Email">Email</label>
    <input type="email" name="Email" id="Email" class="form-control" value="{{ old('Email') }}" required>
</div>

<button type="submit" class="btn btn-sm btn-primary mt-3"> Simpan </button>
<a href="{{ route('pemasok.index') }}" class="btn btn-sm btn-warning mt-3">Batal</a>
</div>
</form>
</div>
</diV>

@endsection