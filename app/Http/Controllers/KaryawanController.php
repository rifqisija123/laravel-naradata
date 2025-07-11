<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::all();
        return view('layouts.dataKaryawan', compact('karyawans'));
    }
    public function create()
    {
        return view('layouts.createKaryawan');
    }
    public function store(Request $request)
    {
        $request->validate([
            'namaKaryawan' => 'required|string|max:255',
            'jabatan' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
        ], [
            'namaKaryawan.required' => 'Nama karyawan harus diisi.',
            'jabatan.required' => 'Jabatan harus diisi.',
        ]);

        Karyawan::create([
            'nama' => $request->namaKaryawan,
            'jabatan' => $request->jabatan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil ditambahkan.');
    }
    public function show($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return view('layouts.showKaryawan', compact('karyawan'));
    }
    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return view('layouts.editKaryawan', compact('karyawan'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'namaKaryawan' => 'required|string|max:255',
            'jabatan' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
        ], [
            'namaKaryawan.required' => 'Nama karyawan harus diisi.',
            'jabatan.required' => 'Jabatan harus diisi.',
        ]);

        $karyawan = Karyawan::findOrFail($id);
        $karyawan->update([
            'nama' => $request->namaKaryawan,
            'jabatan' => $request->jabatan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();
        return redirect()->route('karyawan.index')->with('success_delete', 'Data karyawan berhasil dihapus.');
    }
}
