<?php

namespace App;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable; 
class Pelanggan extends Model
{
    
    protected $table = 'pelanggans';
    protected $primaryKey = 'PelangganID';
    protected $fillable = ['NamaPelanggan', 'Alamat', 'NoTelp', 'email', 'member', 
    'province_id', 'regency_id', 'district_id', 'village_id'];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'PelangganID', 'PelangganID');
    }


public function province()
{
    return $this->belongsTo(Province::class);
}

public function regency()
{
    return $this->belongsTo(Regency::class);
}

public function district()
{
    return $this->belongsTo(District::class);
}

public function village()
{
    return $this->belongsTo(Village::class);
}

}
