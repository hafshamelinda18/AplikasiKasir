@extends('template.style')

@section('content')
<div class="container">
    <h1>Pembayaran</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form id="formPembayaran" action="{{ route('pembayaran.store') }}" method="POST">
        @csrf
        <div class="form-group">
                        <label for="TanggalPembayaran">Tanggal Bayar</label>
                        <input type="date" name="TanggalPembayaran" id="TanggalPembayaran" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>

        </div>

        <div class="card-body">
            <p>
            <input type="hidden" name="PenjualanID" value="{{ $penjualan->PenjualanID }}">

                <strong>Tanggal Penjualan:</strong> 
                {{ $penjualan->TanggalPenjualan ? \Carbon\Carbon::parse($penjualan->TanggalPenjualan)->format('d-m-Y') : 'Tidak ada tanggal' }}
            </p>
            <p>
                <strong>Nama Pelanggan:</strong> 
               
    @if($penjualan->pelanggan)
        {{ $penjualan->pelanggan->NamaPelanggan }}
    @else
        <span class="btn btn-secondary">No Member</span>
    @endif

            </p>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Jumlah Produk</th>
                        <th>Harga</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penjualan->detail as $detail)
                        <tr>
                            <td>{{ $detail->produk->NamaProduk }}</td>
                            <td>{{ $detail->JumlahProduk }}</td>
                            <td>{{ 'Rp'.number_format($detail->Harga, 2, ',', '.') }}</td>
                            <td>{{ 'Rp'.number_format($detail->SubTotal, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4">
                            <strong>Total: </strong>
                            {{ 'Rp'.number_format($penjualan->TotalHarga, 2, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <input type="hidden" id="totalHarga" value="{{ $penjualan->TotalHarga }}">

        <div class="form-group">
            <label for="JumlahBayar">Jumlah Bayar</label>
            <input type="number" name="JumlahBayar" id="JumlahBayar" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="MetodeID">Metode Pembayaran</label>
            <select name="MetodeID" class="form-control">
                <option value="">Pilih Metode Bayar</option>
                @foreach($metode_bayars as $metode)
                    <option value="{{ $metode->MetodeID }}">{{ $metode->NamaMetode }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
    <label for="Kembalian">Kembalian</label>
    <input type="number" name="Kembalian" id="Kembalian" class="form-control" readonly>
</div>

<button type="submit" id="btnSubmit" class="btn btn-sm btn-primary mt-3">Bayar</button>
    </form>
    
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('#JumlahBayar').on('input', function() {
            var jumlahBayar = parseFloat($(this).val()) || 0;
            var totalHarga = parseFloat($('#totalHarga').val()) || 0;
            var kembalian = jumlahBayar - totalHarga;
            $('#Kembalian').val(kembalian);
        });
    });

    $(document).ready(function() {
    $('#formPembayaran').on('submit', function(e) {
        e.preventDefault(); // cegah submit default
        $('#btnSubmit').prop('disabled', true);
        Swal.fire({
            title: 'Memproses Pembayaran...',
            text: 'Harap tunggu sejenak',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Pembayaran Berhasil',
                    text: response.message,
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Buka struk di tab baru
                    window.open("{{ route('pembayaran.struk', $penjualan->PenjualanID) }}", '_blank');
                    
                    // Redirect ke index penjualan
                    window.location.href = "{{ route('penjualan.index') }}"; // arahkan ke halaman penjualan index
                });
            },
            error: function(xhr, status, error) {
                let errorMsg = 'Silakan coba lagi.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Pembayaran Gagal',
                    text: errorMsg
                });
                $('#btnSubmit').prop('disabled', false);
            }
        });
    });
});


</script>

@endsection
