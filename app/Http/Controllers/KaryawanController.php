<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'karyawan' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);

        $exists = Karyawan::whereRaw('LOWER(karyawan) = ?', [strtolower($request->karyawan)])->exists();
        if ($exists) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Karyawan sudah ada.'
            ], 409);
        }

        $karyawan = Karyawan::create([
            'karyawan' => $request->karyawan,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $karyawan
        ]);
    }
}
