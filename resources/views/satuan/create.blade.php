@extends('template.style')

@section('content')
<div class="container col-8">
<h3 class="text-center mb-4"> Tambah Data Satuan </h3>

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
<form action="{{ route('satuan.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="NamaSatuan"> Nama Satuan</label>
        <input type="text" name="NamaSatuan" id="NamaSatuan" class="form-control" value="{{ old('NamaSatuan') }}" required>
</div>


<button type="submit" class="btn btn-sm btn-primary mt-3"> Simpan </button>
<a href="{{ route('satuan.index') }}" class="btn btn-sm btn-warning mt-3">Batal</a>
</div>
</form>
</div>
</div>
@endsection


