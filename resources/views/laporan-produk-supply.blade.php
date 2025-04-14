@extends('template.style')

@section('content')

<div class="col-md-12">
    <h1 class="mb-4">Laporan Produk Masuk</h1>

    <!-- Form Filter Tanggal Produk Masuk -->
    <form method="GET" action="{{ route('laporan-produk-supply') }}" class="mb-4 p-4 shadow-sm border rounded bg-light">
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
    <div class="alert alert-info" role="alert">
        <strong>Catatan:</strong> Silakan isi tanggal awal dan tanggal akhir sebelum memilah data.
    </div>

    <!-- Tabel Laporan Produk Masuk -->
    <div class="table-responsive mb-4">
        <table class="table table-bordered table-striped">
            <thead class="bg-primary text-white">
                <tr>
                    <th>No</th>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Jumlah Masuk</th>
                    <th>Tanggal Masuk</th>
                   
                </tr>
            </thead>
            <tbody>
            @php $no = 1; @endphp
                @foreach($produkSupply as $item)
                    @foreach($item->detailSup as $detail)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $detail->produk ? $detail->produk->KodeProduk : 'N/A' }}</td>
                            <td>{{ $detail->produk ? $detail->produk->NamaProduk : 'N/A' }}</td>
                            <td>{{ $detail->JumlahMasuk }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->TanggalSupply)->format('d-m-Y') }}</td>
                           
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Paginasi -->
    <div class="d-flex justify-content-center">
        {{ $produkSupply->appends(request()->except('page'))->links() }}
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

        const url = `{{ route('cetak-laporan-produk-supply') }}?start_date=${startDate}&end_date=${endDate}`;
        window.open(url, '_blank');
    });
</script>

@endsection
