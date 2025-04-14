<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';
    protected $primaryKey = 'KategoriID';
    protected $fillable = [ 'NamaKategori'];

    public function produk(){
        return $this->hasMany(Produk::class, 'KategoriID', 'KategoriID');
    }
    
}
