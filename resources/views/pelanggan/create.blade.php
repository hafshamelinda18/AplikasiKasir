@extends('template.style')

@section('content')

<div class="container col-8">
<h3 class="text-center mb-4"> Daftar Member </h3>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li> {{ $error }} </li>
        @endforeach
</ul>
</div>
@endif

<div class="card mx-auto" style="max-width: 700px; border: 2px solid #000; border-radius: 8px;">
    <div class="card-body">
<form action="{{ route('pelanggan.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="NamaPelanggan"> Nama Member</label>
        <input type="text" name="NamaPelanggan" id="NamaPelanggan" class="form-control" value="{{ old('NamaPelanggan') }}" required>
</div>

<div class="form-group">
    <label for="Alamat"> Alamat </label>
    <input type="text" name="Alamat" id="Alamat" class="form-control" value="{{ old('Alamat') }}" required>
</div>
<div class="form-group">
            <label for="province_id">Provinsi</label>
            <select name="province_id" id="province_id" class="form-control" required>
                @foreach($provinces as $province)
                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="regency_id">Kabupaten</label>
            <select name="regency_id" id="regency_id" class="form-control" required>
                @foreach($regencies as $regency)
                    <option value="{{ $regency->id }}">{{ $regency->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="district_id">Kecamatan</label>
            <select name="district_id" id="district_id" class="form-control" required>
                @foreach($districts as $district)
                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="village_id">Desa</label>
            <select name="village_id" id="village_id" class="form-control" required>
                @foreach($villages as $village)
                    <option value="{{ $village->id }}">{{ $village->name }}</option>
                @endforeach
            </select>
        </div>

<div class="form-group">
    <label for="NoTelp">Nomor Telepon</label>
    <input type="number" name="NoTelp" id="NoTelp" class="form-control" value="{{ old('NoTelp') }}" required>
</div>

<div>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
</div>


<button type="submit" class="btn btn-sm btn-primary mt-3"> Simpan </button>
<a href="{{ route('pelanggan.index') }}" class="btn btn-sm btn-warning mt-3">Batal</a>
</div>
</form>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#province_id').on('change', function () {
        var provinceID = $(this).val();
        if (provinceID) {
            $.ajax({
                url: '/get-regencies/' + provinceID,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('#regency_id').empty();
                    $('#regency_id').append('<option value="">Pilih Kabupaten</option>');
                    $.each(data, function (key, value) {
                        $('#regency_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });

                    $('#district_id').empty().append('<option value="">Pilih Kecamatan</option>');
                    $('#village_id').empty().append('<option value="">Pilih Desa</option>');
                }
            });
        }
    });

    $('#regency_id').on('change', function () {
        var regencyID = $(this).val();
        if (regencyID) {
            $.ajax({
                url: '/get-districts/' + regencyID,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('#district_id').empty();
                    $('#district_id').append('<option value="">Pilih Kecamatan</option>');
                    $.each(data, function (key, value) {
                        $('#district_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });

                    $('#village_id').empty().append('<option value="">Pilih Desa</option>');
                }
            });
        }
    });

    $('#district_id').on('change', function () {
        var districtID = $(this).val();
        if (districtID) {
            $.ajax({
                url: '/get-villages/' + districtID,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('#village_id').empty();
                    $('#village_id').append('<option value="">Pilih Desa</option>');
                    $.each(data, function (key, value) {
                        $('#village_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        }
    });
</script>
@endsection