<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 
        'email', 
        'nohp',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function keranjang(){
        return $this->hasMany('App\Keranjang', 'id_users');
    }
    public function transaksipenjualan(){
        return $this->hasMany('App\TransaksiPenjualan', 'id_users');
    }
    public function alamat(){
        return $this->hasMany('App\Alamat', 'id_users');
    }
}
