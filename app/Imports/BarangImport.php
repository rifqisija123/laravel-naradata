<?php

namespace App\Imports;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Jenis;
use App\Models\Lokasi;
use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BarangImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Cek atau Tambahkan Kategori
        $kategori = Kategori::firstOrCreate(
            ['kategori' => $row['kategori_id']]
        );

        // Cek atau Tambahkan Jenis
        $jenis = Jenis::firstOrCreate(
            ['jenis' => $row['jenis_id']]
        );

        // Cek atau Tambahkan Lokasi
        $lokasi = Lokasi::firstOrCreate(
            ['posisi' => $row['lokasi_id']]
        );

        // Konversi string ke int (1 = Lengkap, 0 = Tidak Lengkap)
        $kelengkapanString = strtolower(trim($row['kelengkapan']));
        $kelengkapan = ($kelengkapanString === 'lengkap') ? 1 : 0;

        return new Barang([
            'id' => $row['id'],
            'nama_barang' => $row['nama_barang'],
            'kategori_id' => $kategori->id,
            'jenis_id' => $jenis->id,
            'lokasi_id' => $lokasi->id,
            'kelengkapan' => $kelengkapan,
            'keterangan' => $row['keterangan'],
        ]);
    }
}
