<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    protected $table = 'satuans';
    protected $primaryKey = 'SatuanID';
    protected $fillable = ['NamaSatuan'];

    public function produk(){

        return $this->hasMany(Produk::class, 'SatuanID', 'SatuanID');
    }
    

}
