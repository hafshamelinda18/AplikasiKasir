@extends('template.style')

@section('content')

<div class="container col-lg-12 col-md-12">

<div class="col-md-9 mx-auto">
    <h2 class="text-center mb-4">Data Produk Masuk</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

 

<div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('produksupply.create') }}" class="btn btn-sm btn-primary">
                Tambah <i class="material-icons text-sm">add</i>
            </a>

            <!-- Form Pencarian -->
            <form action="{{ route('produksupply.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Produk Masuk..." class="form-control me-2" />
                <button type="submit" class="btn btn-sm btn-primary"><i class="material-icons text-sm">search</i> </button>
            </form>
        </div>

    <div class="card">
            <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table text-center align-middle mb-0">
                        <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($produksupplys as $item)
                    @foreach ($item->DetailSup as $index => $detail)
                        <tr>
                            @if ($loop->first)
                                <td rowspan="{{ $item->DetailSup->count() }}">{{ ($produksupplys->currentPage() - 1) * $produksupplys->perPage() + $loop->parent->iteration }}</td>
                                <td rowspan="{{ $item->DetailSup->count() }}">
                                    {{ $item->DetailSup->groupBy('ProdukID')->count() }} 
                                </td>
                                <td>
                                {{ $item->DetailSup->sum('JumlahMasuk') }}

                                </td>
                                <td>{{'Rp'.number_format($detail->JumlahMasuk * $detail->HargaBeli, 2, ',', '.' ) }}</td>
                            @endif
                        
                           
                            @if ($loop->first)
                                <td rowspan="{{ $item->DetailSup->count() }}">{{ $item->TanggalSupply }}</td>
                                <td rowspan="{{ $item->DetailSup->count() }}">
                                
                                <a href="{{route('produksupply.show', $item->SupplyID) }}" class="btn btn-sm btn-info">  <i class="material-icons text-sm">visibility</i> </a>
                                        <form action="{{ route('produksupply.destroy', $item->SupplyID) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger me-2"><i class="material-icons text-sm">delete</i></button>
                                        </form>
                                        
                                   
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data barang masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        
    </div>
</div>

{{ $produksupplys->links() }}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000); // Hilangkan notifikasi setelah 5 detik
</script>

@endsection