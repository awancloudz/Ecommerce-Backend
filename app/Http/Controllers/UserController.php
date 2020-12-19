<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Hash;
use App\Kecamatan;
use App\Kota;
use App\Provinsi;
use App\Alamat;

class UserController extends Controller
{
    public function userlogin($email,$password){        
        $userlogin = User::where('email', '=', $email)->get();
        $userlogin->makeVisible('password')->toArray();
        
        //Verifikasi Password
        $jumlahuser = $userlogin->count();
        if($jumlahuser == 0){
            $data = [
            ['email' => null, 'password' => null],
            ];   
            $kosong = collect($data);
            $kosong->toJson();
            return $kosong;
        }
        else{
            //Cek Password HASH
            foreach($userlogin as $user){
                $passwordhash = $user->password;
            }
            if (Hash::check($password, $passwordhash)) {
                $koleksi = collect($userlogin);
                $koleksi->toJson();
                return $koleksi;
            }
            else{
                $data = [
                ['email' => null, 'password' => null],
                ];   
                $kosong = collect($data);
                $kosong->toJson();
                return $kosong; 
            }
        }
    }
    public function citylist(){
        $data = Kota::with('provinsi')->get();
        $jumlah = $data->count();
        if($jumlah > 0){
            $detailcity = collect($data);
            $detailcity->toJson();
            return $detailcity;
        }
        else{
            $data = [
                 ['id' => null],
            ];
            $detailcity = collect($data);
            $detailcity->toJson();
            return $detailcity;
        }
    }
    public function detailcity($id){
        $data = Kota::where('id', $id)->with('provinsi')->get();
        $jumlah = $data->count();
        if($jumlah > 0){
            $detailcity = collect($data);
            $detailcity->toJson();
            return $detailcity;
        }
        else{
            $data = [
                 ['id' => null],
            ];
            $detailcity = collect($data);
            $detailcity->toJson();
            return $detailcity;
        }
    }
    public function districtlist(){
        $data = Kecamatan::with('kota')->get();
        $jumlah = $data->count();
        if($jumlah > 0){
            $detaildistrict = collect($data);
            $detaildistrict->toJson();
            return $detaildistrict;
        }
        else{
            $data = [
                 ['id' => null],
            ];
            $detaildistrict = collect($data);
            $detaildistrict->toJson();
            return $detaildistrict;
        }
    }
    public function detaildistrict($id){
        $data = Kecamatan::where('id_kota', $id)->with('kota')->get();
        $jumlah = $data->count();
        if($jumlah > 0){
            $detaildistrict = collect($data);
            $detaildistrict->toJson();
            return $detaildistrict;
        }
        else{
            $data = [
                 ['id' => null],
            ];
            $detaildistrict = collect($data);
            $detaildistrict->toJson();
            return $detaildistrict;
        }
    }
    public function createuser(Request $request){
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
	    $createuser = User::create($input);
	    return $createuser;
    }
    public function updateuser(Request $request){
        $item = $request->id;
        settype($item, "integer");
        $updateuser = User::findOrFail($item);
        $input = $request->all();
        if($request->password != ''){
            $input['password'] = bcrypt($input['password']);
        }
        $updateuser->update($input);
        return $updateuser;
    }
    public function userlist($iduser){
        settype($iduser, "integer");
        $user = User::findOrFail($iduser);
        if($user->role == 'admin'){
            $data = User::orderBy('id','desc')->get();
        }
        else{
            $data = User::where('id', $iduser)->get();
        }
        $jumlah = $data->count();
        if($jumlah > 0){
            $detailuser = collect($data);
            $detailuser->toJson();
            return $detailuser;
        }
        else{
            $data = [
                 ['id' => null],
            ];
            $detailuser = collect($data);
            $detailuser->toJson();
            return $detailuser;
        }
    }
    public function cari(Request $request){
        $kata_kunci = $request->input('nama');
        //Query
        $data = User::where(function($query) use ($kata_kunci) {
            $query->where('nama', 'LIKE', '%'.$kata_kunci.'%')
            ->orWhere('email', 'LIKE', '%'.$kata_kunci.'%')
            ->orWhere('nohp', 'LIKE', '%'.$kata_kunci.'%');
        })->orderBy('id', 'desc')->get();
            
        $jumlah = $data->count();
        if($jumlah > 0){
            $user = collect($data);
            $user->toJson();
            return $user;
        }
        else{
            $data = [
                ['id' => null],
            ];
            $user = collect($data);
            $user->toJson();
            return $user;
        }
    }
    public function addresslist($iduser){
        settype($iduser, "integer");
        $data = Alamat::where('id_users', $iduser)->with('kecamatan')->with('kota')->orderBy('utama')->get();
        $jumlah = $data->count();
        if($jumlah > 0){
            $detailalamat = collect($data);
            $detailalamat->toJson();
            return $detailalamat;
        }
        else{
            $data = [
                 ['id' => null],
            ];
            $detailalamat = collect($data);
            $detailalamat->toJson();
            return $detailalamat;
        }
    }
    public function addressmain($iduser){
        settype($iduser, "integer");
        $data = Alamat::where('id_users', $iduser)->where('utama', 1)->with('kecamatan')->with('kota')->get();
        $jumlah = $data->count();
        if($jumlah > 0){
            $detailalamat = collect($data);
            $detailalamat->toJson();
            return $detailalamat;
        }
        else{
            $data = [
                 ['id' => null],
            ];
            $detailalamat = collect($data);
            $detailalamat->toJson();
            return $detailalamat;
        }
    }
    public function setaddress($address){
        settype($address, "integer");
        $alamatawal = Alamat::where('utama',1)->get();
        foreach($alamatawal as $alamat){
            $alamat->utama = 2;
            $alamat->update();
        }

        $updatealamat = Alamat::findOrFail($address);
        $updatealamat->utama = 1;
        $updatealamat->update();

        return $updatealamat;
    }
    public function createaddress(Request $request){
        $input = $request->all();
	    $createaddress = Alamat::create($input);
	    return $createaddress;
    }
    public function destroy($id){
        settype($id, "integer");
        $deleteaddress = Alamat::findOrFail($id);
        $deleteaddress->delete();
        return $deleteaddress;
    }
}
