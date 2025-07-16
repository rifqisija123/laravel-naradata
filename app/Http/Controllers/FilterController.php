<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function filterResult(Request $request)
    {
        $query = Barang::query()
            ->with(['kategori', 'jenis', 'lokasi', 'riwayats.karyawan']);

        // Filter berdasarkan karyawan (status = 1)
        if ($request->karyawan) {
            $query->where('status', 1);
        }

        // Filter kategori
        if ($request->kategori) {
            $query->whereIn('kategori_id', (array)$request->kategori);
        }

        // Filter jenis ID
        if ($request->jenis) {
            $query->whereIn('jenis_id', (array)$request->jenis);
        }

        // Filter lokasi
        if ($request->lokasi) {
            $query->whereIn('lokasi_id', (array)$request->lokasi);
        }

        // Filter kelengkapan
        if ($request->kelengkapan !== null) {
            $query->whereIn('kelengkapan', (array)$request->kelengkapan);
        }

        // Filter karyawan ID
        if ($request->karyawan) {
            $query->whereHas('riwayats', function ($q) use ($request) {
                $q->whereIn('karyawan_id', (array)$request->karyawan);
            });
        }

        // Filter status
        if ($request->status !== null) {
            $query->whereIn('status', (array)$request->status);
        }

        // Filter merek (melalui relasi jenis)
        if ($request->merek) {
            $query->whereHas('jenis', function ($q) use ($request) {
                $q->whereIn('merek_id', (array)$request->merek);
            });
        }

        // Filter berdasarkan nama jenis (relasi jenis)
        if ($request->jenis_nama) {
            $query->whereHas('jenis', function ($q) use ($request) {
                $q->whereIn('jenis', (array)$request->jenis_nama);
            });
        }

        // Filter berdasarkan tanggal terakhir pemakaian barang
        if ($request->tanggal) {
            $query->whereHas('riwayats', function ($q) use ($request) {
                $q->whereDate('tanggal', $request->tanggal);
            });
        }

        // Ambil data hasil dan map ke struktur respons
        $barangs = $query->get()->map(function ($barang) {
            return [
                'nama_barang' => $barang->nama_barang,
                'kategori' => $barang->kategori->kategori ?? '-',
                'jenis' => $barang->jenis->jenis ?? '-',
                'merek' => $barang->jenis->merek ?? '-',
                'lokasi' => $barang->lokasi->posisi ?? '-',
                'kelengkapan' => $barang->kelengkapan == 1 ? 'Lengkap' : 'Tidak Lengkap',
                'status' => $barang->status == 1 ? 'Dipakai' : 'Tidak Dipakai',
                'karyawan' => optional($barang->riwayats->last()?->karyawan)->nama ?? '-',
                'tanggal' => optional($barang->riwayats->last())->tanggal
                    ? \Carbon\Carbon::parse($barang->riwayats->last()->tanggal)->translatedFormat('d F Y')
                    : '-',
            ];
        });

        return response()->json($barangs);
    }
}
