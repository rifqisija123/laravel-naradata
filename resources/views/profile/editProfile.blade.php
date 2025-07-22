@extends('layouts.apps')

@section('title', 'Edit Profile')

@section('content-card')
    <h4 class="fw-bold mb-4">Profile</h4>
    <div class="text-white d-flex align-items-center">
        <hr class="me-2" style="width: 3%; height: 3px; background-color: white; margin: 0; margin-right: 10px;" />
        <span style="font-size: 90%;">Edit Profile</span>
    </div>
@endsection

@section('content-edit-profile')
    <div class="bg-white fw-bold mb-2" style="font-size: 120%;">
        Informasi Profile
    </div>
    <span style="color: #666; font-size: 90%;">Perbarui informasi profil akun Anda.</span>
    <hr>
    <div class="mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', auth()->user()->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', auth()->user()->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-4" id="btnUpdate">
                Simpan Perubahan
            </button>
        </form>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnUpdate = document.getElementById('btnUpdate');
            const form = btnUpdate.closest('form');

            btnUpdate.addEventListener('click', function(e) {
                e.preventDefault(); // Mencegah submit form langsung

                Swal.fire({
                    title: "Yakin ingin menyimpan perubahan?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Simpan",
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
                    } else if (result.isCancelled) {
                        Swal.fire("Perubahan tidak disimpan", "", "info");
                    }
                });
            });
        });
    </script>
@endpush
