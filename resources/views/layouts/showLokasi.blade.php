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
                        <form action="{{ route('lokasi.destroy', $lokasi->id) }}" method="POST"
                            onsubmit="return confirm('Yakin hapus data lokasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="Hapus" type="submit">
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
                            <button type="submit" class="btn btn-primary">Edit</button>
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
        $('#formEditLokasiModal').on('submit', function(e) {
            e.preventDefault();

            let id = $('#edit_id').val();
            let lokasi = $('#editLokasi').val();
            let keterangan = $('#keteranganEditLokasi').val();

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
                        location.reload();
                    } else {
                        alert('Gagal update data');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat update data.');
                }
            });
        });
    </script>
@endpush
