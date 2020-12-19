<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $fillable = [
        'id_kategoriproduk',
        'kodeproduk',
        'namaproduk',
        'deskripsi',
        'foto',
        'link',
        'stok',
        'berat',
        'hargabeli',
        'hargajual',
        'diskon',
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

    public function kategoriproduk(){
        return $this->belongsTo('App\KategoriProduk', 'id_kategoriproduk');
    }
}
