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
    public function ongkir($asal, $tujuan, $berat, $kurir){
		//Cek Ongkir
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "origin=".$asal."&destination=".$tujuan."&weight=".$berat."&courier=".$kurir,
		  CURLOPT_HTTPHEADER => array(
			"content-type: application/x-www-form-urlencoded",
			"key: e200ef6f31f5ba64525f28725d4a980d"
		  ),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		
		if ($err) {
			echo "cURL Error #:" . $err;
		  } else {
			  $data = json_decode($response, true);
			  $pengiriman = array();
			  $ongkir = array();
			  $pengiriman[] = array(
				  'origin'=> $data['rajaongkir']['origin_details']['city_name'], 
				  'destination'=> $data['rajaongkir']['destination_details']['city_name'],
				  'weight'=> $data['rajaongkir']['query']['weight'],
				  'courier'=> $data['rajaongkir']['results'][0]['name'],
			  );
  
			  for ($i=0; $i < count($data['rajaongkir']['results'][0]['costs']); $i++) {
				  $ongkir[] = array(
					  'service' => $data['rajaongkir']['results'][0]['costs'][$i]['service'],
					  'costs' => $data['rajaongkir']['results'][0]['costs'][$i]['cost'][0]['value'],
					  'estimate' => $data['rajaongkir']['results'][0]['costs'][$i]['cost'][0]['etd'],
				  );
			  }
		  }
		  $datakirim = collect($pengiriman);
		  $datakirim->toJson();
		  $dataongkir = collect($ongkir);
		  $dataongkir->toJson();
		  return $dataongkir;
	}
}
