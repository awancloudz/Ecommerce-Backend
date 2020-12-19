<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';

    protected $fillable = [
        'id_kota',
        'namakecamatan',
        'created_at',
        'updated_at'
    ];

    public function alamat(){
        return $this->hasMany('App\Alamat', 'id_kecamatan');
    }
    public function kota(){
        return $this->belongsTo('App\Kota', 'id_kota');
    }
}
