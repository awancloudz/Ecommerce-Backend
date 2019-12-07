<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Produk;
use App\FotoProduk;

class ProdukController extends Controller
{
    public function index(){
        $data = Produk::all();
        $jumlah = $data->count();
        if($jumlah > 0){
            $productlist = collect($data);
            $productlist->toJson();
            return $productlist;
        }
        else{
            $data = [
                ['id' => null],
            ];
            $productlist = collect($data);
            $productlist->toJson();
            return $productlist;
        }
    }
    public function show($id){
        $data = Produk::where('id', $id)->with('fotoproduk')->get();
        $jumlah = $data->count();
        if($jumlah > 0){
            $productlist = collect($data);
            $productlist->toJson();
            return $productlist;
        }
        else{
            $data = [
                ['id' => null],
            ];
            $productlist = collect($data);
            $productlist->toJson();
            return $productlist;
        }
    }
}
