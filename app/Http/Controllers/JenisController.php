<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);

        $exists = Jenis::whereRaw('LOWER(jenis) = ?', [strtolower($request->jenis)])->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Jenis sudah ada.'
            ], 409);
        }

        $jenis = Jenis::create([
            'jenis' => $request->jenis,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $jenis
        ]);
    }
    public function index()
    {
        $jenisBarang = Jenis::all();
        return view('layouts.dataJenis', compact('jenisBarang'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);

        $jenis = Jenis::findOrFail($id);

        $exists = Jenis::whereRaw('LOWER(jenis) = ? AND id != ?', [strtolower($request->jenis), $id])->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Jenis sudah ada.'
            ], 409);
        }

        $jenis->update([
            'jenis' => $request->jenis,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $jenis
        ]);
    }
    public function show($id)
    {
        $jenis = Jenis::findOrFail($id);
        return view('layouts.showJenis', compact('jenis'));
    }
    public function destroy($id)
    {
        $jenis = Jenis::findOrFail($id);
        $jenis->delete();

        return redirect()->route('jenis.index')->with('success', 'Jenis berhasil dihapus.');
    }
}
