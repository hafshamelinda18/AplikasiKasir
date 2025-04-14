@extends('template.style')

@section('content')
<div class="container col-8">
    <div class="card">
        <div class="card-header">
            <h3>Profil Toko</h3>
        </div>

        @if(session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif

        <div class="container mt-4">
            <div class="row mb-4">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded" style="background-color: #F0F0F0; color: #333;">
                        <div class="card-body">
                            <h5 class="card-title"><strong>{{ $toko->NamaToko }}</strong></h5>
                            <p><strong>Alamat:</strong> {{ $toko->Alamat }}</p>
                            <p><strong>Nomor Telepon:</strong> {{ $toko->NoTelp }}</p>
                            <p><strong>Email:</strong> {{ $toko->email }}</p>
                            <p><strong>Pemilik:</strong> {{ $toko->Pemilik }}</p>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded" style="background-color: #F0F0F0; color: #333;">
                        <div class="card-body">
                            <!-- Tampilkan logo toko jika ada -->
                            @if($toko->logo)
                                <div class="mb-3 text-center">
                                    <img src="{{ asset('storage/' . $toko->logo) }}" alt="Logo {{ $toko->NamaToko }}" style="max-width: 150px;" class="img-fluid rounded">
                                </div>
                            @endif
                            
                            
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tombol Edit Profil di Bawah -->
            <div class="text-center">
                <a href="{{ route('profiltoko.edit', $toko->IdToko) }}" class="btn btn-sm btn-primary mt-3">Edit Profil</a>
            </div>
        </div>
    </div>
</div>
@endsection
