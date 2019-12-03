<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Keranjang;
use App\TransaksiPenjualan;

class KeranjangController extends Controller
{
    public function index($iduser){
        //USER
        settype($iduser, "integer");
        //Seleksi transaksi terakhir
        $transaksi = TransaksiPenjualan::where('id_users', $iduser);
        $kodeakhir = $transaksi->orderBy('id', 'desc')->first();
        if($transaksi->count() > 0){
            $kode = "TRX-" . $iduser . "-" . sprintf("%05s", $kodeakhir->id + 1);
        }
        else
        {
            $kode = "TRX-" . $iduser . "-00001";
        }

        //Tampilkan Keranjang
        $daftarkeranjang = Keranjang::where('id_users',$iduser)->with('produk')->get();
        //$daftarkeranjang = $daftar->where('id_users',$iduser);
        $jumlahkeranjang = $daftarkeranjang->count();
        $total = 0;
        $subtotal = 0;
        if($jumlahkeranjang == 0){
            $koleksi2 = [
                ['user' => null,'subtotal' => 0,'kodepenjualan' => $kode,'jumlahkeranjang' => null],
            ];
        }
        else{
            //Subtotal
            foreach($daftarkeranjang as $keranjang){
                $user = $keranjang->id_users;
                $total = $keranjang->jumlah * $keranjang->produk->hargajual;
                $subtotal = $subtotal + $total;
            }
            
            $koleksi2 = [
                ['user' => $user,'subtotal' => $subtotal,'kodepenjualan' => $kode,'jumlahkeranjang' => $jumlahkeranjang],
            ];    
        }
        
        $koleksi = collect($daftarkeranjang);
        $koleksi->toJson();
        return compact('koleksi','koleksi2');
    }
    public function save(Request $request){
        $input = $request->all();
	    $createcart = Keranjang::create($input);
	    return $createcart;
    }
    public function update(Request $request){
        $item = $request->id;
        settype($item, "integer");
        //1.Pencarian berdasarkan ID
        $keranjang = Keranjang::findOrFail($item);
        //2.Mengambil data dari field edit
        $input = $request->all();
        //3.Menyimpan data 
        $keranjang->update($input);
        return $keranjang;
    }
    public function destroy($id){
        settype($id, "integer");
        $deletecart = Keranjang::findOrFail($id);
        $deletecart->delete();
        return $deletecart;
    }
}
