@extends('template.style')

@section('content')
<div class="container col-8">
<div class="card">
<div class="card-header"> <h3>Edit Profil</h3> </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container mt-4">
<div class="row mb-4 justify-content-center">
<div class="col-md-8">
<div class="card shadow-sm border-0 rounded" style="background-color: #F0F0F0; color: #333;">
<div class="card-body">
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
        <!-- Tambahkan field lain jika diperlukan -->
        <button type="submit" class="btn btn-sm btn-success">Perbarui Profil</button>
        <a href="{{ route('profile.show') }}" class="btn btn-sm btn-warning">Batal</a>
    </form>
</div>
</div>
</div>
</div>
</div>
@endsection
