@extends('template.style')

@section('content')

<div class = "container">
<h2> Perbarui Data Metode Bayar </h2>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li> {{ $error }} </li>
        @endforeach
</ul>
</div>
@endif

<form action="{{ route('metodebayar.update', $metodebayar->MetodeID) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="NamaMetode"> Nama Metode Bayar</label>
        <input type="text" name="NamaMetode" id="NamaMetode" class="form-control" value="{{ $metodebayar->NamaMetode }}" required>
</div>


<button type="submit" class="btn btn-sm btn-primary mt-3"> Perbarui </button>
<a href="{{ route('metodebayar.index') }}" class="btn btn-sm btn-warning mt-3">Batal</a>

</div>
</form>

@endsection

