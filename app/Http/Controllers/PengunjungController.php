<?php

namespace App\Http\Controllers;

use App\Models\Pengunjung;
use Illuminate\Http\Request;

class PengunjungController extends Controller
{
    public function index()
    {
        $pengunjung = Pengunjung::all();
        return response()->json($pengunjung, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string',
            'email' => 'required|email',
            'no_telepon' => 'required|string',
        ]);

        $pengunjung = new Pengunjung([
            'nama' => $request->input('nama'),
            'email' => $request->input('email'),
            'no_telepon' => $request->input('no_telepon'),
        ]);

        $pengunjung->save();

        return response()->json(['message' => 'Pengunjung ditambahkan'], 201);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'string',
            'email' => 'email|unique:pengunjung,email,'.$id,
            'no_telepon' => 'string',
        ]);

        $pengunjung = Pengunjung::find($id);

        if (!$pengunjung) {
            return response()->json(['message' => 'Pengunjung tidak ditemukan'], 404);
        }

        if ($request->has('nama')) {
            $pengunjung->nama = $request->input('nama');
        }

        if ($request->has('email')) {
            $pengunjung->email = $request->input('email');
        }

        if ($request->has('no_telepon')) {
            $pengunjung->no_telepon = $request->input('no_telepon');
        }

        $pengunjung->save();

        return response()->json(['message' => 'Pengunjung diperbarui'], 200);
    }

    public function destroy($id)
    {
        $pengunjung = Pengunjung::find($id);

        if (!$pengunjung) {
            return response()->json(['message' => 'Pengunjung tidak ditemukan'], 404);
        }

        $pengunjung->delete();

        return response()->json(['message' => 'Pengunjung dihapus'], 200);
    }
}
