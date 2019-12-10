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
header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Requested-With, x-xsrf-token');

Route::get('scrape/asal/{asal}/tujuan/{tujuan}/berat/{berat}/kurir/{kurir}', [
    'as' => 'scrape', 'uses' => 'TransaksiPenjualanController@scrape']);
Route::get('transaction/asal/{asal}/tujuan/{tujuan}/berat/{berat}', [
    'as' => 'ongkir', 'uses' => 'TransaksiPenjualanController@ongkir']);

Route::get('productlist', 'ProdukController@index');
Route::get('productlist/{id}', 'ProdukController@show');

Route::get('cartlist/{iduser}', 'KeranjangController@index');
Route::post('cartlist', 'KeranjangController@save');
Route::put('cartlist', 'KeranjangController@update');
Route::delete('cartlist/{item}', 'KeranjangController@destroy');

Route::get('userlogin/{email}/password/{password}', 'UserController@userlogin');
Route::get('user/{iduser}', 'UserController@userlist');
Route::get('user/address/{iduser}', 'UserController@addresslist');
Route::get('user/address/main/{iduser}', 'UserController@addressmain');
Route::post('user', 'UserController@createuser');
Route::put('user', 'UserController@updateuser');

Route::get('citylist', 'UserController@citylist');

Route::get('transaction/{iduser}', 'TransaksiPenjualanController@index');
Route::get('transaction/checkout/{kode}', 'TransaksiPenjualanController@checkout');
Route::post('transaction', 'TransaksiPenjualanController@save');
