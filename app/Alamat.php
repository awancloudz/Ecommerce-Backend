<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    protected $table = 'alamat';

    protected $fillable = [
        'id_users', 
        'id_kota', 
        'id_kecamatan',
        'namaalamat',
        'nama',
        'alamat',
        'kodepos',
        'nohp',
        'utama'
    ];

    public function transaksipenjualan(){
        return $this->hasMany('App\TransaksiPenjualan', 'id_alamat');
    }

    public function kota(){
        return $this->belongsTo('App\Kota', 'id_kota');
    }
    public function kecamatan(){
        return $this->belongsTo('App\Kecamatan', 'id_kecamatan');
    }
    public function user(){
        return $this->belongsTo('App\User', 'id_users');
    }
}
