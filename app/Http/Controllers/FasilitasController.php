<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::all();
        return response()->json($fasilitas, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string',
            'gambar' => 'required|mimes:jpeg,jpg,png,gif',
            'deskripsi' => 'required|string',
        ]);
            $fasilitas= new Fasilitas([
            'nama' => $request->input('nama'),
            'gambar' => $request->gambar,
            'deskripsi' => $request->input('deskripsi'),
        ]);
        
        $name =  Carbon::now()->timestamp . $request->file('gambar')->getClientOriginalName();

        $path = $request->file('gambar');
        if(!$path){
            return response()->json(['message'=>'Data not found'], 404);       
        }
        $dest = public_path('images');
        // $path->move($dest . $path->getClientOriginalName());
         $path->move(public_path('images'), $name);
        
        if ($request->hasFile('gambar')) {
            $fasilitas->gambar = $name;
        }

        // $beranda->hero = $path;
        // Any other fields to be saved here..
        // dd($path);
        $fasilitas->save();
        return response()->json(['message'=> 'New fasilitas succesfully created'], 201);
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        $valid = $request->validate([
            'nama' => 'string',
            'gambar' => 'nullable',
            'deskripsi' => 'nullable|string',
        ]);


        if($valid){
        
        $fasilitas = Fasilitas::find($id);
        
        if($request->has('nama')){
            $fasilitas->nama = $request->input('nama');
         }
        
        if($request->hasFile('gambar')){
        $name =  Carbon::now()->timestamp . $request->file('gambar')->getClientOriginalName();
            
        $path = $request->file('gambar');
        if(!$path){
            return response()->json(['message'=>'Data not found'], 404);       
        }
        
        $dest = public_path('images');
        // $path->move($dest . $path->getClientOriginalName());
        $path->move(public_path('images'), $name);
        $fasilitas->gambar=$name;
        }   
        
        if($request->has('deskripsi')){
        $fasilitas->deskripsi = $request->input('deskripsi');
        }
       
        // $beranda->hero = $path;
        // Any other fields to be saved here..
        // dd($path);
         
        $fasilitas->save();
    }else{
        dd($request);
    }
        return response()->json(['message' => 'Fasilitas berhasil diedit'], 200);
    
    }

    public function destroy($id)
    {
        $fasilitas = Fasilitas::find($id);

        if (!$fasilitas) {
            return response()->json(['message' => 'Fasilitas tidak ditemukan'], 404);
        }

        $fasilitas->delete();

        return response()->json(['message' => 'Fasilitas dihapus'], 200);
    }
}
