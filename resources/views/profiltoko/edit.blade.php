@extends('template.style')

@section('content')

<div class="container col-8">
    <h3>Perbarui Data Profil Toko</h3>

    <!-- Tampilkan pesan error jika ada -->
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
            <form action="{{ route('profiltoko.update', $toko->IdToko) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Kolom Pertama -->
                    <div class="col-md-6">
                        <!-- Field untuk nama toko -->
                        <div class="form-group">
                            <label for="NamaToko">Nama Toko</label>
                            <input type="text" name="NamaToko" id="NamaToko" class="form-control" value="{{ $toko->NamaToko }}" required>
                        </div>

                        <!-- Field untuk nama pemilik -->
                        <div class="form-group">
                            <label for="Pemilik">Nama Pemilik</label>
                            <input type="text" name="Pemilik" id="Pemilik" class="form-control" value="{{ $toko->Pemilik }}" required>
                        </div>

                        <!-- Field untuk nomor telepon -->
                        <div class="form-group">
                            <label for="NoTelp">Nomor Telepon</label>
                            <input type="number" name="NoTelp" id="NoTelp" class="form-control" value="{{ $toko->NoTelp }}" required>
                        </div>
                    </div>

                    <!-- Kolom Kedua -->
                    <div class="col-md-6">
                        <!-- Field untuk alamat -->
                        <div class="form-group">
                            <label for="Alamat">Alamat</label>
                            <input type="text" name="Alamat" id="Alamat" class="form-control" value="{{ $toko->Alamat }}" required>
                        </div>

                        <!-- Field untuk email -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ $toko->email }}" required>
                        </div>

                        <!-- Field untuk mengunggah logo toko -->
                        <div class="form-group">
                            <label class="font-weight-bold">Logo Toko</label>
                            <br>
                            @if($toko->logo)
                                <img src="{{ asset('storage/'.$toko->logo) }}" class="img-fluid mb-2" style="max-width: 200px;">
                            @else
                                <p>Tidak ada logo yang diunggah</p>
                            @endif
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo">
                            @error('logo')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Tombol submit dan batal -->
                <button type="submit" class="btn btn-sm btn-primary mt-3">Perbarui</button>
                <a href="{{ route('profiltoko.show', 1) }}" class="btn btn-sm btn-warning mt-3">Batal</a>
            </form>
        </div>
    </div>
</div>

@endsection
