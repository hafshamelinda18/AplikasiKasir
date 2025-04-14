@extends('template.style')

@section('content')


<div class="container col-8">
<h3> Perbarui Data Member </h3>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li> {{ $error }} </li>
        @endforeach
</ul>
</div>
@endif

<div class="card">
    <div class="card-body">
<form action="{{ route('pelanggan.update', $pelanggan->PelangganID) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="NamaPelanggan"> Nama Pelanggan</label>
        <input type="text" name="NamaPelanggan" id="NamaPelanggan" class="form-control" value="{{ $pelanggan->NamaPelanggan }}" required>
</div>

<div class="form-group">
    <label for="Alamat"> Alamat </label>
    <input type="text" name="Alamat" id="Alamat" class="form-control" value="{{ $pelanggan->Alamat }}" required>
</div>
<div class="form-group">
    <label for="email">Email</label>
    <input type="email" name="email" id="email" class="form-control" value="{{ $pelanggan->email }}" required>
</div>
<div class="form-group">
    <label for="NoTelp">Nomor Telepon</label>
    <input type="number" name="NoTelp" id="NoTelp" class="form-control" value="{{ $pelanggan->NoTelp }}" required>
</div>

<button type="submit" class="btn btn-sm btn-primary mt-3"> Perbarui </button>
<a href="{{ route('pelanggan.index') }}" class="btn btn-sm btn-warning mt-3">Batal</a>

</div>
</form>
</div>
</div>

@endsection
