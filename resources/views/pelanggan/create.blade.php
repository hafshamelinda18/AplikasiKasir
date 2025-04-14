@extends('template.style')

@section('content')

<div class="container col-8">
<h3 class="text-center mb-4"> Daftar Member </h3>

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
<form action="{{ route('pelanggan.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="NamaPelanggan"> Nama Member</label>
        <input type="text" name="NamaPelanggan" id="NamaPelanggan" class="form-control" value="{{ old('NamaPelanggan') }}" required>
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
<a href="{{ route('pelanggan.index') }}" class="btn btn-sm btn-warning mt-3">Batal</a>
</div>
</form>
</div>
</div>
@endsection