@extends('template.style')

@section('content')

<div class="container col-8">
<h3> Perbarui Data Kategori </h3>

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
    <di class="card-body">
<form action="{{ route('kategori.update', $kategori->KategoriID) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="NamaKategori"> Nama Kategori</label>
        <input type="text" name="NamaKategori" id="NamaKategori" class="form-control" value="{{ $kategori->NamaKategori }}" required>
</div>


<button type="submit" class="btn btn-sm btn-primary mt-3"> Perbarui </button>
<a href="{{ route('kategori.index') }}" class="btn btn-sm btn-warning mt-3">Batal</a>

</div>
</form>
</div>
</div>
@endsection

