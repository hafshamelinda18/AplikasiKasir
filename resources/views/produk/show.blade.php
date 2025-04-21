@extends('template.style')

@section('content')
<div class="col-md-12">
    <h3>Detail Produk</h3>

    <div class="row">
        <div class="col-md-4">
        <div class="form-group">
            <label class="font-weight-bold">Gambar</label>
            <br>
            @if($produk->image)
                <img src="{{ asset('storage/' .$produk->image) }}" class="img-fluid mb-2" style="max-width: 100%;">
            @else
                <p>Tidak ada gambar yang diunggah</p>
            @endif
        </div>
    </div>


        <div class="col-md-8">
            <table class="table table-bordered">
                <tr>
                    <th>Kode Produk</th>
                    <td>{{ $produk->KodeProduk }}</td>
                </tr>
                <tr>
                    <th>Nama Produk</th>
                    <td>{{ $produk->NamaProduk }}</td>
                </tr>
                <tr>
                    <th>Kategori Produk</th>
                    @if ($produk->kategori)
                      <td>{{ $produk->kategori->NamaKategori }}</td>
                    @else
                        <td><span class="text-danger">Tidak Ada Kategori</span></td>
                    @endif
                </tr>
                <tr>
                    <th>Satuan Produk</th>
                    @if ($produk->satuan)
            <td>{{ $produk->satuan->NamaSatuan }}</td>
        @else
            <td><span class="text-danger">Tidak Ada Satuan</span></td>
        @endif
                </tr>
                <tr>
                    <th>Harga</th>
                    <td>{{ 'Rp' . number_format($produk->Harga, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <th><strong>Stok</strong></th>
                    <td>{{ $produk->Stok }}</td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td>{{ $produk->Keterangan }}</td>
                </tr>
            </table>
        </div>
    </div>

    <a href="{{ route('produk.index') }}" class="btn btn-sm btn-warning">Kembali</a>
</div>
@endsection
