@extends('layouts.apps')

@section('title', 'Detail Jenis & Merek')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4"><i class="fas fa-cubes me-2 text-primary"></i>Detail Jenis & Merek</h3>

        <div class="card shadow-sm rounded-4">
            <div class="card-body px-4 py-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i class="fas fa-id-badge me-2 text-secondary"></i><strong>ID:</strong></p>
                        <h5>{{ $jenis->merek_id }}</h5>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i class="fas fa-cubes me-2 text-secondary"></i><strong>Jenis:</strong>
                        </p>
                        <h5>{{ $jenis->jenis }}</h5>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i class="fas fa-cubes me-2 text-secondary"></i><strong>Merek:</strong>
                        </p>
                        <h5>{{ $jenis->merek }}</h5>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i
                                class="fas fa-align-left me-2 text-secondary"></i><strong>Keterangan:</strong></p>
                        <h5>{{ $jenis->keterangan ?? 'Tidak ada keterangan' }}</h5>
                    </div>
                    <hr class="my-3">
                    <div class="col-md-12 d-flex gap-2">
                        <button type="button" class="btn btn-warning btn-sm btn-edit-jenis" title="Edit"
                            data-id="{{ $jenis->merek_id }}" data-jenis="{{ $jenis->jenis }}"
                            data-merek="{{ $jenis->merek }}" data-keterangan="{{ $jenis->keterangan }}"
                            data-bs-toggle="modal" data-bs-target="#editModalJenis"><i class="fas fa-pen"></i></button>
                        <form action="{{ route('jenis.destroy', $jenis->merek_id) }}" method="POST"
                            class="form-delete d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger btn-delete" data-nama="{{ $jenis->jenis }}"
                                data-jenis="{{ $jenis->merek }}" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('jenis.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar jenis
                    </a>
                </div>
            </div>
        </div>
        {{-- Modal Edit --}}
        <div class="modal fade" id="editModalJenis" tabindex="-1" aria-labelledby="modalJenisLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="formEditJenisModal">
                    @csrf
                    <input type="hidden" id="edit_id">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Jenis & Merek</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="editJenis" class="form-label">Jenis:</label>
                            <input type="text" class="form-control" id="editJenis" required>
                        </div>
                        <div class="modal-body">
                            <label for="editMerek" class="form-label">Merek:</label>
                            <input type="text" class="form-control" id="editMerek" required>
                        </div>
                        <div class="modal-body">
                            <button type="button" class="btn btn-sm btn-secondary mb-2" id="toggleKeteranganJenis">
                                Tambah Keterangan
                            </button>
                            <div id="wrapperKeteranganJenis" style="display: none;">
                                <label for="keteranganEditJenis" class="form-label">Keterangan:</label>
                                <input type="text" class="form-control" id="keteranganEditJenis">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" id="btnUpdateJenis">Edit</button>
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
            $('#toggleKeteranganJenis').click(function() {
                $('#wrapperKeteranganJenis').slideToggle();
            });
        });
        $(document).on('click', '.btn-edit-jenis', function() {
            const id = $(this).data('id');
            const jenis = $(this).data('jenis');
            const merek = $(this).data('merek');
            const keterangan = $(this).data('keterangan');

            $('#edit_id').val(id);
            $('#editJenis').val(jenis);
            $('#editMerek').val(merek);
            $('#keteranganEditJenis').val(keterangan);

            if (keterangan) {
                $('#wrapperKeteranganJenis').show();
            } else {
                $('#wrapperKeteranganJenis').hide();
            }
        });
        $('#btnUpdateJenis').on('click', function(e) {
            e.preventDefault();

            const id = $('#edit_id').val();
            const jenis = $('#editJenis').val();
            const merek = $('#editMerek').val();
            const keterangan = $('#keteranganEditJenis').val();

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
                        url: `/jenis/update/${id}`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'PUT',
                            jenis: jenis,
                            merek: merek,
                            keterangan: keterangan
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#editModalJenis').modal('hide');

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Data jenis & Merek berhasil diupdate.',
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
                                Swal.fire('Gagal!', 'Jenis atau Merek sudah ada.', 'warning');
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
                const merek = $(this).find('.btn-delete').data('merek');

                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: `Data Jenis "${nama}" & Merek "${merek}" akan dihapus!`,
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
