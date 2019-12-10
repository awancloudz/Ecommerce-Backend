<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    protected $table = 'kota';

    protected $fillable = [
        'id_provinsi',
        'namakota',
        'created_at',
        'updated_at'
    ];

    //Relasi One to Many ke
    public function provinsi(){
        return $this->belongsTo('App\Provinsi', 'id_provinsi');
    }

    public function alamat(){
        return $this->hasMany('App\Alamat', 'id_kota');
    }
}
