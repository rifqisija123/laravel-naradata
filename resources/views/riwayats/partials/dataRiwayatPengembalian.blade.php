<div class="d-flex justify-content-between align-items-center mb-3 mt-5">
    <h5 class="mb-0 fw-semibold">Daftar Riwayat Pengembalian</h5>
    <div>
        <a href="{{ route('riwayat.create') }}" class="btn btn-primary me-2"><i class="fas fa-plus me-1"></i> Tambah
            Riwayat</a>
        <div class="btn-group me-2">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fas fa-print me-1"></i> Cetak
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="{{ route('riwayat.export', ['format' => 'pdf']) }}">
                        <i class="fas fa-file-pdf me-1 text-danger"></i> PDF
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('riwayat.export', ['format' => 'excel']) }}">
                        <i class="fas fa-file-excel me-1 text-success"></i> Excel
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('riwayat.export', ['format' => 'print']) }}"
                        target="_blank">
                        <i class="fas fa-print me-1 text-dark"></i> Print
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

{{-- Tabel --}}
<div class="card shadow-sm border-1 rounded-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered align-middle" id="tbl_riwayat_pengembalian">
                <thead class="table-light">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Karyawan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatsPengembalian as $riwayat)
                        <tr>
                            <td>{{ $riwayat->barang->nama_barang ?? '-' }}</td>
                            <td>{{ $riwayat->karyawan->nama ?? '-' }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('riwayat.show', $riwayat->id) }}" class="btn btn-sm btn-primary"
                                        title="Lihat">
                                        <i class="fas fa-eye"></i> Show
                                    </a>
                                    <a href="{{ route('riwayat.edit', $riwayat->id) }}" class="btn btn-sm btn-warning"
                                        title="Edit">
                                        <i class="fas fa-pen"></i> Edit
                                    </a>
                                    <form action="{{ route('riwayat.destroy', $riwayat->id) }}" method="POST"
                                        class="form-delete d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger btn-delete"
                                            data-nama="{{ $riwayat->barang->nama_barang ?? '-' }}"
                                            data-karyawan="{{ $riwayat->karyawan->nama ?? '-' }}" title="Hapus">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada data Riwayat Pengembalian</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
