@extends('layouts.apps')

@section('title', 'Detail Riwayat Pengembalian')

@section('content')
    <div class="container mt-4">
        <div class="mb-3">
            <a href="{{ route('riwayat.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
        <h3 class="mb-4"><i class="bi bi-clock-history me-2 text-primary"></i>Detail Riwayat Pengembalian</h3>

        <div class="card shadow-sm rounded-4">
            <div class="card-body px-4 py-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i class="fas fa-id-badge me-2 text-secondary"></i><strong>ID:</strong>
                        </p>
                        <h5>{{ $riwayatPengembalian->id }}</h5>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i
                                class="fas fa-user me-2 text-secondary"></i><strong>Karyawan:</strong></p>
                        <h5>{{ $riwayatPengembalian->karyawan->nama ?? '-' }}</h5>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i
                                class="fas fa-cubes me-2 text-secondary"></i><strong>Jenis:</strong></p>
                        <h5>{{ $riwayatPengembalian->jenis ? $riwayatPengembalian->jenis->jenis : '-' }}</h5>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i
                                class="fas fa-cubes me-2 text-secondary"></i><strong>Merek:</strong></p>
                        <h5>{{ $riwayatPengembalian->jenis ? $riwayatPengembalian->jenis->merek : '-' }}</h5>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i class="fas fa-tag me-2 text-secondary"></i><strong>Nama Barang:</strong>
                        </p>
                        <h5>{{ $riwayatPengembalian->barang->nama_barang . ' (' . ($riwayatPengembalian->barang->kelengkapan == 1 ? 'Lengkap' : 'Tidak Lengkap') . ')' ?? '-' }}</h5>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i
                                class="fas fa-tools me-2 text-secondary"></i><strong>Kondisi:</strong></p>
                        <h5>{{ $riwayatPengembalian->kondisi ?? '-' }}</h5>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i
                                class="fas fa-align-left me-2 text-secondary"></i><strong>Keterangan:</strong></p>
                        <h5>{{ $riwayatPengembalian->keterangan ?? 'Tidak ada keterangan' }}</h5>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i class="fas fa-calendar-alt me-2 text-secondary"></i><strong>Tanggal:</strong>
                        </p>
                        <h5>{{ $riwayatPengembalian->tanggal ? \Carbon\Carbon::parse($riwayatPengembalian->tanggal)->translatedFormat('d F Y') : '-' }}</h5>
                    </div>

                    <hr class="my-3">
                    <div class="col-md-6 d-flex gap-2">
                        <a href="{{ route('riwayat.pengembalian.edit', $riwayatPengembalian->id) }}" class="btn btn-sm btn-warning" title="Edit">
                            <i class="fas fa-pen"></i>
                        </a>
                        <form action="{{ route('riwayat.destroy', $riwayatPengembalian->id) }}" method="POST" class="form-delete d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger btn-delete" data-nama="{{ $riwayatPengembalian->barang->nama_barang ?? '-' }}" data-karyawan="{{ $riwayatPengembalian->karyawan->nama ?? '-' }}" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.form-delete').on('submit', function(e) {
                e.preventDefault();

                const form = this;
                const nama = $(this).find('.btn-delete').data('nama');
                const karyawan = $(this).find('.btn-delete').data('karyawan');

                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: `Data riwayat pengembalian dengan nama barang ${nama} dan nama karyawan ${karyawan} akan dihapus!`,
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
