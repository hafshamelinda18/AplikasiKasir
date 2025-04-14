@extends('template.style')

@section('content')


    @if(session('success'))
<div class= "alert alert-success"> {{session('success')}} </div>
@endif

    <div class="container">
        <h1 class="mb-4">Detail Produk Masuk</h1>

        <div class="card">
            <div class="card-header">
                <h4>Daftar Produk Masuk</h4>
            </div>

            <div class="card-body">
                <p><strong>Tanggal Masuk:</strong> {{ $produkSupply->TanggalSupply ? \Carbon\Carbon::parse($produkSupply->TanggalSupply)->format('d-m-Y') : 'Tidak ada tanggal' }}</p>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th> Nama Pemasok </th>
                            <th>Jumlah Produk</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produkSupply->DetailSup as $detail)
                            <tr>
                                <td>{{ $detail->produk->NamaProduk }}</td>
                                <td>{{ $detail->pemasok->Nama }}</td>
                                <td>{{ $detail->JumlahMasuk }}</td>
                                <td>{{'Rp'.number_format($detail->HargaBeli, 2, ',', '.') }}</td>
                                <td>{{'Rp'.number_format($detail->total_harga, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4"><strong>Total: </strong>{{'Rp'.number_format($produkSupply->Totalharga, 2, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer d-flex justify-content-between">
           
          
            <a href="{{ route('produksupply.index') }}" class="btn btn-sm btn-warning mt-3">Kembali</a>
            </div>
        </div>
    </div>

@endsection