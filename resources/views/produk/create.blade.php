@extends('template.style')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-7 mb-5">
        <!-- Card untuk Tampilan Formulir -->
        <div class="card mx-auto" style="max-width: 700px; border: 2px solid #000; border-radius: 8px;">
            <div class="card-header">
                <h2>Tambah Data Produk</h2>
            </div>
            <div class="card-body">

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li> {{ $error }} </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Gambar Produk -->
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Gambar</label>
                        <input type="file" class="form-control @if ($errors->has('image')) is-invalid @endif" name="image">
                    </div>

                    <div class="row">
                        <!-- Kode Produk -->
                        <div class="form-group col-md-6 mb-2">
                            <label for="KodeProduk">Kode Produk</label>
                            <input type="text" name="KodeProduk" id="KodeProduk" class="form-control" value="{{ old('KodeProduk', $produkKode) }}" readonly>
                        </div>

                        <!-- Nama Produk -->
                        <div class="form-group col-md-6 mb-2">
                            <label for="NamaProduk">Nama Produk</label>
                            <input type="text" name="NamaProduk" id="NamaProduk" class="form-control" value="{{ old('NamaProduk') }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Kategori -->
                        <div class="form-group col-md-6 mb-2">
                            <label for="KategoriID">Kategori</label>
                            <select name="KategoriID" id="KategoriID" class="form-control" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $kat)
                                    <option value="{{ $kat->KategoriID }}">
                                        {{ $kat->NamaKategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('KategoriID')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Satuan Produk -->
                        <div class="form-group col-md-6 mb-2">
                            <label for="SatuanID">Satuan</label>
                            <select name="SatuanID" id="SatuanID" class="form-control" required>
                                <option value="">Pilih Satuan</option>
                                @foreach ($satuan as $sat)
                                    <option value="{{ $sat->SatuanID }}">
                                        {{ $sat->NamaSatuan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('SatuanID')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Harga Produk -->
                    <div class="form-group mb-2">
                        <label for="Harga">Harga</label>
                        <input type="number" name="Harga" id="Harga" class="form-control" value="{{ old('Harga') }}" required>
                    </div>

                    <!-- Keterangan Produk -->
                    <div class="form-group mb-2">
                        <label for="Keterangan">Keterangan</label>
                        <textarea name="Keterangan" id="Keterangan" class="form-control">{{ old('Keterangan') }}</textarea>
                        @error('Keterangan')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tombol Simpan dan Batal -->
                    <div class="form-group mb-2">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('produk.index') }}" class="btn btn-warning">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Aktifkan select2 pada elemen dengan id 'KategoriID' dan 'SatuanID'
        $('#KategoriID').select2({
            placeholder: 'Pilih Kategori',
            allowClear: true
        });

        $('select[name="SatuanID"]').select2({
            placeholder: 'Pilih Satuan',
            allowClear: true,
            width: '100%' 
        });
    });
</script>

@endsection
