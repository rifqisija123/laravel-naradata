<?php

namespace App\Http\Controllers;

use App\Exports\RiwayatExport;
use App\Exports\RiwayatPengembalianExport;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\Riwayat;
use App\Models\Barang;
use App\Models\Karyawan;
use App\Models\Jenis;
use App\Models\Riwayats_pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class RiwayatController extends Controller
{
    public function index()
    {
        $riwayats = Riwayat::all();
        $riwayatsPengembalian = Riwayats_pengembalian::all();
        $totalRiwayat = Riwayat::count();
        $totalRiwayatPengembalian = Riwayats_pengembalian::count();
        $riwayatTanpaKeterangan = Riwayat::where('keterangan', null)->count();
        $riwayatPengembalianTanpaKeterangan = Riwayats_pengembalian::where('keterangan', null)->count();

        $karyawanTerbanyak = DB::table('riwayats')
            ->select('karyawan_id', DB::raw('count(*) as total'))
            ->groupBy('karyawan_id')
            ->orderByDesc('total')
            ->first();

        $karyawanPengembalianTerbanyak = DB::table('riwayats_pengembalians')
            ->select('karyawan_id', DB::raw('count(*) as total'))
            ->groupBy('karyawan_id')
            ->orderByDesc('total')
            ->first();

        $namaKaryawanTerbanyak = null;
        $namaKaryawanPengembalianTerbanyak = null;

        if ($karyawanTerbanyak) {
            $karyawan = Karyawan::find($karyawanTerbanyak->karyawan_id);
            $namaKaryawanTerbanyak = $karyawan ? $karyawan->nama . ' (' . $karyawanTerbanyak->total . ')' : 'Tidak ada';
        }

        if ($karyawanPengembalianTerbanyak) {
            $karyawanPengembalian = Karyawan::find($karyawanPengembalianTerbanyak->karyawan_id);
            $namaKaryawanPengembalianTerbanyak = $karyawanPengembalian ? $karyawanPengembalian->nama . ' (' . $karyawanPengembalianTerbanyak->total . ')' : 'Tidak ada';
        }

        return view('riwayats.dataRiwayat', compact('riwayats', 'riwayatsPengembalian', 'totalRiwayat', 'totalRiwayatPengembalian', 'namaKaryawanTerbanyak', 'namaKaryawanPengembalianTerbanyak', 'riwayatTanpaKeterangan', 'riwayatPengembalianTanpaKeterangan'));
    }
    public function create()
    {
        $jenisBarang = Jenis::all();
        $barangs = Barang::all();
        $karyawans = Karyawan::all();

        $karyawanPeminjaman = Karyawan::whereIn('id', function ($query) {
            $query->select('karyawan_id')->from('riwayats');
        })->get();

        return view('riwayats.createRiwayat', compact('jenisBarang', 'barangs', 'karyawans', 'karyawanPeminjaman'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'jenis_id' => 'required|exists:jenis,id',
            'merek_id' => 'required|exists:jenis,merek_id',
            'barang_id' => 'required|exists:barangs,id',
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ], [
            'jenis_id.required' => 'Jenis barang harus dipilih.',
            'merek_id.required' => 'Merek barang harus dipilih.',
            'barang_id.required' => 'Barang harus dipilih.',
            'karyawan_id.required' => 'Karyawan harus dipilih.',
            'tanggal.required' => 'Tanggal harus diisi.',
        ]);

        DB::transaction(function () use ($request) {

            $barang = Barang::lockForUpdate()->findOrFail($request->barang_id);

            Riwayat::create([
                'jenis_id' => $request->merek_id,
                'barang_id' => $barang->id,
                'nama_barang' => $barang->nama_barang,
                'karyawan_id' => $request->karyawan_id,
                'tanggal' => $request->tanggal,
                'keterangan'  => $request->keterangan,
            ]);

            $barang->update(['status' => 1]);
        });

        return redirect()->route('riwayat.index')->with('success', 'Riwayat Peminjaman berhasil ditambahkan.');
    }
    public function show($id)
    {
        $riwayat = Riwayat::with(['barang', 'karyawan', 'jenis'])->findOrFail($id);
        return view('riwayats.showRiwayat', compact('riwayat'));
    }
    public function edit($id)
    {
        $riwayat = Riwayat::with('barang', 'karyawan', 'jenis')->findOrFail($id);
        $jenisBarang = Jenis::all();
        $barangs = Barang::all();
        $karyawans = Karyawan::all();
        return view('riwayats.editRiwayat', compact('riwayat', 'jenisBarang', 'barangs', 'karyawans'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_id' => 'required|exists:jenis,id',
            'merek_id' => 'required|exists:jenis,merek_id',
            'barang_id' => 'required|exists:barangs,id',
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ], [
            'jenis_id.required' => 'Jenis barang harus dipilih.',
            'merek_id.required' => 'Merek barang harus dipilih.',
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
                'jenis_id' => $request->merek_id,
                'barang_id' => $barangBaru->id,
                'nama_barang' => $barangBaru->nama_barang,
                'karyawan_id' => $request->karyawan_id,
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
            ]);
        });
        return redirect()->route('riwayat.index')->with('success', 'Riwayat Peminjaman berhasil diperbarui.');
    }
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $riwayat = Riwayat::findOrFail($id);

            $barang = $riwayat->barang;

            if ($riwayat->status == 0) {
                $riwayatTerakhir = Riwayat::where('barang_id', $barang->id)
                    ->orderByDesc('created_at')
                    ->first();

                if ($riwayatTerakhir && $riwayatTerakhir->id == $riwayat->id) {
                    $barang->update(['status' => 0]);
                }
            }
            $riwayat->delete();
        });

        return redirect()->route('riwayat.index')->with('success_delete', 'Riwayat berhasil dihapus.');
    }
    public function export($format)
    {
        $riwayats = Riwayat::with(['barang', 'jenis', 'karyawan'])->get();

        if ($format === 'excel') {
            return Excel::download(new RiwayatExport($riwayats), 'datariwayatpeminjaman.xlsx');
        }

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('exports.riwayat-pdf', compact('riwayats'));
            return $pdf->download('datariwayatpeminjaman.pdf');
        }

        if ($format === 'print') {
            return view('exports.riwayat-print', compact('riwayats'));
        }

        abort(404);
    }
    public function exportPengembalian($format)
    {
        $riwayats = Riwayats_pengembalian::with(['barang', 'jenis', 'karyawan'])->get();

        if ($format === 'excel') {
            return Excel::download(new RiwayatPengembalianExport($riwayats), 'datariwayatpengembalian.xlsx');
        }

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('exports.riwayatPengembalian-pdf', compact('riwayats'));
            return $pdf->download('datariwayatpengembalian.pdf');
        }

        if ($format === 'print') {
            return view('exports.riwayatPengembalian-print', compact('riwayats'));
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
    public function createPengembalian()
    {
        $jenisBarang = Jenis::all();
        $barangs = Barang::all();

        $karyawans = Karyawan::whereIn('id', function ($query) {
            $query->select('karyawan_id')
                ->from('riwayats')
                ->whereNull('keterangan');
        })->get();

        return view('riwayats.createRiwayat', compact('jenisBarang', 'barangs', 'karyawans'));
    }
    public function storePengembalian(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'jenis_id' => 'required|exists:jenis,merek_id',
            'barang_id' => 'required|exists:barangs,id',
            'tanggal' => 'required|date',
            'kondisi' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'jenis_id.required' => 'Jenis barang harus dipilih.',
            'barang_id.required' => 'Barang harus dipilih.',
            'karyawan_id.required' => 'Karyawan harus dipilih.',
            'tanggal.required' => 'Tanggal harus diisi.',
            'kondisi.required' => 'Kondisi harus diisi'
        ]);

        DB::transaction(function () use ($request) {

            $barang = Barang::lockForUpdate()->findOrFail($request->barang_id);
            $karyawan = Karyawan::lockForUpdate()->findOrFail($request->karyawan_id);

            $riwayat = Riwayat::where('barang_id', $barang->id)
                ->where('karyawan_id', $karyawan->id)
                ->where('status', 0)
                ->latest()
                ->first();

            Riwayats_pengembalian::create([
                'riwayat_id' => $riwayat->id,
                'karyawan_id' => $karyawan->id,
                'nama_karyawan' => $karyawan->nama,
                'jenis_id' => $request->jenis_id,
                'barang_id' => $barang->id,
                'nama_barang' => $barang->nama_barang,
                'tanggal' => $request->tanggal,
                'kondisi'  => $request->kondisi,
                'keterangan'  => $request->keterangan,
            ]);

            $barang->update(['status' => 0]);

            if ($riwayat) {
                $riwayat->update(['status' => 1]);
            }
        });

        return redirect()->route('riwayat.index')->with('success', 'Riwayat Pengembalian berhasil ditambahkan.');
    }
    public function showPengembalian($id)
    {
        $riwayatPengembalian = Riwayats_pengembalian::with(['barang', 'karyawan', 'jenis'])->findOrFail($id);
        return view('riwayats.showRiwayatPengembalian', compact('riwayatPengembalian'));
    }
    public function editPengembalian($id)
    {
        $riwayatPengembalian = Riwayats_pengembalian::findOrFail($id);
        $jenisBarang = Jenis::all();
        $barangs = Barang::all();
        $karyawans = Karyawan::all();

        $karyawanPeminjaman = Karyawan::whereIn('id', function ($query) {
            $query->select('karyawan_id')->from('riwayats');
        })->get();

        return view('riwayats.editRiwayatPengembalian', compact('riwayatPengembalian', 'jenisBarang', 'barangs', 'karyawans', 'karyawanPeminjaman'));
    }

    public function getBarangTersedia(Request $request)
    {
        $jenis_id = $request->jenis_id;
        $karyawan_id = $request->karyawan_id;
        $current_id = $request->current_id;

        $barangQuery = Barang::where('jenis_id', $jenis_id)
            ->where('status', 1);

        $barangsAktif = $barangQuery->get();

        $barangDipinjamOlehKaryawan = Riwayat::where('karyawan_id', $karyawan_id)
            ->where('status', 0)
            ->whereNull('keterangan')
            ->pluck('barang_id')
            ->toArray();

        $filtered = $barangsAktif->filter(function ($barang) use ($barangDipinjamOlehKaryawan) {
            return in_array($barang->id, $barangDipinjamOlehKaryawan);
        });

        if ($current_id) {
            $currentBarang = Barang::find($current_id);
            if (
                $currentBarang &&
                $currentBarang->jenis_id == $jenis_id &&
                $barangsAktif->pluck('id')->contains($currentBarang->id)
            ) {
                $filtered->push($currentBarang);
            }
        }

        return response()->json($filtered->unique('id')->values());
    }

    public function getMerekByJenisAndKaryawan($jenis_id, $karyawan_id)
    {
        // Ambil semua merek dari jenis yang dipilih (anggap ini tetap valid)
        $merekList = Jenis::where('id', $jenis_id)->pluck('merek_id');

        // Ubah: Hindari whereHas atau relasi ambigu
        $riwayat = Riwayat::where('karyawan_id', $karyawan_id)
            ->whereNull('keterangan')
            ->where('status', 0)
            ->with(['barang'])
            ->get()
            ->filter(function ($r) {
                return $r->barang && $r->barang->status == 1;
            })
            ->filter(function ($r) use ($merekList) {
                // Ambil data jenis berdasarkan barang->jenis_id yang = merek_id
                $jenis = Jenis::where('merek_id', $r->barang->jenis_id)->first();
                return $jenis && $merekList->contains($jenis->merek_id);
            })
            ->map(function ($r) {
                $jenis = Jenis::where('merek_id', $r->barang->jenis_id)->first();
                return [
                    'merek_id' => $jenis->merek_id,
                    'merek' => $jenis->merek,
                ];
            })
            ->unique('merek_id')
            ->values();

        return response()->json($riwayat);
    }

    public function getBarangEdit(Request $request)
    {
        $jenis_id = $request->jenis_id;
        $karyawan_id = $request->karyawan_id;
        $merek_id = $request->merek_id;
        $current_id = $request->current_id;

        // Ambil semua barang yang dipinjam karyawan
        $riwayatBarangIds = Riwayat::where('karyawan_id', $karyawan_id)
            ->where('status', 0)
            ->whereNull('keterangan')
            ->pluck('barang_id')
            ->toArray();

        // Karena relasi jenis() menggunakan jenis_id → jenis.merek_id
        $barangs = Barang::whereIn('id', $riwayatBarangIds)
            ->where('status', 1)
            ->where('jenis_id', $merek_id) // ← sesuai relasi
            ->get();

        // Tambahkan currentBarang jika sesuai
        if ($current_id) {
            $currentBarang = Barang::with('jenis')->find($current_id);

            if (
                $currentBarang &&
                $currentBarang->status == 1 &&
                $currentBarang->jenis_id == $merek_id
            ) {
                $barangs->push($currentBarang);
            }
        }

        return response()->json($barangs->unique('id')->values());
    }

    public function getJenisByKaryawan($karyawan_id)
    {
        $jenis = Riwayat::where('karyawan_id', $karyawan_id)
            ->whereNull('keterangan')
            ->where('status', 0)
            ->with('jenis')
            ->get()
            ->pluck('jenis')
            ->unique('id')
            ->values();

        return response()->json($jenis);
    }

    public function updatePengembalian(Request $request, $id)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'jenis_id' => 'required|exists:jenis,id',
            'merek_id' => 'required|exists:jenis,merek_id',
            'barang_id' => 'required|exists:barangs,id',
            'tanggal' => 'required|date',
            'kondisi' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'jenis_id.required' => 'Jenis barang harus dipilih.',
            'merek_id.required' => 'Merek barang harus dipilih.',
            'barang_id.required' => 'Barang harus dipilih.',
            'karyawan_id.required' => 'Karyawan harus dipilih.',
            'tanggal.required' => 'Tanggal harus diisi.',
            'kondisi.required' => 'kondisi harus diisi',
        ]);
        DB::transaction(function () use ($request, $id) {
            $riwayatPengembalian = Riwayats_pengembalian::findOrFail($id);
            $barangBaru = Barang::findOrFail($request->barang_id);
            $karyawan = Karyawan::findOrFail($request->karyawan_id);

            $barangLamaId = $riwayatPengembalian->barang_id;

            if ($barangLamaId != $barangBaru->id) {
                Barang::where('id', $barangLamaId)->update(['status' => 1]);

                $barangBaru->update(['status' => 0]);

                $riwayatLama = Riwayat::where('barang_id', $barangLamaId)
                    ->where('karyawan_id', $riwayatPengembalian->karyawan_id)
                    ->where('status', 0)
                    ->latest()
                    ->first();

                if ($riwayatLama) {
                    $riwayatLama->update(['status' => 1]);
                }
                // dd($riwayatLama);

                $riwayatBaru = Riwayat::where('barang_id', $barangBaru->id)
                    ->where('karyawan_id', $riwayatPengembalian->karyawan_id)
                    ->where('status', 1)
                    ->latest()
                    ->first();

                if ($riwayatBaru) {
                    $riwayatBaru->update(['status' => 0]);
                }
                // dd($riwayatBaru);
            } else {
                $barangBaru->update(['status' => 1]);

                Riwayat::where('barang_id', $barangBaru->id)
                    ->where('karyawan_id', $riwayatPengembalian->karyawan_id)
                    ->where('status', 0)
                    ->latest()
                    ->first()?->update(['status' => 1]);
            }

            $riwayatPengembalian->update([
                'karyawan_id' => $karyawan->id,
                'nama_karyawan' => $karyawan->nama,
                'jenis_id' => $request->merek_id,
                'barang_id' => $barangBaru->id,
                'nama_barang' => $barangBaru->nama_barang,
                'tanggal' => $request->tanggal,
                'kondisi' => $request->kondisi,
                'keterangan' => $request->keterangan,
            ]);
        });
        return redirect()->route('riwayat.index')->with('success', 'Riwayat Pengembalian berhasil diperbarui.');
    }
    public function destroyPengembalian($id)
    {
        DB::transaction(function () use ($id) {
            $riwayatPengembalian = Riwayats_pengembalian::with('riwayat')->findOrFail($id);
            $barang = $riwayatPengembalian->barang;

            $riwayat = $riwayatPengembalian->riwayat;

            if ($barang) {
                $barang->update(['status' => 1]);
            }

            if ($riwayat) {
                $riwayat->update(['status' => 0]);
            }

            $riwayatPengembalian->delete();
        });

        return redirect()->route('riwayat.index')->with('success_delete', 'Riwayat Pengembalian berhasil dihapus.');
    }
}
