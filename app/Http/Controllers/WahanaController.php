<?php

namespace App\Http\Controllers;

use App\Models\Wahana;
use Illuminate\Http\Request;
use Carbon\Carbon;  

class WahanaController extends Controller
{
    public function index()
    {
        $wahana = Wahana::all();
        return response()->json($wahana, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string',
            'gambar' => 'required|mimes:jpeg,jpg,png,gif',
            'deskripsi' => 'required|string',
        ]);
                $wahana = new Wahana([
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
            $wahana->gambar = $name;
        }

        // $beranda->hero = $path;
        // Any other fields to be saved here..
        // dd($path);
        $wahana->save();
        
        return response()->json(['message' => 'Wahana ditambahkan'], 201);
    }

    public function update(Request $request, $id)
    {
        $valid = $request->validate([
            'nama' => 'string',
            'gambar' => 'nullable',
            'deskripsi' => 'nullable|string',
        ]);


        if($valid){

        $wahana = Wahana::find($id);

        if (!$wahana) {
            return response()->json(['message' => 'Wahana tidak ditemukan'], 404);
        }

        if ($request->has('nama')) {
            $wahana->nama = $request->input('nama');
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
            $wahana->gambar=$name;
            }   

        if ($request->has('deskripsi')) {
            $wahana->deskripsi = $request->input('deskripsi');
        }

        $wahana->save();
    }else{
        dd($request);
    }
        return response()->json(['message' => 'Wahana diperbarui'], 200);
    }

    public function destroy($id)
    {
        $wahana = Wahana::find($id);

        if (!$wahana) {
            return response()->json(['message' => 'Wahana tidak ditemukan'], 404);
        }

        $wahana->delete();

        return response()->json(['message' => 'Wahana dihapus'], 200);
    }
}
