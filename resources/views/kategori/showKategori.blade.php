@extends('layouts.apps')

@section('title', 'Detail Kategori')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4"><i class="fas fa-layer-group me-2 text-primary"></i>Detail Kategori</h3>

        <div class="card shadow-sm rounded-4">
            <div class="card-body px-4 py-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i class="fas fa-id-badge me-2 text-secondary"></i><strong>ID:</strong></p>
                        <h5>{{ $kategori->id }}</h5>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i
                                class="fas fa-layer-group me-2 text-secondary"></i><strong>Kategori:</strong></p>
                        <h5>{{ $kategori->kategori }}</h5>
                    </div>
                    <div class="col-md-12">
                        <p class="mb-1 text-muted"><i
                                class="fas fa-align-left me-2 text-secondary"></i><strong>Keterangan:</strong></p>
                        <h5>{{ $kategori->keterangan ?? 'Tidak ada keterangan' }}</h5>
                    </div>
                    <hr class="my-3">
                    <div class="col-md-12 d-flex gap-2">
                        <button type="button" class="btn btn-warning btn-sm btn-edit-kategori" title="Edit"
                            data-id="{{ $kategori->id }}" data-kategori="{{ $kategori->kategori }}"
                            data-keterangan="{{ $kategori->keterangan }}" data-bs-toggle="modal"
                            data-bs-target="#editModalKategori"><i class="fas fa-pen"></i></button>
                        <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="form-delete d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger btn-delete" data-nama="{{ $kategori->kategori }}" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Kategori
                    </a>
                </div>
            </div>
        </div>
        {{-- Modal Edit --}}
        <div class="modal fade" id="editModalKategori" tabindex="-1" aria-labelledby="modalKategoriLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form id="formEditKategoriModal">
                    @csrf
                    <input type="hidden" id="edit_id">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Kategori</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="editKategori" class="form-label">Kategori:</label>
                            <input type="text" class="form-control" id="editKategori" required>
                        </div>
                        <div class="modal-body">
                            <button type="button" class="btn btn-sm btn-secondary mb-2" id="toggleKeteranganKategori">
                                Tambah Keterangan
                            </button>
                            <div id="wrapperKeteranganKategori" style="display: none;">
                                <label for="keteranganEditKategori" class="form-label">Keterangan:</label>
                                <input type="text" class="form-control" id="keteranganEditKategori">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" id="btnUpdateKategori">Edit</button>
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
            $('#toggleKeteranganKategori').click(function() {
                $('#wrapperKeteranganKategori').slideToggle();
            });
        });
        $(document).on('click', '.btn-edit-kategori', function() {
            const id = $(this).data('id');
            const kategori = $(this).data('kategori');
            const keterangan = $(this).data('keterangan');

            $('#edit_id').val(id);
            $('#editKategori').val(kategori);
            $('#keteranganEditKategori').val(keterangan);

            if (keterangan) {
                $('#wrapperKeteranganKategori').show();
            } else {
                $('#wrapperKeteranganKategori').hide();
            }
        });
        $('#btnUpdateKategori').on('click', function(e) {
            e.preventDefault();

            const id = $('#edit_id').val();
            const kategori = $('#editKategori').val();
            const keterangan = $('#keteranganEditKategori').val();

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
                        url: `/kategori/update/${id}`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'PUT',
                            kategori: kategori,
                            keterangan: keterangan
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#editModalKategori').modal('hide');

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Data kategori berhasil diupdate.',
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                // reload setelah swal ditutup
                                setTimeout(() => {
                                    location.reload();
                                }, 1600);
                            } else {
                                Swal.fire('Gagal!', response.message || 'Gagal update data.',
                                    'error');
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 409) {
                                Swal.fire('Gagal!', 'Kategori sudah ada.', 'warning');
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
                    text: `Data kategori "${nama}" akan dihapus!`,
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
    </script>
@endpush
