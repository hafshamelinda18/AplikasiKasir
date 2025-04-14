@extends('template.style')

@section('content')

<div class="container col-lg-12 col-md-12">

<div class="col-md-9 mx-auto">
    <h2 class="text-center mb-4">Data Produk Keluar</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

 

<div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('produkkeluar.create') }}" class="btn btn-sm btn-primary">
                Tambah <i class="material-icons text-sm">add</i>
            </a>

            <!-- Form Pencarian -->
            <form action="{{ route('produkkeluar.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Produk Keluar..." class="form-control me-2" />
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
                    <th>Jumlah Keluar</th>
                    <th> Tanggal Keluar</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($produkkeluars as $item)
                    @foreach ($item->detailKeluar as $index => $detail)
                        <tr>
                            @if ($loop->first)
                                <td rowspan="{{ $item->detailKeluar->count() }}">{{ ($produkkeluars->currentPage() - 1) * $produkkeluars->perPage() + $loop->parent->iteration }}</td>
                                <td rowspan="{{ $item->detailKeluar->count() }}">
                                    {{ $item->detailKeluar->groupBy('ProdukID')->count() }} 
                                </td>
                                <td>
                                {{ $item->detailKeluar->sum('JumlahKeluar') }}

                                </td>
                              
                            @endif
                                     
                            @if ($loop->first)
                                <td rowspan="{{ $item->detailKeluar->count() }}">{{ $item->tanggal_keluar }}</td>
                                <td rowspan="{{ $item->detailKeluar->count() }}">{{ $item->keterangan }}</td>
                                <td rowspan="{{ $item->detailKeluar->count() }}">
                                
                                
                                <form action="{{ route('produkkeluar.destroy', $item->pkID) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="material-icons text-sm">delete</i>
                                                </button>
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

{{ $produkkeluars->links() }}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000); // Hilangkan notifikasi setelah 5 detik
</script>

@endsection