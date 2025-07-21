<?php

namespace App\Imports;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Jenis;
use App\Models\Lokasi;
use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class BarangImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $row = collect($row)->mapWithKeys(function ($value, $key) {
            return [$key => is_string($value) ? trim(preg_replace('/\s+/u', ' ', $value)) : $value];
        })->all();

        $kategori = Kategori::firstOrCreate(['kategori' => $row['kategori_id']]);
        $jenis = Jenis::firstOrCreate(
            [
                'jenis' => $row['jenis_id'],
                'merek' => $row['merek_id'],
            ]
        );
        $lokasi   = Lokasi::firstOrCreate(['posisi'   => $row['lokasi_id']]);
        $kelengkapan = Str::lower($row['kelengkapan']) === 'lengkap' ? 1 : 0;

        return new Barang([
            'id'           => $row['id'],
            'nama_barang'  => $row['nama_barang'],
            'kategori_id'  => $kategori->id,
            'jenis_id'     => $jenis->merek_id,
            'lokasi_id'    => $lokasi->id,
            'kelengkapan'  => $kelengkapan,
            'keterangan'   => $row['keterangan'] ?? null,
        ]);
    }
}
