<?php

namespace App\Http\Controllers;

use App\Exports\RiwayatExport;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\Riwayat;
use App\Models\Barang;
use App\Models\Karyawan;
use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class RiwayatController extends Controller
{
    public function index()
    {
        $riwayats = Riwayat::all();
        $totalRiwayat = Riwayat::count();
        $riwayatTanpaKeterangan = Riwayat::where('keterangan', null)->count();

        $karyawanTerbanyak = DB::table('riwayats')
        ->select('karyawan_id', DB::raw('count(*) as total'))
        ->groupBy('karyawan_id')
        ->orderByDesc('total')
        ->first();

        $namaKaryawanTerbanyak = null;

        if ($karyawanTerbanyak) {
            $karyawan = Karyawan::find($karyawanTerbanyak->karyawan_id);
            $namaKaryawanTerbanyak = $karyawan ? $karyawan->nama . ' (' . $karyawanTerbanyak->total . ')' : 'Tidak ada';
        }

        return view('riwayats.dataRiwayat', compact('riwayats', 'totalRiwayat', 'namaKaryawanTerbanyak', 'riwayatTanpaKeterangan'));
    }
    public function create()
    {
        $jenisBarang = Jenis::all();
        $barangs = Barang::all();
        $karyawans = Karyawan::all();
        return view('riwayats.createRiwayat', compact('jenisBarang', 'barangs', 'karyawans'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'jenis_id' => 'required|exists:jenis,merek_id',
            'barang_id' => 'required|exists:barangs,id',
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ], [
            'jenis_id.required' => 'Jenis barang harus dipilih.',
            'barang_id.required' => 'Barang harus dipilih.',
            'karyawan_id.required' => 'Karyawan harus dipilih.',
            'tanggal.required' => 'Tanggal harus diisi.',
        ]);

        DB::transaction(function () use ($request) {

            $barang = Barang::lockForUpdate()->findOrFail($request->barang_id);

            Riwayat::create([
                'jenis_id' => $request->jenis_id,
                'barang_id' => $barang->id,
                'nama_barang' => $barang->nama_barang,
                'karyawan_id' => $request->karyawan_id,
                'tanggal' => $request->tanggal,
                'keterangan'  => $request->keterangan,
            ]);

            $barang->update(['status' => 1]);
        });

        return redirect()->route('riwayat.index')->with('success', 'Riwayat berhasil ditambahkan.');
    }
    public function show($id)
    {
        $riwayat = Riwayat::with(['barang', 'karyawan', 'jenis'])->findOrFail($id);
        return view('riwayats.showRiwayat', compact('riwayat'));
    }
    public function edit($id)
    {
        $riwayat = Riwayat::findOrFail($id);
        $jenisBarang = Jenis::all();
        $barangs = Barang::all();
        $karyawans = Karyawan::all();
        return view('riwayats.editRiwayat', compact('riwayat', 'jenisBarang', 'barangs', 'karyawans'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_id' => 'required|exists:jenis,merek_id',
            'barang_id' => 'required|exists:barangs,id',
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ], [
            'jenis_id.required' => 'Jenis barang harus dipilih.',
            'barang_id.required' => 'Barang harus dipilih.',
            'karyawan_id.required' => 'Karyawan harus dipilih.',
            'tanggal.required' => 'Tanggal harus diisi.',
        ]);
        DB::transaction(function () use ($request, $id) {
            $riwayat = Riwayat::findOrFail($id);
            $barangBaru = Barang::findOrFail($request->barang_id);

            if ($riwayat->barang_id != $request->barang_id) {
                Barang::where('id', $riwayat->barang_id)->update(['status' => 0]);

                $barangBaru->update(['status' => 1]);
            }

            $riwayat->update([
                'jenis_id' => $request->jenis_id,
                'barang_id' => $barangBaru->id,
                'nama_barang' => $barangBaru->nama_barang,
                'karyawan_id' => $request->karyawan_id,
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
            ]);
        });
        return redirect()->route('riwayat.index')->with('success', 'Riwayat berhasil diperbarui.');
    }
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $riwayat = Riwayat::findOrFail($id);
            $riwayat->barang()->update(['status' => 0]);
            $riwayat->delete();
        });

        return redirect()->route('riwayat.index')->with('success_delete', 'Riwayat berhasil dihapus.');
    }
    public function export($format)
    {
        $riwayats = Riwayat::with(['barang', 'jenis', 'karyawan'])->get();

        if ($format === 'excel') {
            return Excel::download(new RiwayatExport($riwayats), 'datariwayat.xlsx');
        }

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('exports.riwayat-pdf', compact('riwayats'));
            return $pdf->download('datariwayat.pdf');
        }

        if ($format === 'print') {
            return view('exports.riwayat-print', compact('riwayats'));
        }

        abort(404);
    }
    public function filter()
    {
        $kategoris = Kategori::all();
        $jenisBarang = Jenis::all();
        $lokasis = Lokasi::all();
        $karyawans = Karyawan::all();
        return view('filters.filter', compact('kategoris', 'jenisBarang', 'lokasis', 'karyawans'));
    }
}
