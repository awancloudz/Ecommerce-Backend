<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('productlist', 'ProdukController@index');
Route::get('cartlist/{iduser}', 'KeranjangController@index');
Route::post('cartlist', 'KeranjangController@save');
Route::put('cartlist', 'KeranjangController@update');
Route::delete('cartlist/{item}', 'KeranjangController@destroy');
Route::get('userlogin/{email}/password/{password}', 'UserController@userlogin');