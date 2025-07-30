<?php

namespace App\Http\Controllers;

use App\Imports\LokasiImport;
use App\Models\Lokasi;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'posisi' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);

        $exists = Lokasi::whereRaw('LOWER(posisi) = ?', [strtolower($request->posisi)])->exists();
        
        if ($exists) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Posisi sudah ada.'
            ], 409);
        }

        $posisi = Lokasi::create([
            'posisi' => $request->posisi,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $posisi
        ]);
    }
    public function index()
    {
        $lokasis = Lokasi::all();

        $lokasiRelasi = Lokasi::withCount('barangs')->get();
        $totalLokasi = Lokasi::count();
        $lokasiKosong = $lokasiRelasi->where('barangs_count', 0)->pluck('posisi')->toArray();
        $lokasiPadat = $lokasiRelasi->sortByDesc('barangs_count')->first();
        return view('ruangan.dataLokasi', compact('lokasis', 'lokasiRelasi', 'totalLokasi', 'lokasiKosong', 'lokasiPadat'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'lokasi' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);

        $lokasi = Lokasi::findOrFail($id);

        $exists = Lokasi::whereRaw('LOWER(posisi) = ? AND id != ?', [strtolower($request->lokasi), $id])->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Lokasi sudah ada.'
            ], 409);
        }

        $lokasi->update([
            'posisi' => $request->lokasi,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $lokasi
        ]);
    }

    public function show($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        return view('ruangan.showLokasi', compact('lokasi'));
    }

    public function destroy($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        $lokasi->delete();

        return redirect()->route('lokasi.index')->with('success', 'Lokasi berhasil dihapus.');
    }

    public function importPage()
    {
        return view('ruangan.importLokasi');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv',
        ], [
            'file_excel.required' => 'File harus diunggah.',
            'file_excel.mimes' => 'File harus berupa file Excel (xlsx, xls, csv).',
        ]);

        Excel::import(new LokasiImport, $request->file('file_excel'));

        return redirect()->route('lokasi.index')->with('success_excel', 'Data lokasi berhasil diimport.');
    }
}
