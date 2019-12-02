<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

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
                $active = $user->active;
            }
            if ((Hash::check($password, $passwordhash)) && ($active == 'Y')) {
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
}
