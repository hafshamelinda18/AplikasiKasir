@extends('template.style')

@section('content')
<div class="container col-8">
<div class="card">
<div class="card-header">  <h3>Profil Saya</h3> </div>

   
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
<div class="container mt-4">
<div class="row mb-4 justify-content-center">
<div class="col-md-8">
<div class="card shadow-sm border-0 rounded" style="background-color: #F0F0F0; color: #333;">
<div class="card-body">
    <p><strong>Nama:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <!-- Tampilkan informasi lain sesuai kebutuhan -->
<p>
    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-primary mt-3">Edit Profil</a>
</div>

</div>
</div>
</div>
</div>
@endsection




