<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';

    protected $fillable = [
        'id_users',
        'id_produk',  
        'jumlah',      
    	'created_at',
        'updated_at'
    ];

    public function user(){
        return $this->belongsTo('App\User', 'id_users');
    }
    public function produk(){
        return $this->belongsTo('App\Produk', 'id_produk');
    }
}
