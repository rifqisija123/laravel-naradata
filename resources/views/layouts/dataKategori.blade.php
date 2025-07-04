@extends('layouts.apps')

@section('title', 'Data Kategori')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 fw-semibold">Daftar Kategori</h5>
        </div>

        {{-- Tabel --}}
        <div class="card shadow-sm border-1 rounded-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="tbl_kategori">
                        <thead class="table-light">
                            <tr>
                                <th>Kategori</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kategoris as $kategori)
                                <tr>
                                    <td>{{ $kategori->kategori }}</td>
                                    <td>{{ $kategori->keterangan ?? 'Tidak ada keterangan' }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('kategori.show', $kategori->id) }}"
                                                class="btn btn-sm btn-primary" title="Lihat">
                                                <i class="fas fa-eye"></i> Show
                                            </a>
                                            <button type="button" class="btn btn-warning btn-sm btn-edit-kategori"
                                                title="Edit" data-id="{{ $kategori->id }}"
                                                data-kategori="{{ $kategori->kategori }}"
                                                data-keterangan="{{ $kategori->keterangan }}" data-bs-toggle="modal"
                                                data-bs-target="#editModalKategori"><i class="fas fa-pen"></i> Edit</button>
                                            <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST"
                                                class="form-delete d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger btn-delete"
                                                    data-nama="{{ $kategori->kategori }}" title="Hapus">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada data Kategori</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
                                        <button type="button" class="btn btn-sm btn-secondary mb-2"
                                            id="toggleKeteranganKategori">
                                            Tambah Keterangan
                                        </button>
                                        <div id="wrapperKeteranganKategori" style="display: none;">
                                            <label for="keteranganEditKategori" class="form-label">Keterangan:</label>
                                            <input type="text" class="form-control" id="keteranganEditKategori">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary" id="btnUpdateKategori">Edit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const table = $('#tbl_kategori').DataTable({
                dom: 'lfrtip',
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
