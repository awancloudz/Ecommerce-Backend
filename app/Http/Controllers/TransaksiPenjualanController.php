<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\TransaksiPenjualan;
use App\DetailPenjualan;
use App\Keranjang;
use App\Produk;

class TransaksiPenjualanController extends Controller
{
    public function index($iduser){
        //USER
        settype($iduser, "integer");
        //Seleksi transaksi 
        $daftartransaksi = TransaksiPenjualan::where('id_users',$iduser)->with('detailpenjualan')->get();
        $jumlahtransaksi = $daftartransaksi->count();
        $koleksi = collect($daftartransaksi);
        $koleksi->toJson();
        return $koleksi;
    }
    public function checkout($kode){
        //Seleksi transaksi 
        $daftartransaksi = TransaksiPenjualan::where('kodetransaksi',$kode)->with('detailpenjualan')->get();
        $jumlahtransaksi = $daftartransaksi->count();
        $koleksi = collect($daftartransaksi);
        $koleksi->toJson();
        return $koleksi;
    }
    public function save(Request $request){
        $input = $request->all();
        $createtransaction = TransaksiPenjualan::create($input);
        
        $iduser = $request->input('id_users');
        settype($iduser, "integer");
        //Ambil ID Transaksi
        $id_awal = TransaksiPenjualan::where('id_users', $iduser)->orderBy('id', 'desc')->first();
        $idtransaksi = $id_awal->id;
        settype($idtransaksi, "integer");

        //Tampilkan Keranjang
        $daftar = Keranjang::all();
        $daftarkeranjang = $daftar->where('id_users',$iduser);
        //Simpan DetailPenjualan
        foreach($daftarkeranjang as $keranjang){
            $detailpenjualan = New DetailPenjualan;
            $detailpenjualan->id_transaksipenjualan = $idtransaksi;
            $detailpenjualan->id_produk = $keranjang->id_produk;
            $detailpenjualan->jumlah = $keranjang->jumlah;
            $detailpenjualan->save();
            //Update Stok
            $produk = Produk::findOrFail($keranjang->id_produk);
            $stokawal = $produk->stok;
            $stokakhir = $stokawal - $keranjang->jumlah;
            $produk->stok = $stokakhir;
            $produk->update();
            //Hapus Keranjang
            $keranjang->delete();
        }

	    return $createtransaction;
    }
}
