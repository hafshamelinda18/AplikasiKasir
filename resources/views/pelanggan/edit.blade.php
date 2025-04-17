@extends('template.style')

@section('content')

<div class="container col-8">
    <h3> Perbarui Data Member </h3>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li> {{ $error }} </li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('pelanggan.update', $pelanggan->PelangganID) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="NamaPelanggan"> Nama Pelanggan</label>
                    <input type="text" name="NamaPelanggan" id="NamaPelanggan" class="form-control" value="{{ $pelanggan->NamaPelanggan }}" required>
                </div>

                <div class="form-group">
                    <label for="Alamat"> Alamat </label>
                    <input type="text" name="Alamat" id="Alamat" class="form-control" value="{{ $pelanggan->Alamat }}" required>
                </div>

                <div class="form-group">
                    <label for="province_id">Provinsi</label>
                    <select name="province_id" id="province_id" class="form-control" required>
                        @foreach($provinces as $province)
                        <option value="{{ $province->id }}" {{ $province->id == $pelanggan->province_id ? 'selected' : '' }}>
                            {{ $province->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="regency_id">Kabupaten</label>
                    <select name="regency_id" id="regency_id" class="form-control" required>
                        @foreach($regencies as $regency)
                        <option value="{{ $regency->id }}" {{ $regency->id == $pelanggan->regency_id ? 'selected' : '' }}>
                            {{ $regency->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="district_id">Kecamatan</label>
                    <select name="district_id" id="district_id" class="form-control" required>
                        @foreach($districts as $district)
                        <option value="{{ $district->id }}" {{ $district->id == $pelanggan->district_id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="village_id">Desa</label>
                    <select name="village_id" id="village_id" class="form-control" required>
                        @foreach($villages as $village)
                        <option value="{{ $village->id }}" {{ $village->id == $pelanggan->village_id ? 'selected' : '' }}>
                            {{ $village->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $pelanggan->email }}" required>
                </div>

                <div class="form-group">
                    <label for="NoTelp">Nomor Telepon</label>
                    <input type="number" name="NoTelp" id="NoTelp" class="form-control" value="{{ $pelanggan->NoTelp }}" required>
                </div>

                <button type="submit" class="btn btn-sm btn-primary mt-3"> Perbarui </button>
                <a href="{{ route('pelanggan.index') }}" class="btn btn-sm btn-warning mt-3">Batal</a>

            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   $(document).ready(function () {
    var provinceID = $('#province_id').val();
    var regencyID = $('#regency_id').val();
    var districtID = $('#district_id').val();
    var villageID = $('#village_id').val();

    // Fetch regencies when the province is selected
    $('#province_id').on('change', function () {
        var provinceID = $(this).val();
        if (provinceID) {
            $.ajax({
                url: '/get-regencies/' + provinceID,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('#regency_id').empty().append('<option value="">Pilih Kabupaten</option>');
                    $.each(data, function (key, value) {
                        $('#regency_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });

                    // If there's a previously selected regency, select it again
                    if (regencyID) {
                        $('#regency_id').val(regencyID);
                        $('#regency_id').trigger('change');
                    }
                }
            });
        }
    });

    // Fetch districts when the regency is selected
    $('#regency_id').on('change', function () {
        var regencyID = $(this).val();
        if (regencyID) {
            $.ajax({
                url: '/get-districts/' + regencyID,
                type: "GET",
                dataType: "json",
                success: function (districtData) {
                    $('#district_id').empty().append('<option value="">Pilih Kecamatan</option>');
                    $.each(districtData, function (key, value) {
                        $('#district_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });

                    // If there's a previously selected district, select it again
                    if (districtID) {
                        $('#district_id').val(districtID);
                        $('#district_id').trigger('change');
                    }
                }
            });
        }
    });

    // Fetch villages when the district is selected
    // Fetch villages when the district is selected
$('#district_id').on('change', function () {
    var districtID = $(this).val();
    if (districtID) {
        $.ajax({
            url: '/get-villages/' + districtID,
            type: "GET",
            dataType: "json",
            success: function (data) {
                $('#village_id').empty().append('<option value="">Pilih Desa</option>');
                $.each(data, function (key, value) {
                    $('#village_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                });

                if (villageID) {
                    $('#village_id').val(villageID);
                }
            }
        });
    }
});


    // Trigger change on province dropdown to pre-populate
    if (provinceID) {
        $('#province_id').trigger('change');
    }
    if (regencyID) {
        $('#regency_id').trigger('change');
    }
    if (districtID) {
        $('#district_id').trigger('change');
    }
   
});

</script>

@endsection
