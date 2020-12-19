<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $table = 'slide';

    protected $fillable = [
        'judul',
        'deskripsi',
        'foto',
        'judultombol',
        'link',
        'created_at',
        'updated_at'
    ];
}
