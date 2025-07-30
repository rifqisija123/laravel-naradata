@extends('layouts.apps')

@section('title', 'Create karyawan')

@section('content')
    <div class="container mt-4">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Terjadi kesalahan!</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="card shadow-sm rounded-4">
            <div class="card-body px-4 py-4">
                <h3 class="fw-bold mb-3" style="color: #0d47a1;">Tambah Karyawan</h3>
                <hr
                    style="height: 4px; border: none; background: linear-gradient(135deg, #0d47a1 0%, #00897b 100%); border-radius: 10px; margin-top: -10px;">
                <form method="POST" action="{{ route('karyawan.store') }}" id="formCreateKaryawan">
                    @csrf
                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label for="namaKaryawan" class="form-label">Nama Karyawan <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="namaKaryawan" id="namaKaryawan" required>
                        </div>
                        <div class="col-md-6">
                            <label for="jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="jabatan" id="jabatan" required>
                        </div>
                        <div class="col-md-12">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea id="keterangan" name="keterangan" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end my-5">
                        <a href="{{ route('karyawan.index') }}" class="btn btn-secondary me-2">Kembali</a>
                        <button type="submit" class="btn btn-primary px-4">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formCreateKaryawan');
            const namaInput = document.getElementById('namaKaryawan');
            const jabatanInput = document.getElementById('jabatan');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const nama = namaInput.value.trim();
                const jabatan = jabatanInput.value.trim();

                Swal.fire({
                    title: `Yakin ingin menambahkan karyawan ${nama} dengan jabatan ${jabatan}?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, tambahkan!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'custom-swal-popup'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Ditambahkan!",
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false,
                            customClass: {
                                popup: 'custom-swal-popup'
                            }
                        });
                        setTimeout(() => {
                            form.submit();
                        }, 1300);
                    }
                });
            });
        });
    </script>
@endpush
