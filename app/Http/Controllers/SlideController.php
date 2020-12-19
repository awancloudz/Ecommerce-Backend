<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Slide;
use Storage;

class SlideController extends Controller
{
    public function index(){
        $data = Slide::all();
        $jumlah = $data->count();
        if($jumlah > 0){
            $slide = collect($data);
            $slide->toJson();
            return $slide;
        }
        else{
            $data = [
                ['id' => null],
            ];
            $slide = collect($data);
            $slide->toJson();
            return $slide;
        }
    }

    public function show($id){
        $data = Slide::where('id', $id)->get();
        $jumlah = $data->count();
        if($jumlah > 0){
            $slide = collect($data);
            $slide->toJson();
            return $slide;
        }
        else{
            $data = [
                ['id' => null],
            ];
            $slide = collect($data);
            $slide->toJson();
            return $slide;
        }
    }

    public function store(Request $request){
        $input = $request->all();
        
        if($request->hasFile('foto')){
            $input['foto'] = $this->uploadFoto($request);
        }
        else{
            $input['foto'] = "slider-default";
        }
        //Simpan Data produk
        $slide = Slide::create($input);
        return $slide;
    }
    
    public function updateslide(Request $request){
        $input = $request->all();
        $id = $request->id;
        settype($id, "integer");
        $slide = Slide::findOrFail($id);
        $upload_path = 'fotoupload';

        if($request->hasFile('foto')){
            $this->hapusFotoSlide($slide);
            if($request->file('foto')->isValid()){
                $foto = $request->file('foto');
                $ext = $foto->getClientOriginalExtension();
                $foto_name = "slide" . date('YmdHis'). ".$ext";
                $request->file('foto')->move($upload_path, $foto_name);
                //return $foto_name;
            }
            //$input['foto'] = $this->uploadFotoedit($request);
            $input['foto'] = $foto_name;
        }
        else{
            $input['foto'] = $slide->foto;
        }

        $slide->update($input);
        return $slide;
    }

    public function uploadFoto(Request $request){
        $upload_path = 'fotoupload';
        if($request->file('foto')->isValid()){
            $foto = $request->file('foto');
            $ext = $foto->getClientOriginalExtension();
            $foto_name = "slide" . date('YmdHis'). ".$ext";
            $request->file('foto')->move($upload_path, $foto_name);
            return $foto_name;
        }
        return false;
    }

    public function hapusFotoSlide(Slide $slide){
        $exist = Storage::disk('foto')->exists($slide->foto);
        if(isset($slide->foto) && $exist){
           $delete = Storage::disk('foto')->delete($slide->foto);
           if($delete){
            return true;
           }
           return false;
        }
    }

    public function destroy($id){
        settype($id, "integer");
        $slide = Slide::findOrFail($id);
        $slide->delete();
        return $slide;
    }
}
