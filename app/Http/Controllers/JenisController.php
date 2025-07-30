<?php

namespace App\Http\Controllers;

use App\Imports\JenisImport;
use App\Models\Jenis;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class JenisController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|string',
            'merek' => 'required|string',
            'keterangan' => 'nullable|string',
            'manual' => 'nullable|boolean'
        ]);

        $jenisInput = strtolower($request->jenis);
        $merekInput = strtolower($request->merek);
        $isManual = $request->manual;

        if ($isManual) {
            $existingJenis = Jenis::all();
            foreach ($existingJenis as $existing) {
                similar_text($jenisInput, strtolower($existing->jenis), $percent);
                if ($percent > 85) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Jenis sudah ada!'
                    ], 409);
                }
            }
        }

        $existingCombinations = Jenis::all();

        foreach ($existingCombinations as $item) {
            $jenisDB = strtolower($item->jenis);
            $merekDB = strtolower($item->merek);

            if ($jenisDB === $jenisInput) {
                similar_text($merekInput, $merekDB, $percent);
                if ($percent > 85) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Kombinasi jenis dan merek sudah ada!'
                    ], 409);
                }
            }
        }

        $jenis = Jenis::create([
            'jenis' => ucfirst($jenisInput),
            'merek' => ucfirst($merekInput),
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
        return view('jenis.dataJenis', compact('jenisBarang', 'totalJenis', 'totalMerek', 'jenisTanpaKeterangan'));
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
        return view('jenis.showJenis', compact('jenis'));
    }
    public function destroy($id)
    {
        $jenis = Jenis::findOrFail($id);
        $jenis->delete();

        return redirect()->route('jenis.index')->with('success', 'Jenis berhasil dihapus.');
    }

    public function importPage()
    {
        return view('jenis.importJenis');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv',
        ], [
            'file_excel.required' => 'File harus diunggah.',
            'file_excel.mimes' => 'File harus berupa file Excel (xlsx, xls, csv).',
        ]);

        Excel::import(new JenisImport, $request->file('file_excel'));

        return redirect()->route('jenis.index')->with('success_excel', 'Data Jenis & Merek berhasil diimport.');
    }
}
