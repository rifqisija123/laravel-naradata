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

        $jenisInput = strtolower(trim($request->jenis));
        $merekInput = strtolower(trim($request->merek));
        $isManual = $request->manual;

        $existingJenisList = Jenis::select('jenis')->distinct()->get();
        $matchedJenis = null;
        $highestPercent = 0;

        foreach ($existingJenisList as $existing) {
            similar_text($jenisInput, strtolower($existing->jenis), $percent);
            if ($percent > $highestPercent && $percent >= 85) {
                $highestPercent = $percent;
                $matchedJenis = $existing->jenis;
            }
        }

        $finalJenis = $matchedJenis ?? ucfirst($jenisInput);

        // Cek kombinasi jenis + merek apakah sudah ada
        $exists = Jenis::whereRaw('LOWER(jenis) = ?', [strtolower($finalJenis)])
            ->whereRaw('LOWER(merek) = ?', [$merekInput])
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kombinasi jenis dan merek sudah ada!'
            ], 409);
        }

        $jenis = Jenis::create([
            'jenis' => ucfirst($finalJenis),
            'merek' => ucfirst($merekInput),
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $jenis
        ]);
    }
    public function autocomplete(Request $request)
    {
        $keyword = strtolower($request->get('keyword'));
        $jenis = Jenis::select('jenis')
            ->distinct()
            ->whereRaw('LOWER(jenis) LIKE ?', ["%{$keyword}%"])
            ->get();

        return response()->json($jenis);
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
