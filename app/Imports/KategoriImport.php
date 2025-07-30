<?php

namespace App\Imports;

use App\Models\Kategori;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class KategoriImport implements ToModel, WithHeadingRow
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

        return new Kategori([
            'kategori'           => $row['kategori'],
            'keterangan'   => $row['keterangan'] ?? null,
        ]);
    }
}
