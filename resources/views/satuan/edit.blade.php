@extends('template.style')

@section('content')

<div class="container col-8">

<h3> Perbarui Data Satuan </h3>

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
<form action="{{ route('satuan.update', $satuan->SatuanID) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="NamaSatuan"> Nama Satuan</label>
        <input type="text" name="NamaSatuan" id="NamaSatuan" class="form-control" value="{{ $satuan->NamaSatuan }}" required>
</div>


<button type="submit" class="btn btn-sm btn-primary mt-3"> Perbarui </button>
<a href="{{ route('satuan.index') }}" class="btn btn-sm btn-warning mt-3">Batal</a>

</div>
</form>
</div>
</div>
@endsection

