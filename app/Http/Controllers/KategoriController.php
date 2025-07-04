<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        return view('layouts.dataKategori', compact('kategoris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);

        $kategori = Kategori::findOrFail($id);

        $exists = Kategori::whereRaw('LOWER(kategori) = ? AND id != ?', [strtolower($request->kategori), $id])->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Kategori sudah ada.'
            ], 409);
        }

        $kategori->update([
            'kategori' => $request->kategori,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $kategori
        ]);
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);

        $exists = Kategori::whereRaw('LOWER(kategori) = ?', [strtolower($request->kategori)])->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Kategori sudah ada.'
            ], 409);
        }

        $kategori = Kategori::create([
            'kategori' => $request->kategori,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $kategori
        ]);
    }

    public function show($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('layouts.showKategori', compact('kategori'));
    }
}
