@extends('template.style')

@section('content')
<div class="card mx-auto mt-4" style="max-width: 700px; border: 2px solid #000; border-radius: 8px;">
    <div class="card-header">
        <h2 class="mb-0">Perbarui Data Metode Bayar</h2>
    </div>

    <div class="card-body">
        {{-- Tampilkan error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('metodebayar.update', $metodebayar->MetodeID) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="NamaMetode">Nama Metode Bayar</label>
                <input type="text" name="NamaMetode" id="NamaMetode" class="form-control" value="{{ $metodebayar->NamaMetode }}" required>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-sm btn-primary">Perbarui</button>
                <a href="{{ route('metodebayar.index') }}" class="btn btn-sm btn-warning">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
