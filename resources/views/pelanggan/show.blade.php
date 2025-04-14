<div class="col-md-9">
    <h1 class="mb-4">Detail Penjualan</h1>
    
    <div class="card">
        <div class="card-header">
            <h4>Daftar Penjualan</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                       
                        <th>Nama Pelanggan</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Harga Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penjualan->detail as $detail)
                    <tr>
                       
                        <td>{{ $detail->pelanggan->NamaPelanggan }}</td>
                        <td>{{ $detail->produk->NamaProduk }}</td>
                        <td>{{ number_format($detail->harga, 2) }}</td>
                        <td>{{ number_format($detail->JumlahProduk * $detail->harga, 2) }}</td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <p><strong>Tanggal Penjualan:</strong> {{ $penjualan->TanggalPenjualan ? \Carbon\Carbon::parse($penjualan->TanggalPenjualan)->format('d-m-Y') : 'Tidak ada tanggal' }}</p>
        </div>
        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('penjualan.index') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@endsection
