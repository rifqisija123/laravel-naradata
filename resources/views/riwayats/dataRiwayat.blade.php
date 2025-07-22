@extends('layouts.apps')

@section('title', 'Data Riwayat')

@section('content-card')
    <h4 class="fw-bold mb-4">Data Riwayat Peminjaman</h4>
    <div class="row justify-content-center g-5">
        <div class="col-lg-3-5 col-md-4 col-sm-6 col-12 custom-card">
            <div class="stat-box p-3 rounded-3 h-100 d-flex align-items-center gap-3">
                <div class="icon-box">
                    <i class="bi bi-clock-history fs-3"></i>
                </div>
                <div>
                    <small>Total Riwayat</small>
                    <h6 class="fw-bold m-0">{{ $totalRiwayat }}</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3-5 col-md-4 col-sm-6 col-12 custom-card">
            <div class="stat-box p-3 rounded-3 h-100 d-flex align-items-center gap-3">
                <div class="icon-box">
                    <i class="fas fa-user fs-3"></i>
                </div>
                <div>
                    <small>Karyawan Terbanyak</small>
                    <h6 class="fw-bold m-0">{{ $namaKaryawanTerbanyak ?? 'Tidak ada' }}</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3-5 col-md-4 col-sm-6 col-12 custom-card">
            <div class="stat-box p-3 rounded-3 h-100 d-flex align-items-center gap-3">
                <div class="icon-box">
                    <i class="fas fa-align-left fs-3"></i>
                </div>
                <div>
                    <small>Riwayat Tanpa Keterangan</small>
                    <h6 class="fw-bold m-0">{{ $riwayatTanpaKeterangan }}</h6>
                </div>
            </div>
        </div>
    </div>
    <h4 class="fw-bold mt-5 mb-4">Data Riwayat Pengembalian</h4>
    <div class="row justify-content-center g-5">
        <div class="col-lg-3-5 col-md-4 col-sm-6 col-12 custom-card">
            <div class="stat-box p-3 rounded-3 h-100 d-flex align-items-center gap-3">
                <div class="icon-box">
                    <i class="bi bi-clock-history fs-3"></i>
                </div>
                <div>
                    <small>Total Riwayat</small>
                    <h6 class="fw-bold m-0">-</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3-5 col-md-4 col-sm-6 col-12 custom-card">
            <div class="stat-box p-3 rounded-3 h-100 d-flex align-items-center gap-3">
                <div class="icon-box">
                    <i class="fas fa-user fs-3"></i>
                </div>
                <div>
                    <small>Karyawan Terbanyak</small>
                    <h6 class="fw-bold m-0">-</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3-5 col-md-4 col-sm-6 col-12 custom-card">
            <div class="stat-box p-3 rounded-3 h-100 d-flex align-items-center gap-3">
                <div class="icon-box">
                    <i class="fas fa-align-left fs-3"></i>
                </div>
                <div>
                    <small>Riwayat Tanpa Keterangan</small>
                    <h6 class="fw-bold m-0">-</h6>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content-index')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @elseif(session('success_delete'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success_delete') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 fw-semibold">Daftar Riwayat</h5>
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
                    <table class="table table-bordered align-middle" id="tbl_riwayat">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Karyawan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayats as $riwayat)
                                <tr>
                                    <td>{{ $riwayat->barang->nama_barang ?? '-' }}</td>
                                    <td>{{ $riwayat->karyawan->nama ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('riwayat.show', $riwayat->id) }}"
                                                class="btn btn-sm btn-primary" title="Lihat">
                                                <i class="fas fa-eye"></i> Show
                                            </a>
                                            <a href="{{ route('riwayat.edit', $riwayat->id) }}"
                                                class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-pen"></i> Edit
                                            </a>
                                            <form action="{{ route('riwayat.destroy', $riwayat->id) }}" method="POST"
                                                class="form-delete d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger btn-delete"
                                                    data-nama="{{ $riwayat->barang->nama_barang ?? '-' }}" data-karyawan="{{ $riwayat->karyawan->nama ?? '-' }}" title="Hapus">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada data Riwayat</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const table = $('#tbl_riwayat').DataTable({
                dom: "<'row mb-2'<'col-sm-6'l><'col-sm-6 text-end'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row mt-2'<'col-sm-6'i><'col-sm-6'p>>",
                pagingType: 'simple_numbers',
                language: {
                    lengthMenu: 'Tampilkan _MENU_ entri',
                    paginate: {
                        previous: '<button class="btn btn-light btn-sm me-1">Sebelumnya</button>',
                        next: '<button class="btn btn-light btn-sm ms-1">Selanjutnya</button>'
                    },
                    search: "Cari:",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    infoEmpty: "Tidak ada data tersedia",
                    emptyTable: "Tidak ada data di tabel",
                }
            });
        });
        $(document).ready(function() {
            $('.form-delete').on('submit', function(e) {
                e.preventDefault();

                const form = this;
                const nama = $(this).find('.btn-delete').data('nama');
                const karyawan = $(this).find('.btn-delete').data('karyawan');

                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: `Data riwayat dengan nama barang "${nama}" dan nama karyawan "${karyawan}" akan dihapus!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-secondary ms-2'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // submit form jika user yakin
                    }
                });
            });
        });
        @if (session('success_delete'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success_delete') }}',
                showConfirmButton: false,
                timer: 1500
            });
        @endif
    </script>
@endpush
