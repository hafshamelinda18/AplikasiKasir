@extends('template.style')

@section('content')
<style>
    body.modal-open {
        padding-right: 0 !important;
    }

    body.modal-open-fix {
        overflow: auto !important;
        padding-right: 0 !important;
    }

    .modal-backdrop {
        z-index: 1040 !important;
    }

    .modal {
        z-index: 1050 !important;
    }

    table {
        table-layout: fixed;
        width: 100%;
    }

    /* Pastikan font modal struk tidak ikut modal utama */
    .struk-content {
        font-family: 'Courier New', Courier, monospace;
    }
</style>

<div class="container-fluid">
    <div class="col-md-10 mx-auto">
        <h2 class="text-center mb-4">Data Penjualan</h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('penjualan.create') }}" class="btn btn-primary btn-sm">
                Tambah <i class="material-icons text-sm">add</i>
            </a>
            <form action="{{ route('penjualan.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Penjualan..." class="form-control me-2" />
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="material-icons text-sm">search</i>
                </button>
            </form>
        </div>

        <div class="card">
            <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table text-center align-middle mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama Pelanggan</th>
                                <th>Harga Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penjualans as $penjualan)
                                <tr>
                                    <td>{{ ($penjualans->currentPage() - 1) * $penjualans->perPage() + $loop->iteration }}</td>
                                    <td>{{ $penjualan->TanggalPenjualan }}</td>
                                    <td>
                                        @if($penjualan->pelanggan)
                                            {{ $penjualan->pelanggan->NamaPelanggan }}
                                        @else
                                            <span class="badge bg-secondary">No Member</span>
                                        @endif
                                    </td>
                                    <td>Rp{{ number_format($penjualan->TotalHarga, 2, ',', '.') }}</td>
                                    <td>
                                        <span class="fw-bold text-uppercase {{ $penjualan->status_pembayaran === 'lunas' ? 'text-success' : 'text-danger' }}" style="font-size: 0.8rem;">
                                            {{ $penjualan->status_pembayaran }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($penjualan->status_pembayaran === 'belum lunas')
                                            <a href="{{ route('pembayaran.create', $penjualan->PenjualanID) }}" class="btn btn-success btn-sm" title="Bayar">
                                                <i class="material-icons text-sm">payment</i>
                                            </a>
                                        @endif
                                        <a href="{{ route('pembayaran.struk', $penjualan->PenjualanID) }}" target="_blank" class="btn btn-info btn-sm" title="Lihat Struk">
    <i class="material-icons text-sm">visibility</i>
</a>

                                      
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data penjualan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-3">
                    {{ $penjualans->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Struk -->
<!-- <div class="modal fade" id="modalStruk" tabindex="-1" aria-labelledby="modalStrukLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Struk Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div id="modalStrukContent" class="struk-content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="printStruk()">Print</button>
            </div>
        </div>
    </div>
</div> -->

<!-- Script -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    setTimeout(() => $('.alert').fadeOut('slow'), 5000);

    function lihatStruk(penjualanId) {
        $.ajax({
            url: `/penjualan/${penjualanId}/struk`,
            method: 'GET',
            success: function(response) {
                $('#modalStrukContent').html(`<div class="struk-content">${response}</div>`);
                $('#modalStruk').modal('show');
            },
            error: function() {
                alert('Gagal memuat struk');
            }
        });
    }

    $('#modalStruk').on('show.bs.modal', function () {
        document.body.classList.add('modal-open-fix');
    });

    $('#modalStruk').on('hidden.bs.modal', function () {
        document.body.classList.remove('modal-open-fix');
        $('#modalStrukContent').html('');
    });

    function printStruk() {
        const content = document.getElementById('modalStrukContent').innerHTML;
        const iframe = document.createElement('iframe');
        iframe.style.position = 'fixed';
        iframe.style.width = '0';
        iframe.style.height = '0';
        iframe.style.border = '0';
        document.body.appendChild(iframe);

        const doc = iframe.contentWindow.document;
        doc.open();
        doc.write(`
            <html>
                <head>
                    <title>Print Struk</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
                    <style>
                        body {
                            padding: 20px;
                            font-family: 'Courier New', Courier, monospace;
                        }
                        @media print {
                            body {
                                font-size: 14px;
                            }
                        }
                    </style>
                </head>
                <body>${content}</body>
            </html>
        `);
        doc.close();

        iframe.onload = function () {
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
            setTimeout(() => {
                document.body.removeChild(iframe);
            }, 1000);
        };
    }
</script> -->
@endsection
