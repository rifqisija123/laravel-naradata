@extends('layouts.apps')

@section('title', 'Detail Jenis')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4"><i class="fas fa-map-marker-alt me-2 text-primary"></i>Detail Jenis</h3>

        <div class="card shadow-sm rounded-4">
            <div class="card-body px-4 py-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i class="fas fa-id-badge me-2 text-secondary"></i><strong>ID:</strong></p>
                        <h5>{{ $jenis->id }}</h5>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1 text-muted"><i class="fas fa-cubes me-2 text-secondary"></i><strong>Jenis:</strong>
                        </p>
                        <h5>{{ $jenis->jenis }}</h5>
                    </div>
                    <div class="col-md-12">
                        <p class="mb-1 text-muted"><i
                                class="fas fa-align-left me-2 text-secondary"></i><strong>Keterangan:</strong></p>
                        <h5>{{ $jenis->keterangan ?? 'Tidak ada keterangan' }}</h5>
                    </div>
                    <hr class="my-3">
                    <div class="col-md-12 d-flex gap-2">
                        <button type="button" class="btn btn-warning btn-sm btn-edit-jenis" title="Edit"
                            data-id="{{ $jenis->id }}" data-jenis="{{ $jenis->jenis }}"
                            data-keterangan="{{ $jenis->keterangan }}" data-bs-toggle="modal"
                            data-bs-target="#editModalJenis"><i class="fas fa-pen"></i></button>
                        <form action="{{ route('jenis.destroy', $jenis->id) }}" method="POST"
                            onsubmit="return confirm('Yakin hapus data jenis ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="Hapus" type="submit">
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
                            <h5 class="modal-title">Edit Jenis</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label for="editJenis" class="form-label">Jenis:</label>
                            <input type="text" class="form-control" id="editJenis" required>
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
        $('#formEditJenisModal').on('submit', function(e) {
            e.preventDefault();

            let id = $('#edit_id').val();
            let jenis = $('#editJenis').val();
            let keterangan = $('#keteranganEditJenis').val();

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
