@extends('template.style')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<style>
    .center-text-input {
        text-align: center;
    }
    .form-section {
        margin-bottom: 20px;
    }
</style>

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container col-10">
    <h2 class="text-center mb-4">Tambah Data Penjualan</h2>

    <div class="card mx-auto" style="max-width: 700px; border: 2px solid #000; border-radius: 8px;">
    <div class="card-body">
        <div class="row">
            <!-- Form Penjualan -->
            <div class="col-md-12 mb-5">
                <form action="{{ route('penjualan.store') }}" method="POST">
                    @csrf
                    <div class="row form-section">
                        <!-- Nama Kasir -->
                        <div class="form-group col-md-6">
                            <label for="NamaKasir">Nama Kasir</label>
                            <input type="text" name="NamaKasir" id="NamaKasir" class="form-control" value="{{ Auth::user()->name }}" readonly>
                        </div>
                        <!-- Tanggal Penjualan -->
                        <div class="form-group col-md-6">
                            <label for="TanggalPenjualan">Tanggal Penjualan</label>
                            <input type="date" name="TanggalPenjualan" id="TanggalPenjualan" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                        </div>
                        </div>

                        <!-- Jenis Pelanggan -->
                        <div class="form-group form-section">
                            <label>Jenis Pelanggan:</label><br>
                            <label class="ml-3">
                                <input type="radio" name="isMember" value="0" id="non-member" checked> Non-Member
                            </label>
                            <label>
                                <input type="radio" name="isMember" value="1" id="member" > Member
                            </label>
                            
                        </div>

                        <!-- Pilihan Pelanggan (hanya untuk member) -->
                        <div id="pelanggan-section" class="form-group form-section">
                            <label for="PelangganID">Pelanggan:</label>
                            <select id="PelangganID" name="PelangganID" class="form-control">
                                <option value="">Pilih Pelanggan</option>
                                @foreach($pelanggan as $pelanggan)
                                    <option value="{{ $pelanggan->PelangganID }}">{{ $pelanggan->NamaPelanggan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <input type="number" name="TotalHarga" id="TotalHarga" class="form-control" value="{{ old('TotalHarga') }}" hidden>

                        <!-- Daftar Produk -->
                        <div id="produk-details" class="form-section">
                            <div class="form-row d-flex align-items-end mb-4">
                                <div class="form-group col-md-3">
                                    <label for="ProdukID[]">Produk:</label>
                                    <select name="ProdukID[]" class="form-control" required onchange="updatePrice(this)">
                                        <option value="">Pilih Produk</option>
                                        @foreach($produk as $barang)
                                            <option value="{{ $barang->ProdukID }}" data-harga="{{ $barang->Harga }}">{{ $barang->NamaProduk }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="JumlahProduk[]">Jumlah Produk:</label>
                                    <input type="number" name="JumlahProduk[]" class="form-control center-text-input" required min="1" onchange="calculateTotal()">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="Harga[]">Harga:</label>
                                    <input type="number" name="Harga[]" class="form-control center-text-input" required min="0" step="0.01" readonly>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="remove"></label>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)"><i class="material-icons text-sm">delete</i></button>
                                </div>
                            </div>
                        </div>

                        <!-- Tambah Produk -->
                        <button type="button" class="btn btn-sm btn-info mb-3" id="add-more"><i class="material-icons text-sm">add</i></button>

                        <!-- Total Harga -->
                        <div class="form-group">
                            <h5>Total Harga: <span id="total-harga">0</span></h5>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="form-group form-section">
                            <button type="submit" class="btn btn-sm btn-primary mt-3">Simpan</button>
                            <a href="{{ route('penjualan.index') }}" class="btn btn-sm btn-warning mt-3">Batal</a>
                        </div>
                    </form>
                </div>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
                <script>
                    $(document).ready(function() {
                        $('#PelangganID').select2({
                            placeholder: 'Pilih Pelanggan',
                            allowClear: true
                        });

                        $('select[name="ProdukID[]"]').select2({
                            placeholder: 'Pilih Produk',
                            allowClear: true,
                            width: '100%'
                        });
                    });

                    function togglePelangganInput() {
                        const selectedMember = document.querySelector('input[name="isMember"]:checked').value;
                        const pelangganSection = document.getElementById('pelanggan-section');
                        const pelangganSelect = document.getElementById('PelangganID');

                        if (selectedMember == "1") {
                            pelangganSection.style.display = 'block';
                            pelangganSelect.required = true;
                        } else {
                            pelangganSection.style.display = 'none';
                            pelangganSelect.required = false;
                        }
                    }

                    togglePelangganInput();

                    document.querySelectorAll('input[name="isMember"]').forEach(function(radio) {
                        radio.addEventListener('change', togglePelangganInput);
                    });

                    function updatePrice(selectElement) {
                        const selectedOption = selectElement.options[selectElement.selectedIndex];
                        const HargaInput = selectElement.closest('.form-row').querySelector('input[name="Harga[]"]');
                        HargaInput.value = selectedOption.getAttribute('data-harga') || 0;
                        calculateTotal();
                    }

                    document.getElementById('add-more').addEventListener('click', function() {
                        const container = document.getElementById('produk-details');
                        const newRow = document.createElement('div');
                        newRow.classList.add('form-row', 'd-flex', 'align-items-end', 'mb-4');
                        newRow.innerHTML = `
                            <div class="form-group col-md-3">
                                <label for="ProdukID[]">Produk:</label>
                                <select name="ProdukID[]" class="form-control" required onchange="updatePrice(this)">
                                    <option value="">Pilih Produk</option>
                                    @foreach($produk as $barang)
                                        <option value="{{ $barang->ProdukID }}" data-harga="{{ $barang->Harga }}">{{ $barang->NamaProduk }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="JumlahProduk[]">Jumlah Produk:</label>
                                <input type="number" name="JumlahProduk[]" class="form-control center-text-input" required min="1" onchange="calculateTotal()">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="Harga[]">Harga:</label>
                                <input type="number" name="Harga[]" class="form-control center-text-input" required min="0" step="0.01" readonly>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="remove"></label>
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)"><i class="material-icons text-sm">delete</i></button>
                            </div>
                        `;
                        container.appendChild(newRow);

                        $(newRow.querySelector('select[name="ProdukID[]"]')).select2({
                            placeholder: 'Pilih Produk',
                            allowClear: true,
                            width: '100%'
                        });
                    });

                    function removeRow(button) {
                        const row = button.closest('.form-row');
                        row.remove();
                        calculateTotal();
                    }

                    function calculateTotal() {
                        let total = 0;
                        const rows = document.querySelectorAll('#produk-details .form-row');
                        rows.forEach(function(row) {
                            const jumlah = row.querySelector('input[name="JumlahProduk[]"]').value;
                            const harga = row.querySelector('input[name="Harga[]"]').value;
                            total += jumlah * harga;
                        });
                        document.getElementById('total-harga').textContent = total;
                        document.getElementById('TotalHarga').value = total;
                    }
                </script>
            </div>
        </div>
    </div>
</div>
@endsection
