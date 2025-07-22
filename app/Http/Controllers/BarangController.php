<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Jenis;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use App\Imports\BarangImport;
use Maatwebsite\Excel\Facades\Excel;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        $kategoriRelasi = Kategori::withCount('barangs')->get();
        $jenisRelasi = Jenis::withCount('barangs')->get();
        $lokasiRelasi = Lokasi::withCount('barangs')->get();

        $totalBarang = Barang::count();
        $kategoriTerbanyak = $kategoriRelasi->sortByDesc('barangs_count')->first();
        $jenisTerbanyak = $jenisRelasi->sortByDesc('barangs_count')->first();
        $lokasiTerbanyak = $lokasiRelasi->sortByDesc('barangs_count')->first();
        return view('barangs.dataBarang', compact('barangs', 'totalBarang', 'kategoriTerbanyak', 'jenisTerbanyak', 'lokasiTerbanyak'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        $jenisBarang = Jenis::all();
        $lokasis = Lokasi::all();
        return view('barangs.createBarang', compact('kategoris', 'jenisBarang', 'lokasis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string|unique:barangs,id',
            'namaBarang' => 'required|string|max:255',
            'kategori_id' => 'required|string|exists:kategoris,id',
            'jenis_id' => 'required|string|exists:jenis,merek_id',
            'lokasi_id' => 'required|string|exists:lokasis,id',
            'kelengkapan' => 'required|in:0,1',
            'keterangan' => 'nullable|string',
        ], [
            'id.required' => 'ID barang harus diisi.',
            'id.unique' => 'ID barang sudah ada.',
            'namaBarang.required' => 'Nama barang harus diisi.',
            'kategori_id.required' => 'Kategori barang harus dipilih.',
            'jenis_id.required' => 'Jenis barang harus dipilih.',
            'lokasi_id.required' => 'Lokasi barang harus dipilih.',
            'kelengkapan.required' => 'Kelengkapan barang harus dipilih.',
        ]);

        Barang::create([
            'id' => $request->id,
            'nama_barang' => $request->namaBarang,
            'kategori_id' => $request->kategori_id,
            'jenis_id' => $request->jenis_id,
            'lokasi_id' => $request->lokasi_id,
            'kelengkapan' => $request->kelengkapan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil ditambahkan.');
    }

    public function show($id)
    {
        $barang = Barang::with(['kategori', 'jenis', 'lokasi'])->findOrFail($id);
        return view('barangs.showBarang', compact('barang'));
    }

    public function importPage()
    {
        return view('importExcel');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv',
        ], [
            'file_excel.required' => 'File harus diunggah.',
            'file_excel.mimes' => 'File harus berupa file Excel (xlsx, xls, csv).',
        ]);

        Excel::import(new BarangImport, $request->file('file_excel'));

        return redirect()->route('barang.index')->with('success_excel', 'Data barang berhasil diimport.');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategoris = Kategori::all();
        $jenisBarang = Jenis::all();
        $lokasis = Lokasi::all();

        return view('barangs.editBarang', compact('barang', 'kategoris', 'jenisBarang', 'lokasis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id' => 'required|string|unique:barangs,id,' . $id,
            'namaBarang' => 'required|string|max:255',
            'kategori_id' => 'required|string|exists:kategoris,id',
            'jenis_id' => 'required|string|exists:jenis,merek_id',
            'lokasi_id' => 'required|string|exists:lokasis,id',
            'kelengkapan' => 'required|in:0,1',
            'keterangan' => 'nullable|string',
        ], [
            'id.required' => 'ID barang harus diisi.',
            'id.unique' => 'ID barang sudah ada.',
            'namaBarang.required' => 'Nama barang harus diisi.',
            'kategori_id.required' => 'Kategori barang harus dipilih.',
            'jenis_id.required' => 'Jenis barang harus dipilih.',
            'lokasi_id.required' => 'Lokasi barang harus dipilih.',
            'kelengkapan.required' => 'Kelengkapan barang harus dipilih.',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update([
            'id' => $request->id,
            'nama_barang' => $request->namaBarang,
            'kategori_id' => $request->kategori_id,
            'jenis_id' => $request->jenis_id,
            'lokasi_id' => $request->lokasi_id,
            'kelengkapan' => $request->kelengkapan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')->with('success_delete', 'Data barang berhasil dihapus.');
    }

    public function dashboard()
    {
        $totalBarang = Barang::count();
        $barangLengkap = Barang::where('kelengkapan', 1)->count();
        $barangTidakLengkap = Barang::where('kelengkapan', 0)->count();
        $lokasiRelasi = Lokasi::withCount('barangs')->get();
        $kategoriData = Kategori::withCount('barangs')->get();

        $persenLengkap = $totalBarang > 0 ? round(($barangLengkap / $totalBarang) * 100) : 0;
        $persenTidakLengkap = $totalBarang > 0 ? round(($barangTidakLengkap / $totalBarang) * 100) : 0;
        $lokasiTerbanyak = $lokasiRelasi->sortByDesc('barangs_count')->first();

        return view('index', compact('totalBarang', 'barangLengkap', 'barangTidakLengkap', 'persenLengkap', 'persenTidakLengkap', 'lokasiTerbanyak', 'kategoriData', 'lokasiRelasi'));
    }
    
    public function getBarangByJenis($jenisId)
    {
        $barangs = Barang::where('jenis_id', $jenisId)
        ->where('status', 0)
        ->select('id', 'nama_barang', 'kelengkapan', 'status')
        ->orderBy('nama_barang')
        ->get();

        return response()->json($barangs);
    }
}
