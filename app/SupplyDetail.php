<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplyDetail extends Model
{
    protected $table = 'detail_produk_supply';
    protected $primaryKey = 'DetailSupID';
    protected $fillable = [
        'SupplyID',
        'ProdukID',
        'HargaBeli',
        'JumlahMasuk',
        'PemasokID',
        'tanggal_kadaluarsa',
        
    ];

    public function ProdukSupp()
    {
        return $this->belongsTo(ProdukSupply::class, 'SupplyID', 'SupplyID');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'ProdukID', 'ProdukID');
    }

    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class, 'PemasokID', 'PemasokID');
    }

    public static function getProdukKadaluarsaDalam30Hari()
    {
        $tanggalSekarang = Carbon::now();
        $tanggal30Hari = Carbon::now()->addDays(30);

        return self::whereBetween('tanggal_kadaluarsa', [$tanggalSekarang, $tanggal30Hari])
            ->get();
    }
}
