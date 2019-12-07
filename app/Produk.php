<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $fillable = [
        'kodeproduk',
        'namaproduk',
        'deskripsi',
        'foto',
        'link',
        'stok',
        'berat',
        'hargabeli',
        'hargajual',
        'hargagrosir',
        'dilihat',
        'terjual',
        'created_at',
        'updated_at'
    ];

    public function keranjang(){
        return $this->hasMany('App\Keranjang', 'id_produk');
    }
    public function detailpenjualan(){
        return $this->hasMany('App\DetailPenjualan', 'id_produk');
    }
    public function fotoproduk(){
        return $this->hasMany('App\FotoProduk', 'id_produk');
    }
}
