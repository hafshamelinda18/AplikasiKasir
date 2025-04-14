<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdukSupply extends Model
{
    protected $table = 'produk_supply';
    protected $primaryKey = 'SupplyID';
    protected $fillable = ['TanggalSupply', 'Totalharga'];

    public function DetailSup()
    {
        return $this->hasMany(SupplyDetail::class, 'SupplyID', 'SupplyID');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'ProdukID', 'ProdukID');
    }

    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class, 'PemasokID', 'PemasokID');
    }

    
}

