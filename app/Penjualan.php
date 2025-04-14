<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualans';
    protected $primaryKey = 'PenjualanID';
    protected $fillable = ['TanggalPenjualan', 'TotalHarga', 'PelangganID', 'NamaKasir'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'PelangganID', 'PelangganID'); 
    }

    public function detail()
    {
        return $this->hasMany(Detail::class, 'PenjualanID', 'PenjualanID');
    }
}
