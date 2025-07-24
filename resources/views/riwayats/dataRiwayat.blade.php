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
        <div class="d-flex justify-content-center mt-4 mb-5">
            <ul class="nav nav-pills rounded-pill bg-light px-2 py-1 shadow-sm" id="tabRiwayat" role="tablist">
                <li class="nav-item mx-2" role="presentation">
                    <button class="nav-link active rounded-pill px-4 py-2 fw-semibold" id="tab-peminjaman"
                        data-bs-toggle="pill" data-bs-target="#peminjaman" type="button" role="tab"
                        aria-controls="peminjaman" aria-selected="true">
                        <i class="bi bi-box-arrow-in-down me-1"></i> Peminjaman
                    </button>
                </li>
                <li class="nav-item mx-2" role="presentation">
                    <button class="nav-link rounded-pill px-4 py-2 fw-semibold" id="tab-pengembalian" data-bs-toggle="pill"
                        data-bs-target="#pengembalian" type="button" role="tab" aria-controls="pengembalian"
                        aria-selected="false">
                        <i class="bi bi-box-arrow-up me-1"></i> Pengembalian
                    </button>
                </li>
            </ul>
        </div>
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
        <div class="tab-content" id="riwayatTabContent">
            <div class="tab-pane fade show active" id="peminjaman" role="tabpanel" aria-labelledby="tab-peminjaman">
                @include('riwayats.partials.dataRiwayatPeminjaman')
            </div>
            <div class="tab-pane fade" id="pengembalian" role="tabpanel" aria-labelledby="tab-pengembalian">
                @include('riwayats.partials.dataRiwayatPengembalian')
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#tbl_riwayat_peminjaman').DataTable({
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

            $('#tbl_riwayat_pengembalian').DataTable({
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
