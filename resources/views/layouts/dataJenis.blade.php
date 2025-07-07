@extends('layouts.apps')

@section('title', 'Data Jenis')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 fw-semibold">Daftar Jenis</h5>
        </div>

        {{-- Tabel --}}
        <div class="card shadow-sm border-1 rounded-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="tbl_jenis">
                        <thead class="table-light">
                            <tr>
                                <th>Jenis</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jenisBarang as $jenis)
                                <tr>
                                    <td>{{ $jenis->jenis }}</td>
                                    <td>{{ $jenis->keterangan ?? 'Tidak ada keterangan' }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('jenis.show', $jenis->id) }}" class="btn btn-sm btn-primary"
                                                title="Lihat">
                                                <i class="fas fa-eye"></i> Show
                                            </a>
                                            <button type="button" class="btn btn-warning btn-sm btn-edit-jenis"
                                                title="Edit" data-id="{{ $jenis->id }}"
                                                data-jenis="{{ $jenis->jenis }}" data-keterangan="{{ $jenis->keterangan }}"
                                                data-bs-toggle="modal" data-bs-target="#editModalJenis"><i
                                                    class="fas fa-pen"></i> Edit</button>
                                            <form action="{{ route('jenis.destroy', $jenis->id) }}" method="POST" class="form-delete d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger btn-delete" data-nama="{{ $jenis->jenis }}" title="Hapus">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada data Jenis</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{-- Modal Edit --}}
                    <div class="modal fade" id="editModalJenis" tabindex="-1" aria-labelledby="modalJenisLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <form id="formEditJenisModal">
                                @csrf
                                <input type="hidden" id="edit_id">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Jenis</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label for="editJenis" class="form-label">Jenis:</label>
                                        <input type="text" class="form-control" id="editJenis" required>
                                    </div>
                                    <div class="modal-body">
                                        <button type="button" class="btn btn-sm btn-secondary mb-2"
                                            id="toggleKeteranganJenis">
                                            Tambah Keterangan
                                        </button>
                                        <div id="wrapperKeteranganJenis" style="display: none;">
                                            <label for="keteranganEditJenis" class="form-label">Keterangan:</label>
                                            <input type="text" class="form-control" id="keteranganEditJenis">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary" id="btnUpdateJenis">Edit</button>
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
            const table = $('#tbl_jenis').DataTable({
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
            $('#toggleKeteranganJenis').click(function() {
                $('#wrapperKeteranganJenis').slideToggle();
            });
        });
        $(document).on('click', '.btn-edit-jenis', function() {
            const id = $(this).data('id');
            const jenis = $(this).data('jenis');
            const keterangan = $(this).data('keterangan');

            $('#edit_id').val(id);
            $('#editJenis').val(jenis);
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
                            keterangan: keterangan
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#editModalJenis').modal('hide');

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Data jenis berhasil diupdate.',
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
                                Swal.fire('Gagal!', 'Jenis sudah ada.', 'warning');
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
                    text: `Data Jenis "${nama}" akan dihapus!`,
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
