@extends('template.style')

@section('content')
<div class="container col-lg-12 col-md-12 d-flex justify-content-center"> <!-- Mengatur agar konten berada di tengah -->

    <div class="col-md-10 mx-auto">
        <h2 class="text-center mb-4">Data Metode Bayar</h2>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Tombol Tambah -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('metodebayar.create') }}" class="btn btn-sm btn-primary">
                Tambah <i class="material-icons text-sm">add</i>
            </a>

            <!-- Form Pencarian -->
            <form action="{{ route('metodebayar.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Metode..." class="form-control me-2" />
                <button type="submit" class="btn btn-sm btn-primary"><i class="material-icons text-sm">search</i> </button>
            </form>
        </div>

        <!-- Tabel Data Metode Bayar -->
        <div class="card shadow-lg border-0 rounded-lg">
            <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table table-striped text-center align-middle mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Metode Bayar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($metodebayars as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->NamaMetode }}</td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('metodebayar.edit', $item->MetodeID) }}" class="btn btn-sm btn-info">
                                        <i class="material-icons text-sm">edit</i>
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('metodebayar.destroy', $item->MetodeID) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="material-icons text-sm">delete</i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $metodebayars->links() }}
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000); // Hilangkan notifikasi setelah 5 detik
</script>

@endsection
