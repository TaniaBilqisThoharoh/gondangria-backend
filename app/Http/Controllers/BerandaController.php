<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Beranda;
use App\Models\Wahana;
use App\Models\Fasilitas;

class BerandaController extends Controller
{
    public function index()
    {
        $beranda = Beranda::first();
        $wahana = Wahana::all();
        $fasilitas = Fasilitas::all();

        return response()->json([
            'beranda' => $beranda,
            'wahana' => $wahana,
            'fasilitas' => $fasilitas,
        ], 200);
    }

    public function store(Request $request)
    {
        // Validasi input sesuai kebutuhan Anda
        $data = $request->validate([
            'hero' => 'required|string',
            'wahana_id' => 'nullable|exists:wahanas,id', // Memeriksa apakah ID wahana valid
            'fasilitas_id' => 'nullable|exists:fasilitas,id', // Memeriksa apakah ID fasilitas valid
        ]);

        $beranda = new Beranda([
            'hero' => $request->input('hero'),
            'wahana_id' => $request->input('wahana_id'),
            'fasilitas_id' => $request->input('fasilitas_id'),
        ]);

        $beranda->save();

        return response()->json(['message' => 'Beranda created',
        $data], 201);
    
    }

    public function update(Request $request, $id)
    {
        // Validasi input sesuai kebutuhan Anda
        $request->validate([
            'hero' => 'nullable|string',
            'wahana_id' => 'nullable|exists:wahanas,id', // Memeriksa apakah ID wahana valid
            'fasilitas_id' => 'nullable|exists:fasilitas,id', // Memeriksa apakah ID fasilitas valid
        ]);

        $beranda = Beranda::find($id);

        if (!$beranda) {
            return response()->json(['message' => 'Beranda not found'], 404);
        }

        $beranda->hero = $request->input('hero');
        $beranda->wahana_id = $request->input('wahana_id');
        $beranda->fasilitas_id = $request->input('fasilitas_id');

        $beranda->save();

        return response()->json(['message' => 'Beranda updated'], 200);
    }

    public function destroy($id)
    {
        $beranda = Beranda::find($id);

        if (!$beranda) {
            return response()->json(['message' => 'Beranda not found'], 404);
        }

        $beranda->delete();

        return response()->json(['message' => 'Beranda deleted'], 200);
    }
}
