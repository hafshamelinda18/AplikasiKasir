<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pemasok extends Model
{
    protected $table = 'pemasoks';
    protected $primaryKey = 'PemasokID';
    protected $fillable = [
        'Nama',
        'NoTelp',
        'Alamat',
        'Email'
    ];

    public function produk()
    {
        return $this->hasMany(Produk::class, 'PemasokID', 'PemasokID');
    }

    public function DetailSup()
    {
        return $this->hasMany(SupplyDetail::class, 'PemasokID', 'PemasokID');
    }

}

