@extends('layouts.apps')

@section('title', 'Data Jenis')

@section('content-card')
    <h4 class="fw-bold mb-4">Data Jenis</h4>
    <div class="row justify-content-center g-5">
        <div class="col-lg-3-5 col-md-4 col-sm-6 col-12 custom-card">
            <div class="stat-box p-3 rounded-3 h-100 d-flex align-items-center gap-3">
                <div class="icon-box">
                    <i class="fas fa-cubes fs-3"></i>
                </div>
                <div>
                    <small>Total Jenis</small>
                    <h6 class="fw-bold m-0">{{ $totalJenis }}</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3-5 col-md-4 col-sm-6 col-12 custom-card">
            <div class="stat-box p-3 rounded-3 h-100 d-flex align-items-center gap-3">
                <div class="icon-box">
                    <i class="fas fa-cubes fs-3"></i>
                </div>
                <div>
                    <small>Total Merek</small>
                    <h6 class="fw-bold m-0">{{ $totalMerek }}</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3-5 col-md-4 col-sm-6 col-12 custom-card">
            <div class="stat-box p-3 rounded-3 h-100 d-flex align-items-center gap-3">
                <div class="icon-box">
                    <i class="fas fa-align-left fs-3"></i>
                </div>
                <div>
                    <small>Jenis & Merek Tanpa Keterangan</small>
                    <h6 class="fw-bold m-0">{{ $jenisTanpaKeterangan }}</h6>
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
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 fw-semibold">Daftar Jenis & Merek</h5>
        </div>

        {{-- Tabel --}}
        <div class="card shadow-sm border-1 rounded-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="tbl_jenis">
                        <thead class="table-light">
                            <tr>
                                <th>Jenis</th>
                                <th>Merek</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jenisBarang as $jenis)
                                <tr>
                                    <td>{{ $jenis->jenis }}</td>
                                    <td>{{ $jenis->merek }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('jenis.show', $jenis->merek_id) }}" class="btn btn-sm btn-primary"
                                                title="Lihat">
                                                <i class="fas fa-eye"></i> Show
                                            </a>
                                            <button type="button" class="btn btn-warning btn-sm btn-edit-jenis"
                                                title="Edit" data-id="{{ $jenis->merek_id }}"
                                                data-jenis="{{ $jenis->jenis }}" data-merek="{{ $jenis->merek }}" data-keterangan="{{ $jenis->keterangan }}"
                                                data-bs-toggle="modal" data-bs-target="#editModalJenis"><i
                                                    class="fas fa-pen"></i> Edit</button>
                                            <form action="{{ route('jenis.destroy', $jenis->merek_id) }}" method="POST" class="form-delete d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger btn-delete" data-nama="{{ $jenis->jenis }}" data-merek="{{ $jenis->merek }}" title="Hapus">
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
                                    text: 'Data jenis & merek berhasil diupdate.',
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
