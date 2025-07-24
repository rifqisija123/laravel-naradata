@extends('layouts.apps')

@section('title', 'Detail Riwayat')

@section('content')
    <div class="container mt-4">
        <div class="mb-3">
            <a href="{{ route('riwayat.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
        <h3 class="mb-4"><i class="bi bi-clock-history me-2 text-primary"></i>Detail Riwayat Peminjaman</h3>

        <div class="card shadow-sm rounded-4">
            <div class="card-body px-4 py-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i class="fas fa-id-badge me-2 text-secondary"></i><strong>ID:</strong>
                        </p>
                        <h5>{{ $riwayat->id }}</h5>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i
                                class="fas fa-cubes me-2 text-secondary"></i><strong>Jenis & Merek:</strong></p>
                        <h5>{{ $riwayat->jenis ? $riwayat->jenis->jenis . ' - ' . $riwayat->jenis->merek : '-' }}</h5>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i class="fas fa-tag me-2 text-secondary"></i><strong>Nama Barang:</strong>
                        </p>
                        <h5>{{ $riwayat->barang->nama_barang ?? '-' }}</h5>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i
                                class="fas fa-user me-2 text-secondary"></i><strong>Karyawan:</strong></p>
                        <h5>{{ $riwayat->karyawan->nama ?? '-' }}</h5>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i
                                class="fas fa-align-left me-2 text-secondary"></i><strong>Keterangan:</strong></p>
                        <h5>{{ $riwayat->keterangan ?? 'Tidak ada keterangan' }}</h5>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i class="fas fa-calendar-alt me-2 text-secondary"></i><strong>Tanggal:</strong>
                        </p>
                        <h5>{{ $riwayat->tanggal ? \Carbon\Carbon::parse($riwayat->tanggal)->translatedFormat('d F Y') : '-' }}</h5>
                    </div>

                    <hr class="my-3">
                    <div class="col-md-6 d-flex gap-2">
                        <a href="{{ route('riwayat.edit', $riwayat->id) }}" class="btn btn-sm btn-warning" title="Edit">
                            <i class="fas fa-pen"></i>
                        </a>
                        <form action="{{ route('riwayat.destroy', $riwayat->id) }}" method="POST" class="form-delete d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger btn-delete" data-nama="{{ $riwayat->barang->nama_barang ?? '-' }}" data-karyawan="{{ $riwayat->karyawan->nama ?? '-' }}" title="Hapus">
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
