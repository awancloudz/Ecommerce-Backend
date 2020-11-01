<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    protected $table = 'kategoriproduk';

    protected $fillable = [
        'nama',
        'link',
        'foto',      
    	'created_at',
        'updated_at'
    ];

    public function produk(){
        return $this->hasMany('App\Produk', 'id_kategoriproduk');
    }
}
