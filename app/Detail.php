<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $table = 'detail_penjualan';
    protected $primaryKey = 'DetailID';
    protected $fillable = [
        'PenjualanID',
        'ProdukID',
        'Harga', 
        'JumlahProduk' 
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'PenjualanID', 'PenjualanID');  
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'ProdukID', 'ProdukID');
    }
}
