@extends('layouts.apps')

@section('title', 'Data Lokasi')

@section('content-card')
    @include('icons.iconCardLokasi')
    <h4 class="fw-bold mb-4">Data Lokasi</h4>
    <div class="row justify-content-center g-5">
        <div class="col-lg-3-5 col-md-4 col-sm-6 col-12 custom-card">
            <div class="stat-box p-3 rounded-3 h-100 d-flex align-items-center gap-3">
                <div class="icon-box">
                    <i class="bi bi-geo-alt-fill fs-3"></i>
                </div>
                <div>
                    <small>Total Ruangan</small>
                    <h6 class="fw-bold m-0">{{ $totalLokasi }}</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3-5 col-md-4 col-sm-6 col-12 custom-card">
            <div class="stat-box p-3 rounded-3 h-100 d-flex align-items-center gap-3">
                <div class="icon-box">
                    <i class="bi bi-dash-circle fs-3"></i>
                </div>
                <div>
                    <small>Ruangan Kosong</small>
                    @if (count($lokasiKosong) > 0)
                        @foreach ($lokasiKosong as $posisi)
                            <h6 class="fw-bold m-0">{{ $posisi }}</h6>
                        @endforeach
                    @else
                        <h6 class="fw-bold m-0">Tidak ada</h6>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-3-5 col-md-4 col-sm-6 col-12 custom-card">
            <div class="stat-box p-3 rounded-3 h-100 d-flex align-items-center gap-3">
                <div class="icon-box">
                    <i class="bi bi-grid-fill fs-3"></i>
                </div>
                <div>
                    <small>Ruangan Padat</small>
                    <h6 class="fw-bold m-0">{{ $lokasiPadat ? $lokasiPadat->posisi . ' (' . $lokasiPadat->barangs_count . ')' : 'Tidak ada' }}</h6>
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
            <h5 class="mb-0 fw-semibold">Daftar Ruangan</h5>
            <div>
                <a href="{{ route('lokasi.import') }}" class="btn btn-success me-2"><i class="fas fa-file-excel me-1"></i>
                    Import Excel</a>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="card shadow-sm border-1 rounded-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="tbl_lokasi">
                        <thead class="table-light">
                            <tr>
                                <th>Posisi</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lokasis as $lokasi)
                                <tr>
                                    <td>{{ $lokasi->posisi }}</td>
                                    <td>{{ $lokasi->keterangan ?? 'Tidak ada keterangan' }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('lokasi.show', $lokasi->id) }}" class="btn btn-sm btn-primary"
                                                title="Lihat">
                                                <i class="fas fa-eye"></i> Show
                                            </a>
                                            <button type="button" class="btn btn-warning btn-sm btn-edit-lokasi"
                                                title="Edit" data-id="{{ $lokasi->id }}"
                                                data-lokasi="{{ $lokasi->posisi }}"
                                                data-keterangan="{{ $lokasi->keterangan }}" data-bs-toggle="modal"
                                                data-bs-target="#editModalLokasi"><i class="fas fa-pen"></i> Edit</button>
                                            <form action="{{ route('lokasi.destroy', $lokasi->id) }}" method="POST"
                                                class="form-delete d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger btn-delete"
                                                    data-nama="{{ $lokasi->posisi }}" title="Hapus">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada data Lokasi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{-- Modal Edit --}}
                    <div class="modal fade" id="editModalLokasi" tabindex="-1" aria-labelledby="modalLokasiLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <form id="formEditLokasiModal">
                                @csrf
                                <input type="hidden" id="edit_id">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Ruangan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label for="editLokasi" class="form-label">Posisi:</label>
                                        <input type="text" class="form-control" id="editLokasi" required>
                                    </div>
                                    <div class="modal-body">
                                        <button type="button" class="btn btn-sm btn-secondary mb-2"
                                            id="toggleKeteranganLokasi">
                                            Tambah Keterangan
                                        </button>
                                        <div id="wrapperKeteranganLokasi" style="display: none;">
                                            <label for="keteranganEditLokasi" class="form-label">Keterangan:</label>
                                            <input type="text" class="form-control" id="keteranganEditLokasi">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary" id="btnUpdateLokasi">Edit</button>
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
            const table = $('#tbl_lokasi').DataTable({
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
                    text: `Data Ruangan "${nama}" akan dihapus!`,
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
        @elseif(session('success_excel'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success_excel') }}',
                showConfirmButton: false,
                timer: 1500
            });
        @endif
    </script>
@endpush
