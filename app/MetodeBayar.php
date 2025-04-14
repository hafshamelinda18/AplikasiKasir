<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetodeBayar extends Model
{
    protected $table = 'metode_bayar';
    protected $primaryKey = 'MetodeID';
    protected $fillable = ['NamaMetode'];

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'MetodeID', 'MetodeID');
    }
}
