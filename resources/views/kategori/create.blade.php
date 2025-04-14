@extends('template.style')

@section('content')


<div class="container col-8">
<h3 class="text-center mb-4"> Tambah Data Kategori </h3>

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
<form action="{{ route('kategori.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="NamaKategori"> Nama Kategori</label>
        <input type="text" name="NamaKategori" id="NamaKategori" class="form-control" value="{{ old('NamaKategori') }}" required>
</div>


<button type="submit" class="btn btn-sm btn-primary mt-3"> Simpan </button>
<a href="{{ route('kategori.index') }}" class="btn btn-sm btn-warning mt-3">Batal</a>
</div>
</form>
</div>
</div>

@endsection
