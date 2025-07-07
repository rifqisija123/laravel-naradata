@extends('layouts.apps')

@section('title', 'Edit Karyawan')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-body px-4 py-4">
                <h3 class="fw-bold mb-3" style="color: #0d47a1;">Edit Karyawan</h3>
                <hr
                    style="height: 4px; border: none; background: linear-gradient(135deg, #0d47a1 0%, #00897b 100%); border-radius: 10px; margin-top: -10px;">
                <form method="POST" action="{{ route('karyawan.update', $karyawan->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label for="namaKaryawan" class="form-label">Nama Barang <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="namaKaryawan" id="namaKaryawan"
                                value="{{ old('namaKaryawan', $karyawan->nama) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="jabatan" class="form-label">Nama Barang <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="jabatan" id="jabatan"
                                value="{{ old('jabatan', $karyawan->jabatan) }}" required>
                        </div>
                        <div class="col-md-12">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea id="keterangan" name="keterangan" class="form-control" rows="5">{{ old('keterangan', $karyawan->keterangan) }}</textarea>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end my-5">
                        <a href="{{ route('karyawan.index') }}" class="btn btn-secondary me-2">Kembali</a>
                        <button type="submit" class="btn btn-primary px-4" id="btnUpdate">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @include('layouts.ajax')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnUpdate = document.getElementById('btnUpdate');
            const form = btnUpdate.closest('form');

            btnUpdate.addEventListener('click', function(e) {
                e.preventDefault(); // Mencegah submit form langsung

                Swal.fire({
                    title: "Yakin ingin menyimpan perubahan?",
                    icon: "question",
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Simpan",
                    denyButtonText: `Jangan Simpan`,
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Tampilkan alert sukses singkat
                        Swal.fire({
                            title: "Disimpan!",
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });

                        // Submit form setelah sedikit delay agar alert terlihat
                        setTimeout(() => {
                            form.submit();
                        }, 1300);
                    } else if (result.isDenied) {
                        Swal.fire("Perubahan tidak disimpan", "", "info");
                    }
                });
            });
        });
    </script>
@endpush
