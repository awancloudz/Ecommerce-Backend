<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    protected $table = 'alamat';

    protected $fillable = [
        'id_users', 
        'id_kota', 
        'namaalamat',
        'namapenerima',
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
    public function user(){
        return $this->belongsTo('App\User', 'id_users');
    }
}
