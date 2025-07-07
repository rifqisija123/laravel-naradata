@extends('layouts.apps')

@section('title', 'Detail Lokasi')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4"><i class="fas fa-map-marker-alt me-2 text-primary"></i>Detail Lokasi</h3>

        <div class="card shadow-sm rounded-4">
            <div class="card-body px-4 py-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i class="fas fa-id-badge me-2 text-secondary"></i><strong>ID:</strong></p>
                        <h5>{{ $lokasi->id }}</h5>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i
                                class="fas fa-map-marker-alt me-2 text-secondary"></i><strong>Lokasi:</strong></p>
                        <h5>{{ $lokasi->posisi }}</h5>
                    </div>
                    <div class="col-md-12">
                        <p class="mb-1 text-muted"><i
                                class="fas fa-align-left me-2 text-secondary"></i><strong>Keterangan:</strong></p>
                        <h5>{{ $lokasi->keterangan ?? 'Tidak ada keterangan' }}</h5>
                    </div>
                    <hr class="my-3">
                    <div class="col-md-12 d-flex gap-2">
                        <button type="button" class="btn btn-warning btn-sm btn-edit-lokasi" title="Edit"
                            data-id="{{ $lokasi->id }}" data-lokasi="{{ $lokasi->posisi }}"
                            data-keterangan="{{ $lokasi->keterangan }}" data-bs-toggle="modal"
                            data-bs-target="#editModalLokasi"><i class="fas fa-pen"></i></button>
                        <form action="{{ route('lokasi.destroy', $lokasi->id) }}" method="POST" class="form-delete d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger btn-delete" data-nama="{{ $lokasi->posisi }}" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('lokasi.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Lokasi
                    </a>
                </div>
            </div>
        </div>
        {{-- Modal Edit --}}
        <div class="modal fade" id="editModalLokasi" tabindex="-1" aria-labelledby="modalLokasiLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="formEditLokasiModal">
                    @csrf
                    <input type="hidden" id="edit_id">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Lokasi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="editLokasi" class="form-label">Posisi:</label>
                            <input type="text" class="form-control" id="editLokasi" required>
                        </div>
                        <div class="modal-body">
                            <button type="button" class="btn btn-sm btn-secondary mb-2" id="toggleKeteranganLokasi">
                                Tambah Keterangan
                            </button>
                            <div id="wrapperKeteranganLokasi" style="display: none;">
                                <label for="keteranganEditLokasi" class="form-label">Keterangan:</label>
                                <input type="text" class="form-control" id="keteranganEditLokasi">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" id="btnUpdateLokasi">Edit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#toggleKeteranganLokasi').click(function() {
                $('#wrapperKeteranganLokasi').slideToggle();
            });
        });
        $(document).on('click', '.btn-edit-lokasi', function() {
            const id = $(this).data('id');
            const lokasi = $(this).data('lokasi');
            const keterangan = $(this).data('keterangan');

            $('#edit_id').val(id);
            $('#editLokasi').val(lokasi);
            $('#keteranganEditLokasi').val(keterangan);

            if (keterangan) {
                $('#wrapperKeteranganLokasi').show();
            } else {
                $('#wrapperKeteranganLokasi').hide();
            }
        });
        $('#btnUpdateLokasi').on('click', function(e) {
            e.preventDefault();

            const id = $('#edit_id').val();
            const lokasi = $('#editLokasi').val();
            const keterangan = $('#keteranganEditLokasi').val();

            Swal.fire({
                title: 'Yakin ingin menyimpan perubahan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-secondary ms-2'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/lokasi/update/${id}`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'PUT',
                            lokasi: lokasi,
                            keterangan: keterangan
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#editModalLokasi').modal('hide');

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Data lokasi berhasil diupdate.',
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                // reload setelah swal ditutup
                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            } else {
                                Swal.fire('Gagal!', response.message || 'Gagal update data.',
                                    'error');
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 409) {
                                Swal.fire('Gagal!', 'Lokasi sudah ada.', 'warning');
                            } else {
                                Swal.fire('Gagal!', 'Terjadi kesalahan saat update data.',
                                    'error');
                            }
                        }
                    });
                }
            });
        });
        $(document).ready(function() {
            $('.form-delete').on('submit', function(e) {
                e.preventDefault();

                const form = this;
                const nama = $(this).find('.btn-delete').data('nama');

                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: `Data Lokasi "${nama}" akan dihapus!`,
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
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        @endif
    </script>
@endpush
