<?php

namespace App\Http\Controllers;

use App\Models\Wahana;
use Illuminate\Http\Request;

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
            'gambar' => 'required|string',
            'deskripsi' => 'required|string',
        ]);

        $wahana = new Wahana([
            'nama' => $request->input('nama'),
            'gambar' => $request->input('gambar'),
            'deskripsi' => $request->input('deskripsi'),
        ]);

        $wahana->save();

        return response()->json(['message' => 'Wahana ditambahkan'], 201);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'string',
            'gambar' => 'string',
            'deskripsi' => 'string',
        ]);

        $wahana = Wahana::find($id);

        if (!$wahana) {
            return response()->json(['message' => 'Wahana tidak ditemukan'], 404);
        }

        if ($request->has('nama')) {
            $wahana->nama = $request->input('nama');
        }

        if ($request->has('gambar')) {
            $wahana->gambar = $request->input('gambar');
        }

        if ($request->has('deskripsi')) {
            $wahana->deskripsi = $request->input('deskripsi');
        }

        $wahana->save();

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
