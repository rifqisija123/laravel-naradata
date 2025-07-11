<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function filterResult(Request $request)
    {
        $query = Barang::query()
            ->with(['kategori', 'jenis', 'lokasi']);

        if ($request->karyawan) {
            $query->where('status', 1);
        }

        if ($request->kategori) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->jenis) {
            $query->where('jenis_id', $request->jenis);
        }

        if ($request->lokasi) {
            $query->where('lokasi_id', $request->lokasi);
        }

        if ($request->kelengkapan !== null) {
            $query->where('kelengkapan', $request->kelengkapan);
        }

        if ($request->karyawan) {
            $query->whereHas('riwayats', function ($q) use ($request) {
                $q->where('karyawan_id', $request->karyawan);
            });
        }

        $barangs = $query->get();

        return response()->json($barangs);
    }
}
