<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiPenjualan extends Model
{
    protected $table = 'transaksipenjualan';

    protected $fillable = [
        'kodetransaksi',
        'id_users',
    	'tanggal',
        'totaldiskon',
        'totalbelanja',
        'totalongkir',
        'subtotal',
        'layanan',
        'biaya',
        'status',
        'jenis',
        'created_at',
        'updated_at'
    ];

    public function detailpenjualan(){
        return $this->hasMany('App\DetailPenjualan', 'id_transaksipenjualan');
    }

    public function user(){
        return $this->belongsTo('App\User', 'id_users');
    }
}
