@extends('template.style')

@section('content')

<div class="container col-8">
<h3 class="text-center mb-4"> Daftar Profil Toko </h3>
<div class="alert alert-info text-center">
  Toko Belum Didaftarkan, Silakan isi Profil Toko terlebih dahulu.
</div>
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
<form action="{{ route('profiltoko.store') }}" method="POST"  enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label class="font-weight-bold">Logo Toko</label>
        <input type="file" class="form-control @if ($errors->has('logo')) is-invalid @endif" name="logo">
    </div>
    <div class="form-group">
        <label for="NamaToko"> Nama Toko</label>
        <input type="text" name="NamaToko" id="NamaToko" class="form-control" value="{{ old('NamaToko') }}" required>
</div>
<div class="form-group">
        <label for="Pemilik"> Nama Pemilik</label>
        <input type="text" name="Pemilik" id="Pemilik" class="form-control" value="{{ old('Pemilik') }}" required>
</div>
<div class="form-group">
    <label for="Alamat"> Alamat </label>
    <input type="text" name="Alamat" id="Alamat" class="form-control" value="{{ old('Alamat') }}" required>
</div>

<div class="form-group">
    <label for="NoTelp">Nomor Telepon</label>
    <input type="number" name="NoTelp" id="NoTelp" class="form-control" value="{{ old('NoTelp') }}" required>
</div>

<div>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
</div>


<button type="submit" class="btn btn-sm btn-primary mt-3"> Simpan </button>
<a href="{{ route('profiltoko.index') }}" class="btn btn-sm btn-warning mt-3">Batal</a>
</div>
</form>
</div>
</div>
@endsection