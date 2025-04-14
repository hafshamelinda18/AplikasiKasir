<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'ProdukID';
    protected $fillable = [
        'KodeProduk',
        'NamaProduk',
        'KategoriID',
        'SatuanID',
        'PemasokID',
        'Harga',
        'image',
        'Keterangan'
    ];

    public function detail()
    {
        return $this->hasMany(Detail::class, 'ProdukID', 'ProdukID');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'KategoriID', 'KategoriID');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'SatuanID', 'SatuanID');
    }

    public function DetailSup() 
    {
        return $this->hasMany(SupplyDetail::class, 'ProdukID', 'ProdukID');
    }

    public function DetailPK() 
    {
        return $this->hasMany(DetailKeluar::class, 'ProdukID', 'ProdukID');
    }
    
    public static function boot()
    {
        parent::boot();

        static::creating(function ($produk) {
            // Memastikan kode produk diisi jika kosong
            if (empty($produk->KodeProduk)) {
                $produk->KodeProduk = 'P' . str_pad(Produk::max('ProdukID') + 1, 3, '0', STR_PAD_LEFT);
            }
        });
    }
}
