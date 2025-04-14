<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

<div class = "container">
<h2> Perbarui Data Penjualan </h2>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li> {{ $error }} </li>
        @endforeach
</ul>
</div>
@endif

<form action="{{ route('penjualan.update', $penjualan->PenjualanID) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="TanggalPenjualan"> Tanggal Penjualan</label>
        <input type="date" name="TanggalPenjualan" id="TanggalPenjualan" class="form-control" value="{{ $penjualan->TanggalPenjualan }}" required>
</div>

<div class="form-group">
    <label for="TotalHarga"> Total Harga </label>
    <input type="number" name="TotalHarga" id="TotalHarga" class="form-control" value="{{ $penjualan->TotalHarga }}" required>
</div>

<div class="form-group">
    <label for="PelangganID">Nama Pelanggan</label>
        <select name="PelangganID" id="PelangganID" class="form-control" required>
            <option value="">Pilih Pelanggan</option>
                @foreach($pelanggan as $item)
                    <option value="{{ $item->PelangganID }}" {{$penjualan->PelangganID == $penjualan->PelangganID ? 'selected' : ''}}>
                        {{ $item->NamaPelanggan }}
                    </option>
                @endforeach
            </select>
            @error('PelangganID')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

<button type="submit" class="btn btn-sm btn-primary mt-3"> Perbarui </button>
<a href="{{ route('pelanggan.index') }}" class="btn btn-sm btn-warning mt-3">Batal</a>
</form>



