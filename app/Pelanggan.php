<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable; 
class Pelanggan extends Model
{
    
    protected $table = 'pelanggans';
    protected $primaryKey = 'PelangganID';
    protected $fillable = ['NamaPelanggan', 'Alamat', 'NoTelp', 'email', 'member'];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'PelangganID', 'PelangganID');
    }
}
