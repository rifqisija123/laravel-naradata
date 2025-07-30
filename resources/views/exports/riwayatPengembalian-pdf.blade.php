<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Riwayat Pengembalian Barang</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Data Riwayat Pengembalian Barang</h2>
    <table>
        <thead>
            <tr>
                <th>Karyawan</th>
                <th>Jenis</th>
                <th>Merek</th>
                <th>Nama Barang</th>
                <th>Kondisi</th>
                <th>Keterangan</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayats as $r)
                <tr>
                    <td>{{ $r->karyawan->nama ?? '-' }}</td>
                    <td>{{ $r->jenis->jenis ?? '-' }}</td>
                    <td>{{ $r->jenis->merek ?? '-' }}</td>
                    <td>{{ $r->barang->nama_barang ?? '-' }}</td>
                    <td>{{ $r->kondisi ?? '-' }}</td>
                    <td>{{ $r->keterangan ?? 'Tidak ada keterangan' }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('d F Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>