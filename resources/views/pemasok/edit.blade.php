@extends('template.style')

@section('content')

<div class="container col-8">
<h3> Perbarui Data Pemasok </h3>

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
<form action="{{ route('pemasok.update', $pemasok->PemasokID) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="Nama"> Nama Pemasok</label>
        <input type="text" name="Nama" id="Nama" class="form-control" value="{{ $pemasok->Nama }}" required>
</div>

<div class="form-group">
    <label for="Alamat"> Alamat </label>
    <input type="text" name="Alamat" id="Alamat" class="form-control" value="{{ $pemasok->Alamat }}" required>
</div>

<div class="form-group">
    <label for="NoTelp">Nomor Telepon</label>
    <input type="number" name="NoTelp" id="NoTelp" class="form-control" value="{{ $pemasok->NoTelp }}" required>
</div>

<div class="form-group">
    <label for="Email">Email</label>
    <input type="email" name="Email" id="Email" class="form-control" value="{{ $pemasok->Email }}" required>
</div>

<button type="submit" class="btn btn-sm btn-primary mt-3"> Perbarui </button>
<a href="{{ route('pemasok.index') }}" class="btn btn-sm btn-warning mt-3">Batal</a>

</div>
</form>
</div>
</div>
@endsection

