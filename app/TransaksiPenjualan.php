<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiPenjualan extends Model
{
    protected $table = 'transaksipenjualan';

    protected $fillable = [
        'kodetransaksi',
        'id_users',
        'id_alamat',
    	'tanggal',
        'totaldiskon',
        'totalbelanja',
        'totalongkir',
        'subtotal',
        'kurir',
        'layanan',
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
    public function alamat(){
        return $this->belongsTo('App\Alamat', 'id_alamat');
    }
}
