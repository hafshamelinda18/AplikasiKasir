<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdukKeluar extends Model
{
   
    protected $table = 'produk_keluar';
    protected $primaryKey = 'pkID';
    protected $fillable = ['tanggal_keluar', 'keterangan'];

    public function detailkeluar()
    {
        return $this->hasMany(DetailKeluar::class, 'pkID', 'pkID');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'ProdukID', 'ProdukID');
    }

    
}
