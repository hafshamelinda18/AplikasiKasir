@extends('template.style')

@section('content')

<div class="col-md-12">
    <h1 class="mb-4">Laporan Penjualan</h1>

    <!-- Form Filter Tanggal Produk Masuk -->
    <form method="GET" action="{{ route('laporan-penjualan') }}" class="mb-4 p-4 shadow-sm border rounded bg-light">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="start_date" class="form-label">Tanggal Awal</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="end_date" class="form-label">Tanggal Akhir</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary btn-block">Pilah Data</button>
            </div>
        </div>
    </form>

    <!-- Tombol Ekspor dan Cetak -->
    @if(request('start_date') && request('end_date'))
        <div class="mb-4 d-flex justify-content-start" id="exportPrintButtons">
            <button type="button" class="btn btn-sm btn-secondary" id="cetakLaporanButton">Cetak Laporan</button>
        </div>
    @endif

    <!-- Pesan Peringatan -->
    @if(!request('start_date') || !request('end_date'))
        <div class="alert alert-info" role="alert">
            <strong>Catatan:</strong> Silakan isi tanggal awal dan tanggal akhir sebelum memilah data.
        </div>
    @endif

    <!-- Tabel Laporan Produk Masuk -->
    <div class="table-responsive mb-4">
        <table class="table table-bordered table-striped">
            <thead class="bg-primary text-white">
                <tr>
                    <th>No</th>
                    <th>Id Penjualan</th>
                    <th>Tanggal Penjualan</th>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
    @php 
    $no = ($penjualan->currentPage() - 1) * $penjualan->perPage() + 1;
    @endphp
    @foreach($penjualan as $item)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $item->PenjualanID }}</td>
            <td>{{ \Carbon\Carbon::parse($item->TanggalPenjualan)->format('d-m-Y') }}</td>

            <!-- Check if pelanggan exists directly from the penjualan table -->
            <td>
                @if($item->pelanggan)
                    {{ $item->pelanggan->NamaPelanggan }}
                @else
                    <span class="text-danger">No Member</span>
                @endif
            </td>

            <!-- Gabungkan nama produk dalam satu kolom -->
            <td>
                @php
                    $produkNames = $item->detail->map(function($detail) {
                        return $detail->produk->NamaProduk;
                    })->implode(', ');
                @endphp
                {{ $produkNames }}
            </td>

            <!-- Total harga (Jika ingin menampilkan total dari semua detail) -->
            <td>
                
                {{ 'Rp'.number_format($item->TotalHarga, 0, ',', '.') }}
            </td>
        </tr>
    @endforeach
</tbody>

        </table>
    </div>

    <!-- Paginasi -->
    <div class="d-flex justify-content-center">
        {{ $penjualan->appends(request()->except('page'))->links() }}
    </div>

</div>

<script>
    document.getElementById('cetakLaporanButton').addEventListener('click', function() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;

        if (!startDate || !endDate) {
            alert('Silakan isi tanggal awal dan tanggal akhir untuk mencetak laporan.');
            return;
        }

        const url = `{{ route('cetak-laporan-penjualan') }}?start_date=${startDate}&end_date=${endDate}`;
        window.open(url, '_blank');
    });
</script>

@endsection
