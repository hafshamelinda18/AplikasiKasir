@extends('template.style')

@section('content')


<div class = "container">
<h2> Tambah Data Metod Bayar </h2>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li> {{ $error }} </li>
        @endforeach
</ul>
</div>
@endif

<form action="{{ route('metodebayar.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="NamaMetode"> Nama Metode</label>
        <input type="text" name="NamaMetode" id="NamaMetode" class="form-control" value="{{ old('NamaMetode') }}" required>
</div>


<button type="submit" class="btn btn-sm btn-primary mt-3"> Simpan </button>
<a href="{{ route('metodebayar.index') }}" class="btn btn-sm btn-warning mt-3">Batal</a>
</div>
</form>


@endsection
