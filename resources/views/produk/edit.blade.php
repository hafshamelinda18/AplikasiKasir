@extends('template.style')

@section('content')

<div class = "container">

<h2> Perbarui Data Produk </h2>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li> {{ $error }} </li>
        @endforeach
</ul>
</div>
@endif

<form action="{{ route('produk.update', $produk->ProdukID )  }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
            <label class="font-weight-bold">Gambar</label>
            <br>
            @if($produk->image)
                <img src="{{ asset('storage/'.$produk->image) }}" class="img-fluid mb-2" style="max-width: 400px;">
            @else
                <p>Tidak ada gambar yang diunggah</p>
            @endif
            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
            @error('image')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
        <label for="KodeProduk"> Kode Produk</label>
        <input type="text" name="KodeProduk" id="KodeProduk" class="form-control" value="{{ $produk->KodeProduk }}" readonly>
</div>

    <div class="form-group">
        <label for="NamaProduk"> Nama Produk</label>
        <input type="text" name="NamaProduk" id="NamaProduk" class="form-control" value="{{ $produk->NamaProduk }}" required>
</div>

<div class="form-group">
<label for="KategoriID"> Kategori </label>
<select name="KategoriID" id="KategoriID" class="form-control" required>
    <option value=""> Pilih Kategori </option>
    @foreach ( $kategori as $kat )
        <option value="{{ $kat->KategoriID }}" {{ $produk->KategoriID == $kat->KategoriID ? 'selected' : '' }}>
            {{ $kat->NamaKategori }}
        </option>
    @endforeach
    </select>
    @error('PelangganID')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
</div>

<div class="form-group">
<label for="SatuanID"> Satuan </label>
<select name="SatuanID" id="SatuanID" class="form-control" required>
    <option value=""> Pilih Satuan </option>
    @foreach ( $satuan as $sat )
        <option value="{{ $sat->SatuanID }}" {{ $produk->SatuanID == $sat->SatuanID ? 'selected' : ''}}>
            {{ $sat->NamaSatuan }}
        </option>
    @endforeach
    </select>
    @error('SatuanID')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
</div>

<div class="form-group">
    <label for="Harga"> Harga </label>
    <input type="number" name="Harga" id="Harga" class="form-control" value="{{ $produk->Harga }}" required>
</div>


<div class="form-group">
            <label for="Keterangan">Keterangan</label>
            <textarea name="Keterangan" id="Keterangan" class="form-control"> {{ old('Keterangan', $produk->Keterangan) }} </textarea>
            @error('keterangan')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

<button type="submit" class="btn btn-sm btn-primary mt-3"> Simpan </button>
<a href="{{ route('produk.index') }}" class="btn btn-sm btn-warning mt-3">Batal</a>
</div>
</form>


@endsection