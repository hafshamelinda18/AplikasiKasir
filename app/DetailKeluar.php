<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailKeluar extends Model
{
    protected $table = 'detail_produk_keluar';
    protected $primaryKey = 'DetailPKID';
    protected $fillable = [
        'ProdukID',
        'pkID',
        'JumlahKeluar',
    ];

    public function produkKeluar()
    {
        return $this->belongsTo(ProdukKeluar::class, 'pkID', 'pkID');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'ProdukID', 'ProdukID');
    }

}
