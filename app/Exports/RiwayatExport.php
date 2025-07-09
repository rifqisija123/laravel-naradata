<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RiwayatExport implements FromCollection, WithHeadings, WithStyles
{
    protected $riwayats;

    public function __construct($riwayats)
    {
        $this->riwayats = $riwayats;
    }

    public function collection()
    {
        return collect($this->riwayats)->map(function ($r) {
            return [
                $r->jenis->jenis ?? '-',
                $r->jenis->merek ?? '-',
                $r->barang->nama_barang ?? '-',
                $r->karyawan->nama ?? '-',
                $r->keterangan ?? 'Tidak ada keterangan',
                \Carbon\Carbon::parse($r->tanggal)->translatedFormat('d F Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Jenis',
            'Merek',
            'Nama Barang',
            'Karyawan',
            'Keterangan',
            'Tanggal',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
