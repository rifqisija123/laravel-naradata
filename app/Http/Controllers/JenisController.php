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
            'merek' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);

        $exists = Jenis::whereRaw('LOWER(jenis) = ? AND LOWER(merek) = ?', [
            strtolower($request->jenis),
            strtolower($request->merek)
        ])->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kombinasi jenis dan merek sudah ada.'
            ], 409);
        }

        $jenis = Jenis::create([
            'jenis' => $request->jenis,
            'merek' => $request->merek,
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
        $totalJenis = Jenis::distinct('id')->count('id');
        $totalMerek = Jenis::count('merek_id');
        $jenisTanpaKeterangan = Jenis::where('keterangan', null)->count();
        return view('layouts.dataJenis', compact('jenisBarang', 'totalJenis', 'totalMerek', 'jenisTanpaKeterangan'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis' => 'required|string',
            'merek' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);

        $jenis = Jenis::findOrFail($id);

        $isSameJenis = strtolower($request->jenis) === strtolower($jenis->jenis);
        $isSameMerek = strtolower($request->merek) === strtolower($jenis->merek);

        if (!($isSameJenis && $isSameMerek)) {
            $exists = Jenis::whereRaw('LOWER(jenis) = ? AND LOWER(merek) = ? AND id != ?', [
                strtolower($request->jenis),
                strtolower($request->merek),
                $id
            ])->exists();

            if ($exists) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Kombinasi jenis dan merek sudah ada.'
                ], 409);
            }
        }

        $jenis->update([
            'jenis' => $request->jenis,
            'merek' => $request->merek,
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
