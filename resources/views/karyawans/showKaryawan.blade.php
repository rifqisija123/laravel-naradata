@extends('layouts.apps')

@section('title', 'Detail Karyawan')

@section('content')
    <div class="container mt-4">
        <div class="mb-3">
            <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
        <h3 class="mb-4"><i class="fas fa-box-open me-2 text-primary"></i>Detail Karyawan</h3>

        <div class="card shadow-sm rounded-4">
            <div class="card-body px-4 py-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i class="fas fa-id-badge me-2 text-secondary"></i><strong>ID:</strong>
                        </p>
                        <h5>{{ $karyawan->id }}</h5>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i class="fas fa-user-tie me-2 text-secondary"></i><strong>Nama Karyawan:</strong></p>
                        <h5>{{ $karyawan->nama }}</h5>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i class="fas fa-briefcase me-2 text-secondary"></i><strong>Jabatan:</strong></p>
                        <h5>{{ $karyawan->jabatan }}</h5>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i
                                class="fas fa-align-left me-2 text-secondary"></i><strong>Keterangan:</strong></p>
                        <h5>{{ $karyawan->keterangan ?? 'Tidak ada keterangan' }}</h5>
                    </div>
                    <hr class="my-3">
                    <div class="col-md-6 d-flex gap-2">
                        <a href="{{ route('karyawan.edit', $karyawan->id) }}" class="btn btn-sm btn-warning" title="Edit">
                            <i class="fas fa-pen"></i>
                        </a>
                        <form action="{{ route('karyawan.destroy', $karyawan->id) }}" method="POST" class="form-delete d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger btn-delete" data-nama="{{ $karyawan->nama }}" title="Hapus">
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

                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: `Data karyawan ${nama} akan dihapus!`,
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
