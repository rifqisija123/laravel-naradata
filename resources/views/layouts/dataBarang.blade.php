@extends('layouts.apps')

@section('title', 'Data Barang')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @elseif(session('success_delete'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success_delete') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @elseif(session('success_excel'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success_excel') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 fw-semibold">Daftar Barang</h5>
            <div>
                <a href="{{ route('barang.create') }}" class="btn btn-primary me-2"><i class="fas fa-plus me-1"></i> Tambah
                    Barang</a>
                <a href="{{ route('barang.import') }}" class="btn btn-success me-2"><i class="fas fa-file-excel me-1"></i>
                    Import Excel</a>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="card shadow-sm border-1 rounded-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="tbl_barang">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nama Barang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barangs as $barang)
                                <tr>
                                    <td>{{ $barang->id }}</td>
                                    <td>{{ $barang->nama_barang }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('barang.show', $barang->id) }}" class="btn btn-sm btn-primary"
                                                title="Lihat">
                                                <i class="fas fa-eye"></i> Show
                                            </a>
                                            <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-sm btn-warning"
                                                title="Edit">
                                                <i class="fas fa-pen"></i> Edit
                                            </a>
                                            <form action="{{ route('barang.destroy', $barang->id) }}" method="POST"
                                                class="form-delete d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger btn-delete"
                                                    data-nama="{{ $barang->nama_barang }}" title="Hapus">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data Barang</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const table = $('#tbl_barang').DataTable({
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

            $('#exportPdfBtn').on('click', function() {
                table.button('.buttons-pdf').trigger();
            });

            $('#exportExcelBtn').on('click', function() {
                table.button('.buttons-excel').trigger();
            });
        });
        $(document).ready(function() {
            $('.form-delete').on('submit', function(e) {
                e.preventDefault();

                const form = this;
                const nama = $(this).find('.btn-delete').data('nama');

                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: `Data barang "${nama}" akan dihapus!`,
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
