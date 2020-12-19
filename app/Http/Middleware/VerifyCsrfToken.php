<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'slidelist',
        'slidelist/edit',
        'categorylist',
        'categorylist/edit',
        'categorylist/cari',
        'categorylist/hapus',
        'productlist',
        'productlist/sorting',
        'productlist/edit',
        'productlist/kategori',
        'productlist/cari',
        'productlist/hapus',
        'productlist/hapusfoto',
        'cartlist',
        'cartlist/hapus',
        'userlogin',
        'user',
        'user/cari',
        'user/address',
        'citylist',
        'districtlist',
        'transaction',
        'transaction/cari',
        'transaction/confirmation',
        'transaction/noresi',
        'profile',
    ];
}
