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
        'categorylist',
        'categorylist/edit',
        'productlist',
        'productlist/edit',
        'productlist/kategori',
        'productlist/cari',
        'productlist/hapus',
        'cartlist',
        'cartlist/hapus',
        'userlogin',
        'user',
        'user/address',
        'citylist',
        'transaction',
        'transaction/confirmation',
        'profile',
    ];
}
