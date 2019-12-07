<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FotoProduk extends Model
{
    protected $table = 'fotoproduk';

    protected $fillable = [
        'id_produk',  
        'foto',      
    	'created_at',
        'updated_at'
    ];

    public function produk(){
        return $this->belongsTo('App\Produk', 'id_produk');
    }
}
