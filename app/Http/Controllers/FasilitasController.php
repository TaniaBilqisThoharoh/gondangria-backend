<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::all();
        return response()->json($fasilitas, 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'gambar' => 'required|string',
            'deskripsi' => 'required|string',
        ]);

        Fasilitas::create($data);

        return response()->json(['message' => 'Fasilitas ditambahkan'], 201);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'string',
            'gambar' => 'string',
            'deskripsi' => 'string',
        ]);

        $fasilitas = Fasilitas::find($id);

        if (!$fasilitas) {
            return response()->json(['message' => 'Fasilitas tidak ditemukan'], 404);
        }

        if ($request->has('nama')) {
            $fasilitas->nama = $request->input('nama');
        }

        if ($request->has('gambar')) {
            $fasilitas->gambar = $request->input('gambar');
        }

        if ($request->has('deskripsi')) {
            $fasilitas->deskripsi = $request->input('deskripsi');
        }

        $fasilitas->save();

        return response()->json(['message' => 'Fasilitas diperbarui'], 200);
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
