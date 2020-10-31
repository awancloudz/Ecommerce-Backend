<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\TransaksiPenjualan;
use App\DetailPenjualan;
use App\Keranjang;
use App\Produk;
use App\Ongkir;
use App\Konfirmasi;
use App\User;

class TransaksiPenjualanController extends Controller
{
    public function index($iduser){
        //USER
        settype($iduser, "integer");
        $user = User::findOrFail($iduser);
        //Seleksi transaksi 
        if($user->role == 'admin'){
          $daftartransaksi = TransaksiPenjualan::with('detailpenjualan')->orderBy('tanggal','desc')->get();
        }
        else{
          $daftartransaksi = TransaksiPenjualan::where('id_users',$iduser)->with('detailpenjualan')->orderBy('tanggal','desc')->get();
        }
        $jumlahtransaksi = $daftartransaksi->count();
        $koleksi = collect($daftartransaksi);
        $koleksi->toJson();
        return $koleksi;
    }
    public function view($idtrans){
      //USER
      settype($idtrans, "integer");
      //Seleksi transaksi 
      $transaksi = TransaksiPenjualan::where('id',$idtrans)->with('alamat')->get();
      $jumlahtransaksi = $transaksi->count();
      $koleksi = collect($transaksi);
      $koleksi->toJson();
      return $koleksi;
  }
    public function detail($idtrans){
        //USER
        settype($idtrans, "integer");
        //Seleksi transaksi 
        $daftartransaksi = DetailPenjualan::where('id_transaksipenjualan',$idtrans)->with('produk')->get();
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
        //Angka Acak 3 digit
				$digits = 3;
        $random = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);

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
    public function saveconfirmation(Request $request){
      $input = $request->all();
      $idtrans = $request->id;
      settype($iduser, "integer");
      
      $transaksi = TransaksiPenjualan::findOrFail($idtrans);
      $transaksi->status = "proses";
      $transaksi->update();
      
      //$createconfirmation = Konfirmasi::create($input);
	    return $transaksi;
    }
    public function scrape($asal, $tujuan, $berat, $kurir){
    for($a=1; $a < 502; $a++){
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
		  CURLOPT_POSTFIELDS => "origin=".$asal."&destination=".$a."&weight=".$berat."&courier=".$kurir,
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
				  /*$ongkir[] = array(
            'cityname' => $data['rajaongkir']['destination_details']['city_name'],
					  'service' => $data['rajaongkir']['results'][0]['costs'][$i]['service'],
					  'costs' => $data['rajaongkir']['results'][0]['costs'][$i]['cost'][0]['value'],
					  'estimate' => $data['rajaongkir']['results'][0]['costs'][$i]['cost'][0]['etd'],
          );*/
          $ongkir = New Ongkir;
          $ongkir->destination = $a;
          $ongkir->cityname = $data['rajaongkir']['destination_details']['city_name'];
          $ongkir->service = $data['rajaongkir']['results'][0]['costs'][$i]['service'];
          $ongkir->costs = $data['rajaongkir']['results'][0]['costs'][$i]['cost'][0]['value'];
          $ongkir->estimate = $data['rajaongkir']['results'][0]['costs'][$i]['cost'][0]['etd'];
          $ongkir->save();
			  }
		  }
		  $datakirim = collect($pengiriman);
		  $datakirim->toJson();
		  $dataongkir = collect($ongkir);
		  $dataongkir->toJson();
      //return $dataongkir;
      echo $dataongkir;
    }
    }
    
    public function ongkir($asal, $tujuan, $berat){
      $ongkirnya = Ongkir::where('destination',$tujuan)->get();

      // Weight * Costs
      $hitung=$berat / 1000;
      if($hitung==0){
        $hasil=1;
      }
      else
      {
        if(strpos($hitung,".")){
          $split_angka=explode(".",$hitung);
          if($split_angka[1] < 999){
            $angka2=1;
            $hitung=$split_angka[0] + $angka2;
            $hasil=$hitung;
          }
        }
        else
        {
          $hasil=$hitung;	
        }
      }
      
      // Tampilkan hasil hitung
      foreach($ongkirnya as $ongk){
        $totalbiaya = 0;
        $totalbiaya = $ongk->costs * $hasil;
        $ongkir[] = array(
          'service' => $ongk->service,
          'costs' => $totalbiaya,
          'estimate' => $ongk->estimate,
        );
      }
      $dataongkir = collect($ongkir);
		  $dataongkir->toJson();
      return $dataongkir;
    }
}
