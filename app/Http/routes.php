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
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Requested-With, x-xsrf-token');

Route::get('scrape/asal/{asal}/tujuan/{tujuan}/berat/{berat}/kurir/{kurir}', [
    'as' => 'scrape', 'uses' => 'TransaksiPenjualanController@scrape']);
Route::get('transaction/asal/{asal}/tujuan/{tujuan}/berat/{berat}', [
    'as' => 'ongkir', 'uses' => 'TransaksiPenjualanController@ongkir']);
Route::get('scrapekecamatan', 'TransaksiPenjualanController@scrapekecamatan');

Route::get('categorylist', 'ProdukController@categorylist');
Route::post('categorylist', 'ProdukController@storecategory');
Route::get('categorylist/{id}', 'ProdukController@showcategory');
Route::post('categorylist/edit','ProdukController@updatecategory');
Route::delete('categorylist/hapus/{id}', 'ProdukController@destroycategory');
Route::post('categorylist/cari','ProdukController@caricategory');
Route::get('productlist', 'ProdukController@index');
Route::get('productlist/sorting/{id}', 'ProdukController@indexsorting');
Route::get('productlist/{id}', 'ProdukController@show');
Route::get('productlist/kategori/{cat}','ProdukController@category');
Route::post('productlist','ProdukController@store');
Route::post('productlist/edit','ProdukController@updateproduct');
Route::post('productlist/cari','ProdukController@cari');
Route::delete('productlist/hapus/{id}', 'ProdukController@destroy');
Route::delete('productlist/hapusfoto/{id}', 'ProdukController@destroyfoto');

Route::get('cartlist/{iduser}', 'KeranjangController@index');
Route::delete('cartlist/hapus/{id}', 'KeranjangController@destroy');
Route::post('cartlist', 'KeranjangController@save');
Route::put('cartlist', 'KeranjangController@update');

Route::get('userlogin/{email}/password/{password}', 'UserController@userlogin');
Route::get('user/{iduser}', 'UserController@userlist');
Route::post('user', 'UserController@createuser');
Route::put('user', 'UserController@updateuser');
Route::post('user/cari','UserController@cari');
Route::get('user/address/{iduser}', 'UserController@addresslist');
Route::get('user/address/main/{iduser}', 'UserController@addressmain');
Route::get('user/setaddress/{address}', 'UserController@setaddress');
Route::delete('user/address/{id}', 'UserController@destroy');
Route::post('user/address', 'UserController@createaddress');

Route::get('citylist', 'UserController@citylist');
Route::get('citylist/{id}', 'UserController@detailcity');
Route::get('districtlist', 'UserController@districtlist');
Route::get('districtlist/{id}', 'UserController@detaildistrict');

Route::get('transaction/{iduser}', 'TransaksiPenjualanController@index');
Route::get('transaction/view/{idtrans}', 'TransaksiPenjualanController@view');
Route::get('transaction/detail/{idtrans}', 'TransaksiPenjualanController@detail');
Route::get('transaction/checkout/{kode}', 'TransaksiPenjualanController@checkout');
Route::post('transaction', 'TransaksiPenjualanController@save');
Route::put('transaction/noresi', 'TransaksiPenjualanController@saveresi');
Route::post('transaction/confirmation', 'TransaksiPenjualanController@saveconfirmation');
Route::post('transaction/cari','TransaksiPenjualanController@cari');

Route::get('profile', 'ProfileController@index');
Route::put('profile', 'ProfileController@update');

Route::get('slidelist', 'SlideController@index');
Route::get('slidelist/{id}', 'SlideController@show');
Route::post('slidelist','SlideController@store');
Route::post('slidelist/edit','SlideController@updateslide');
Route::delete('slidelist/hapus/{id}', 'SlideController@destroy');