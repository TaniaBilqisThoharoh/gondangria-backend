<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HargaTiket;

class HargaTiketController extends Controller
{

    public function index()
    {
        $harga_tiket = HargaTiket::all();
        // dd($harga_tiket);
        $data = [
            'data' => $harga_tiket,
            'message' => 'Selamat sukses'
        ];
        return response()->json($data, 200);
    }
    
    public function store(Request $request){
    $request->only('harga_tiket');

    $harga_tiket = new HargaTiket([
        'harga_tiket' => $request->input('harga_tiket')
    ]);
    $harga_tiket->save();

    return response()->json(['message'=>'successfully create new harga'], 200);
    }

    public function update(Request $request, $id){
    $request->only('harga_tiket');

    $data = Hargatiket::find($id);
    
    if($request->has('harga_tiket')){
        $data->harga_tiket = $request->input('harga_tiket');
    }

    $data->save();

    return response()->json(['message'=> 'Successfully update harga'], 201);
    }
}
