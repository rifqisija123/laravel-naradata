<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Posisi;
use App\Models\Karyawan;
use App\Models\Gudang;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Imports\BarangImport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class GudangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $gudang = Gudang::with(['barang', 'kategori', 'posisi', 'karyawan']);

            if ($request->start_date && $request->end_date) {
                $gudang->whereBetween('created_at', [$request->start_date, $request->end_date]);
            }

            return DataTables::of($gudang)
                ->addColumn('barang', function ($row) {
                    return $row->barang ? $row->barang->barang : '-';
                })
                ->addColumn('kategori', function ($row) {
                    return $row->kategori ? $row->kategori->kategori : '-';
                })
                ->addColumn('posisi', function ($row) {
                    return $row->posisi ? $row->posisi->posisi : '-';
                })
                ->addColumn('karyawan', function ($row) {
                    return $row->karyawan ? $row->karyawan->karyawan : '-';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at ? Carbon::parse($row->created_at)->format('d M Y') : '';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('view.edit', $row->id);
                    $deleteUrl = route('view.delete', $row->id);

                    return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-primary">Edit</a>
                    <form action="' . $deleteUrl . '" method="POST" style="display:inline;">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus barang ini?\')">Delete</button>
                    </form>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('index');
    }

    public function create()
    {
        $barangs = Barang::all();
        $kategoris = Kategori::all();
        $posisis = Posisi::all();
        $karyawans = Karyawan::all();
        return view('layouts.createBarang', compact('barangs', 'kategoris', 'posisis', 'karyawans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'nullable|exists:barangs,id',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'keterangan' => 'required|string',
            'posisi_id' => 'nullable|exists:posisis,id',
            'karyawan_id' => 'nullable|exists:karyawans,id',
            'tanggal' => 'required|date',
        ]);

        Gudang::create([
            'barang_id' => $request->barang_id,
            'kategori_id' => $request->kategori_id,
            'keterangan' => $request->keterangan,
            'posisi_id' => $request->posisi_id,
            'karyawan_id' => $request->karyawan_id,
            'created_at' => $request->tanggal,
        ]);

        return redirect()->route('view.gudang')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $gudang = Gudang::findOrFail($id);
        $barangs = Barang::all();
        $kategoris = Kategori::all();
        $posisis = Posisi::all();
        $karyawans = Karyawan::all();

        return view('layouts.editGudang', compact('gudang', 'barangs', 'kategoris', 'posisis', 'karyawans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id' => 'nullable|exists:barangs,id',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'keterangan' => 'required|string',
            'posisi_id' => 'nullable|exists:posisis,id',
            'karyawan_id' => 'nullable|exists:karyawans,id',
            'tanggal' => 'required|date',
        ]);

        $gudang = Gudang::findOrFail($id);
        $gudang->update([
            'barang_id' => $request->barang_id,
            'kategori_id' => $request->kategori_id,
            'keterangan' => $request->keterangan,
            'posisi_id' => $request->posisi_id,
            'karyawan_id' => $request->karyawan_id,
            'created_at' => $request->tanggal,
        ]);

        return redirect()->route('view.gudang')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id)
    {
        $gudang = Gudang::findOrFail($id);
        $gudang->delete();

        return redirect()->route('view.gudang')->with('success', 'Data berhasil dihapus.');
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

        return redirect()->route('view.gudang')->with('success', 'Data barang berhasil diimport.');
    }
}
