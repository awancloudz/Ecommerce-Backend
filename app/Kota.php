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

    public function user(){
        return $this->hasMany('App\User', 'id_kota');
    }
}
