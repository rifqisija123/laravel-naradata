<?php

namespace App\Http\Controllers;

use App\Imports\KategoriImport;
use App\Models\Barang;
use App\Models\Kategori;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        $totalKategori = Kategori::count();
        $kategoriTanpaKeterangan = Kategori::where('keterangan', null)->count();
        $kategoriBarang = Barang::distinct('kategori_id')->count('kategori_id');
        return view('kategori.dataKategori', compact('kategoris', 'totalKategori', 'kategoriTanpaKeterangan', 'kategoriBarang'));
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
        return view('kategori.showKategori', compact('kategori'));
    }

    public function importPage()
    {
        return view('kategori.importKategori');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv',
        ], [
            'file_excel.required' => 'File harus diunggah.',
            'file_excel.mimes' => 'File harus berupa file Excel (xlsx, xls, csv).',
        ]);

        Excel::import(new KategoriImport, $request->file('file_excel'));

        return redirect()->route('kategori.index')->with('success_excel', 'Data kategori berhasil diimport.');
    }
}
