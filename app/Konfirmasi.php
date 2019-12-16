<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Konfirmasi extends Model
{
    protected $table = 'konfirmasi';

    protected $fillable = [
        'id_transaksipenjualan',
    	'nama',
        'bank',
        'norekening',
        'created_at',
        'updated_at'
    ];

    public function transaksipenjualan(){
        return $this->belongsTo('App\TransaksiPenjualan', 'id_transaksipenjualan');
    }
}
