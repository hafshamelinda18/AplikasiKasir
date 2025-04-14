@extends('template.style')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<style>

    .center-text-input {
        text-align: center;
    }
    .form-row {
        display: grid;
        grid-template-columns: repeat(5, 1fr) auto;
        gap: 10px; /* Memberi jarak antar kolom */
    }

    
</style>

<div class="container col-10">
    <h2>Tambah Produk Masuk</h2>
    
    <div class="card mx-auto" style="max-width: 700px; border: 2px solid #000; border-radius: 8px;">
        <div class="card-body">
            
            <form action="{{ route('produksupply.store') }}" method="POST">
                @csrf
                
                <!-- Tanggal Masuk -->
                <div class="form-group">
                    <label for="TanggalSupply">Tanggal Masuk:</label>
                    <input type="date" name="TanggalSupply" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                </div>

                <hr>

                <!-- Detail Barang -->
                <h4>List Produk</h4>
                <div id="produk-DetailSup" class="d-flex flex-wrap">
                    <div class="form-row d-flex align-items-end mb-4 w-100">
                        <div class="form-group col-md-2">
                            <label for="PemasokID[]">Pemasok:</label>
                            <select name="PemasokID[]" class="form-control" required>
                                <option value="">Pilih Pemasok</option>
                                @foreach($pemasoks as $pemasok)
                                    <option value="{{ $pemasok->PemasokID }}">{{ $pemasok->Nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="ProdukID[]">Produk:</label>
                            <select name="ProdukID[]" class="form-control" required>
                                <option value="">Pilih Produk</option>
                                @foreach($produks as $barang)
                                    <option value="{{ $barang->ProdukID }}">{{ $barang->NamaProduk }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="tanggal_kadaluarsa[]">Tanggal Kadaluarsa:</label>
                            <input type="date" name="tanggal_kadaluarsa[]" class="form-control">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="JumlahMasuk[]">Jumlah Masuk:</label>
                            <input type="number" name="JumlahMasuk[]" class="form-control center-text-input" required min="1" onchange="calculateTotal()">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="HargaBeli[]">Harga Beli:</label>
                            <input type="number" name="HargaBeli[]" class="form-control center-text-input" required min="0" step="0.01" onchange="calculateTotal()">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="remove"></label>
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)"><i class="material-icons text-sm">delete</i></button>
                        </div>
                    </div>
                </div>
                
                <!-- Hidden Total Harga -->
                <div class="form-group">
                    <input type="number" name="Totalharga" id="Totalharga" class="form-control" value="{{ old('Totalharga') }}" hidden>
                </div>

                <!-- Tombol Tambah Barang Lain -->
                <button type="button" class="btn btn-sm btn-info mb-3" id="add-more"><i class="material-icons text-sm">add</i></button>

                <!-- Total Harga -->
                <div class="form-group">
                    <h5>Total Harga: <span id="total-harga">0</span></h5>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                <a href="{{ route('produksupply.index') }}" class="btn btn-sm btn-warning">Batal</a>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
    // Aktifkan select2 pada elemen dengan nama 'PemasokID[]' dan 'ProdukID[]'
    $('select[name="PemasokID[]"], select[name="ProdukID[]"]').select2({
        placeholder: 'Pilih opsi',
        allowClear: true,
        width: '100%' // Atur lebar Select2 agar sesuai dengan elemen form
    });
});

// Fungsi untuk menambahkan baris barang baru
document.getElementById('add-more').addEventListener('click', function() {
    var container = document.getElementById('produk-DetailSup');
    var newRow = document.createElement('div');
    newRow.classList.add('form-row', 'd-flex', 'align-items-end', 'mb-4', 'w-100');
    newRow.innerHTML = `
        <div class="form-group col-md-2">
            <label for="PemasokID[]">Pemasok:</label>
            <select name="PemasokID[]" class="form-control" required>
                <option value="">Pilih Pemasok</option>
                @foreach($pemasoks as $pemasok)
                    <option value="{{ $pemasok->PemasokID }}">{{ $pemasok->Nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-2">
            <label for="ProdukID[]">Produk:</label>
            <select name="ProdukID[]" class="form-control" required>
                <option value="">Pilih Produk</option>
                @foreach($produks as $barang)
                    <option value="{{ $barang->ProdukID }}">
                        {{ $barang->NamaProduk }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-2">
            <label for="tanggal_kadaluarsa[]">Tanggal Kadaluarsa:</label>
            <input type="date" name="tanggal_kadaluarsa[]" class="form-control" required>
        </div>
        <div class="form-group col-md-2">
            <label for="JumlahMasuk[]">Jumlah Masuk:</label>
            <input type="number" name="JumlahMasuk[]" class="form-control center-text-input" required min="1" onchange="calculateTotal()">
        </div>
        <div class="form-group col-md-2">
            <label for="HargaBeli[]">Harga Beli:</label>
            <input type="number" name="HargaBeli[]" class="form-control center-text-input" required min="0" step="0.01" onchange="calculateTotal()">
        </div>
        <div class="form-group col-md-1">
            <label for="remove"></label>
            <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)"><i class="material-icons text-sm">delete</i></button>
        </div>
    `;
    container.appendChild(newRow);

    // Terapkan select2 untuk elemen select yang baru ditambahkan
    $('select[name="PemasokID[]"], select[name="ProdukID[]"]').select2({
        placeholder: 'Pilih opsi',
        allowClear: true,
        width: '100%'
    });
});


    // Fungsi untuk menghapus baris barang
    function removeRow(button) {
        var row = button.closest('.form-row');
        row.remove();
        calculateTotal();
    }

    // Fungsi untuk menghitung total harga
    function calculateTotal() {
        var total = 0;
        var rows = document.querySelectorAll('#produk-DetailSup .form-row');
        rows.forEach(function(row) {
            var JumlahMasuk = row.querySelector('input[name="JumlahMasuk[]"]').value;
            var HargaBeli = row.querySelector('input[name="HargaBeli[]"]').value;

            if (JumlahMasuk && HargaBeli) {
                total += (parseFloat(JumlahMasuk) * parseFloat(HargaBeli));
            }
        });

        document.getElementById('total-harga').innerText = total.toFixed(2);
        document.getElementById('Totalharga').value = total.toFixed(2);
    }
</script>

@endsection
