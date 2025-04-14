<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfilToko extends Model
{
    protected $table = 'profil_toko';
    protected $primaryKey = 'IdToko';
    protected $fillable =  [
        'NamaToko',
        'Alamat',
        'NoTelp',
        'email',
        'Pemilik',
        'logo'
    ];
}
