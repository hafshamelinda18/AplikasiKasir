<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'PembayaranID';
    protected $fillable = [
        'TanggalPembayaran',
        'PenjualanID',
        'MetodeID',
        'JumlahBayar',
        'Kembalian'
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'PenjualanID', 'PenjualanID');
    }

    public function metode()
    {
        return $this->belongsTo(MetodeBayar::class, 'MetodeID', 'MetodeID');
    }
}
