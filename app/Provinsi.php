<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'provinsi';

    protected $fillable = [
        'namaprovinsi',
        'created_at',
        'updated_at'
    ];

    //Relasi One to Many dari
    public function kota(){
        return $this->hasMany('App\Kota', 'id_provinsi');
    }
}
