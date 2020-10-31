<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Profile;

class ProfileController extends Controller
{
    public function index()
    {
        $data = Profile::where('id', 1)->get();
        $profile = collect($data);
        $profile->toJson();
        return $profile;
    }

    public function update(Request $request)
    {
        $item = $request->id;
        settype($item, "integer");
        //1.Pencarian berdasarkan ID
        $profile = Profile::findOrFail($item);
        //2.Mengambil data dari field edit
        $input = $request->all();
        //3.Menyimpan data 
        $profile->update($input);
        return $profile;
    }
}
