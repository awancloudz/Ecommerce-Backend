<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ongkir extends Model
{
    protected $table = 'ongkir';

    protected $fillable = [
        'destination',
        'cityname',
        'service',
        'costs',
        'estimate',
        'created_at',
        'updated_at'
    ];
}
