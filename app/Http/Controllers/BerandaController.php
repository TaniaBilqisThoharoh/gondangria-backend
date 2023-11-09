<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Beranda;
use App\Models\Wahana;
use App\Models\Fasilitas;

class BerandaController extends Controller
{
    public function index()
    {
        $beranda = Beranda::first();

        return response()->json(
            $beranda, 200);
    }

    public function store(Request $request)
    {
    $path = $request->file('hero')->move(public_path('images'), $request->file('hero')->getClientOriginalName());
    
    $beranda = new Beranda([
        'hero' => $request->hero
    ]);
    $beranda->hero = $path;
    // Any other fields to be saved here..
    $beranda->save();
        
        // Validasi input sesuai kebutuhan Anda
        // $data = $request->validate([
        //     'hero' => 'required|string'// Memeriksa apakah ID fasilitas valid
        // ]);

        // $beranda = new Beranda([
        //     'hero' => $request->input('hero'),
            
        // ]);

        // $beranda->save();

        return response()->json(['message' => 'Beranda created'], 201);
    
    }

    public function update(Request $request)
    {
        // Validasi input sesuai kebutuhan Anda
        if(response(404)){
            if($request->hasFile('hero')){
                dd($request->hero);
            }
        }
        $request->validate(
            [
                'hero' => 'string'
            ]
        );
        $path = $request->file('hero');
        if(!$path){
            dd($path);
        }
        $dest = public_path('images');
        $path->move($dest . $path->getClientOriginalName());
         // $path->move(public_path('images'), $request->file('hero')->getClientOriginalName());
        
        
        if(!$path){
        return response()->json(['message'=>'Data not found'], 404);       
        }

        if ($request->hasFile('hero')) {
            $beranda->nama = $path;
        }

        // $beranda->hero = $path;
    // Any other fields to be saved here..
        $beranda->save();

        return response()->json(['message' => 'Beranda updated', $path], 200);
        // }else{
        //     dd($request);
        // }
        
    
    }

    public function destroy($id)
    {
        $beranda = Beranda::find($id);

        if (!$beranda) {
            return response()->json(['message' => 'Beranda not found',], 404);
        }

        $beranda->delete();

        return response()->json(['message' => 'Beranda deleted'], 200);
    }
}
