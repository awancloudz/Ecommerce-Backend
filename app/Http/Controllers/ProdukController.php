<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Produk;
use App\FotoProduk;
use Storage;

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
        $data = Produk::where('link', $id)->with('fotoproduk')->get();
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

    public function store(Request $request){
        $input = $request->all();
        //Simpan Data produk
        $produk = Produk::create($input);
        
        if($request->hasFile('foto')){
            $input['foto'] = $this->uploadFoto($request);
        }
        else{
            $input['foto'] = "box-flat.png";
        }
        if($request->hasFile('foto2')){
            $input['foto2'] = $this->uploadFoto($request);
        }
        else{
            $input['foto2'] = "box-flat.png";
        }
        if($request->hasFile('foto3')){
            $input['foto3'] = $this->uploadFoto($request);
        }
        else{
            $input['foto3'] = "box-flat.png";
        }
        if($request->hasFile('foto4')){
            $input['foto4'] = $this->uploadFoto($request);
        }
        else{
            $input['foto4'] = "box-flat.png";
        }
        if($request->hasFile('foto5')){
            $input['foto5'] = $this->uploadFoto($request);
        }
        else{
            $input['foto5'] = "box-flat.png";
        }
        $id_awal = Produk::orderBy('id', 'desc')->first();
        $idproduk = $id_awal->id;
        settype($idproduk, "integer");
        $produkedit = Produk::findOrFail($idproduk);
        $produkedit->foto = $input['foto'];
        $produkedit->update();
        return $produk;
    }

    public function updateproduk(Request $request){
        $input = $request->all();
        $id = $request->id;
        settype($id, "integer");
        $produk = Produk::findOrFail($id);
        $upload_path = 'fotoupload';

        if($request->hasFile('foto')){
            $this->hapusFotoedit($request);
            if($request->file('foto')->isValid()){
                $foto = $request->file('foto');
                $ext = $foto->getClientOriginalExtension();
                $foto_name = "foto1" . date('YmdHis'). ".$ext";
                $request->file('foto')->move($upload_path, $foto_name);
    
                //Update Nama Foto Utama
                $idproduk = $request->id;
                settype($idproduk, "integer");
                $produk = Produk::findOrFail($idproduk);
                $produk->foto = $foto_name;
                $produk->update();
    
                //Update Nama Foto Lain
                $idfoto = $request->idfoto1;
                settype($idfoto, "integer");
                $fotosearch = FotoProduk::where('id',$idfoto)->where('id_produk',$idproduk)->get();
                $jumlah = $fotosearch->count();
                if($jumlah > 0){
                    $fotoproduk = FotoProduk::findOrFail($idfoto);
                    $fotoproduk->foto = $foto_name;
                    $fotoproduk->update();
                }
                else{
                    $fotosearch2 = FotoProduk::where('id_produk',$idproduk)->get();
                    $jumlah2 = $fotosearch2->count();
                    if($jumlah2 < 5){
                        $fotoproduk = New FotoProduk();
                        $fotoproduk->id_produk = $idproduk;
                        $fotoproduk->foto = $foto_name;
                        $fotoproduk->save();
                    }
                }
                //return $foto_name;
            }
            //$input['foto'] = $this->uploadFotoedit($request);
            $input['foto'] = $foto_name;
        }
        else{
            $input['foto'] = $produk->foto;
        }
        if($request->hasFile('foto2')){
            $this->hapusFotoedit($request);
            if($request->file('foto2')->isValid()){
                $foto2 = $request->file('foto2');
                $ext2 = $foto2->getClientOriginalExtension();
                $foto_name2 = "foto2" . date('YmdHis'). ".$ext2";
                $request->file('foto2')->move($upload_path, $foto_name2);
                
                //Update Nama Foto Lain
                $idproduk = $request->id;
                settype($idproduk, "integer");
                $idfoto = $request->idfoto2;
                settype($idfoto, "integer");
                $fotosearch = FotoProduk::where('id',$idfoto)->where('id_produk',$idproduk)->get();
                $jumlah = $fotosearch->count();
                if($jumlah > 0){
                    $fotoproduk = FotoProduk::findOrFail($idfoto);
                    $fotoproduk->foto = $foto_name2;
                    $fotoproduk->update();
                }
                else{
                    $fotosearch2 = FotoProduk::where('id_produk',$idproduk)->get();
                    $jumlah2 = $fotosearch2->count();
                    if($jumlah2 < 5){
                        $fotoproduk = New FotoProduk();
                        $fotoproduk->id_produk = $idproduk;
                        $fotoproduk->foto = $foto_name2;
                        $fotoproduk->save();
                    }
                }
                //return $foto_name2;
            }
            //$input['foto2'] = $this->uploadFotoedit($request);
            $input['foto2'] = $foto_name2;
        }
        if($request->hasFile('foto3')){
            $this->hapusFotoedit($request);
            if($request->file('foto3')->isValid()){
                $foto3 = $request->file('foto3');
                $ext3 = $foto3->getClientOriginalExtension();
                $foto_name3 = "foto3" . date('YmdHis'). ".$ext3";
                $request->file('foto3')->move($upload_path, $foto_name3);
                
                //Update Nama Foto Lain
                $idproduk = $request->id;
                settype($idproduk, "integer");
                $idfoto = $request->idfoto3;
                settype($idfoto, "integer");
                $fotosearch = FotoProduk::where('id',$idfoto)->where('id_produk',$idproduk)->get();
                $jumlah = $fotosearch->count();
                if($jumlah > 0){
                    $fotoproduk = FotoProduk::findOrFail($idfoto);
                    $fotoproduk->foto = $foto_name3;
                    $fotoproduk->update();
                }
                else{
                    $fotosearch2 = FotoProduk::where('id_produk',$idproduk)->get();
                    $jumlah2 = $fotosearch2->count();
                    if($jumlah2 < 5){
                        $fotoproduk = New FotoProduk();
                        $fotoproduk->id_produk = $idproduk;
                        $fotoproduk->foto = $foto_name3;
                        $fotoproduk->save();
                    }
                }
                //return $foto_name3;
            }
            //$input['foto3'] = $this->uploadFotoedit($request);
            $input['foto3'] =$foto_name3;
        }
        if($request->hasFile('foto4')){
            $this->hapusFotoedit($request);
            if($request->file('foto4')->isValid()){
                $foto4 = $request->file('foto4');
                $ext4 = $foto4->getClientOriginalExtension();
                $foto_name4 = "foto4" . date('YmdHis'). ".$ext4";
                $request->file('foto4')->move($upload_path, $foto_name4);
                
                //Update Nama Foto Lain
                $idproduk = $request->id;
                settype($idproduk, "integer");
                $idfoto = $request->idfoto4;
                settype($idfoto, "integer");
                $fotosearch = FotoProduk::where('id',$idfoto)->where('id_produk',$idproduk)->get();
                $jumlah = $fotosearch->count();
                if($jumlah > 0){
                    $fotoproduk = FotoProduk::findOrFail($idfoto);
                    $fotoproduk->foto = $foto_name4;
                    $fotoproduk->update();
                }
                else{
                    $fotosearch2 = FotoProduk::where('id_produk',$idproduk)->get();
                    $jumlah2 = $fotosearch2->count();
                    if($jumlah2 < 5){
                        $fotoproduk = New FotoProduk();
                        $fotoproduk->id_produk = $idproduk;
                        $fotoproduk->foto = $foto_name4;
                        $fotoproduk->save();
                    }
                }
                //return $foto_name4;
            }
            //$input['foto4'] = $this->uploadFotoedit($request);
            $input['foto4'] = $foto_name4;
        }
        if($request->hasFile('foto5')){
            $this->hapusFotoedit($request);
            if($request->file('foto5')->isValid()){
                $foto5 = $request->file('foto5');
                $ext5 = $foto5->getClientOriginalExtension();
                $foto_name5 = "foto5" . date('YmdHis'). ".$ext5";
                $request->file('foto5')->move($upload_path, $foto_name5);
    
               //Update Nama Foto Lain
               $idproduk = $request->id;
               settype($idproduk, "integer");
               $idfoto = $request->idfoto5;
               settype($idfoto, "integer");
               $fotosearch = FotoProduk::where('id',$idfoto)->where('id_produk',$idproduk)->get();
               $jumlah = $fotosearch->count();
               if($jumlah > 0){
                   $fotoproduk = FotoProduk::findOrFail($idfoto);
                   $fotoproduk->foto = $foto_name5;
                   $fotoproduk->update();
               }
               else{
                    $fotosearch2 = FotoProduk::where('id_produk',$idproduk)->get();
                    $jumlah2 = $fotosearch2->count();
                    if($jumlah2 < 5){
                        $fotoproduk = New FotoProduk();
                        $fotoproduk->id_produk = $idproduk;
                        $fotoproduk->foto = $foto_name5;
                        $fotoproduk->save();
                    }
               }
                //return $foto_name5;
            }
            //$input['foto5'] = $this->uploadFotoedit($request);
            $input['foto5'] = $foto_name5;
        }
        $produk->update($input);
        return $produk;
    }
    
    //Upload foto ke direktori lokal
    public function uploadFoto(Request $request){
        $upload_path = 'fotoupload';

        $id_awal = Produk::orderBy('id', 'desc')->first();
        $idproduk = $id_awal->id;
        settype($idproduk, "integer");

        if($request->file('foto')->isValid()){
            $foto = $request->file('foto');
            $ext = $foto->getClientOriginalExtension();
            $foto_name = "foto1" . date('YmdHis'). ".$ext";
            $request->file('foto')->move($upload_path, $foto_name);
            $fotoproduk = New FotoProduk();
            $fotoproduk->id_produk = $idproduk;
            $fotoproduk->foto = $foto_name;
            $fotoproduk->save();
            return $foto_name;
        }
        if($request->file('foto2')->isValid()){
            $foto2 = $request->file('foto2');
            $ext2 = $foto2->getClientOriginalExtension();
            $foto_name2 = "foto2" . date('YmdHis'). ".$ext2";
            $request->file('foto2')->move($upload_path, $foto_name2);
            $fotoproduk = New FotoProduk();
            $fotoproduk->id_produk = $idproduk;
            $fotoproduk->foto = $foto_name2;
            $fotoproduk->save();
            return $foto_name2;
        }
        if($request->file('foto3')->isValid()){
            $foto3 = $request->file('foto3');
            $ext3 = $foto3->getClientOriginalExtension();
            $foto_name3 = "foto3" . date('YmdHis'). ".$ext3";
            $request->file('foto3')->move($upload_path, $foto_name3);
            $fotoproduk = New FotoProduk();
            $fotoproduk->id_produk = $idproduk;
            $fotoproduk->foto = $foto_name3;
            $fotoproduk->save();
            return $foto_name3;
        }
        if($request->file('foto4')->isValid()){
            $foto4 = $request->file('foto4');
            $ext4 = $foto4->getClientOriginalExtension();
            $foto_name4 = "foto4" . date('YmdHis'). ".$ext4";
            $request->file('foto4')->move($upload_path, $foto_name4);
            $fotoproduk = New FotoProduk();
            $fotoproduk->id_produk = $idproduk;
            $fotoproduk->foto = $foto_name4;
            $fotoproduk->save();
            return $foto_name4;
        }
        if($request->file('foto5')->isValid()){
            $foto5 = $request->file('foto5');
            $ext5 = $foto5->getClientOriginalExtension();
            $foto_name5 = "foto5" . date('YmdHis'). ".$ext5";
            $request->file('foto5')->move($upload_path, $foto_name5);
            $fotoproduk = New FotoProduk();
            $fotoproduk->id_produk = $idproduk;
            $fotoproduk->foto = $foto_name5;
            $fotoproduk->save();
            return $foto_name5;
        }
        return false;
    }

    /*public function uploadFotoedit(Request $request){
        $upload_path = 'fotoupload';
        return false;
    }*/

    //Hapus foto di direktori lokal
    public function hapusFoto(Produk $produk){
        $exist = Storage::disk('foto')->exists($produk->foto);
        if(isset($produk->foto) && $exist){
           $delete = Storage::disk('foto')->delete($produk->foto);
           if($delete){
            return true;
           }
           return false;
        }
    }

    public function hapusFotoedit($request){
        $idproduk = $request->id;
        settype($idproduk, "integer");
        $idfoto = $request->idfoto3;
        settype($idfoto, "integer");
        $fotosearch = FotoProduk::where('id',$idfoto)->where('id_produk',$idproduk)->get();
        $jumlah = $fotosearch->count();
        if($jumlah > 0){
            $fotoproduk = FotoProduk::findOrFail($idfoto);
            $exist = Storage::disk('foto')->exists($fotoproduk->foto);
            if(isset($fotoproduk->foto) && $exist){
               $delete = Storage::disk('foto')->delete($fotoproduk->foto);
               if($delete){
                return true;
               }
               return false;
            }
        }
        else{
            return false;
        }
    }

    public function destroy($id){
        settype($id, "integer");
        $produk = Produk::findOrFail($id);
        $produk->delete();
        return $produk;
    }

    public function cari(Request $request){
        $kata_kunci = $request->input('kodeproduk');
        //Query
        $data = Produk::where(function($query) use ($kata_kunci) {
            $query->where('kodeproduk', 'LIKE', '%'.$kata_kunci.'%')
            ->orWhere('namaproduk', 'LIKE', '%'.$kata_kunci.'%')
            ->orWhere('seriproduk', 'LIKE', '%'.$kata_kunci.'%');
        })->with('merk')->with('kategoriproduk')->orderBy('id_merk', 'asc')->get();
            
        $jumlah = $data->count();
        if($jumlah > 0){
            $produk = collect($data);
            $produk->toJson();
            return $produk;
        }
        else{
            $data = [
                ['id' => null],
            ];
            $produk = collect($data);
            $produk->toJson();
            return $produk;
        }
    }
    //Kategori Produk
    public function kategori($cat){   
        $mencari = 1;
        $produk_list = Produk::where('id_kategoriproduk',$cat)->orderBy('kodeproduk', 'asc')->paginate(10);
        $jumlah_produk = $produk_list->count();
        $kategorinya = KategoriProduk::all();
        return view('produk.index', compact('produk_list','jumlah_produk','kategorinya','cat','mencari'));
    }
}
