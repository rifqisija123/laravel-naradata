@extends('layouts.apps')

@section('title', 'Edit Profile')

@section('content-card')
    @include('icons.iconCardProfile')
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
    <span style="color: #666; font-size: 90%;">Perbarui informasi profile akun Anda.</span>
    <hr>
    <div class="mt-4">
        @if (session('success_profile'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success_profile') }}
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
@section('content-edit-password')
    <div class="bg-white fw-bold mb-2" style="font-size: 120%;">
        Ubah Password
    </div>
    <span style="color: #666; font-size: 90%;">Perbarui password profile akun Anda.</span>
    <hr>
    <div class="mt-4">
        @if (session('success_password'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success_password') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <form method="POST" action="{{ route('profile.update.password') }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="passwordSaatIni" class="form-label">Password Saat Ini</label>
                <div class="input-group">
                    <input type="password" id="passwordSaatIni" name="passwordSaatIni"
                        class="form-control @error('passwordSaatIni') is-invalid @enderror"
                        value="{{ old('passwordSaatIni') }}"equired>
                    <span class="input-group-text" onclick="togglePasswordLama()">
                        <i class="bi bi-eye-slash" id="toggleIconLama"></i>
                    </span>
                    @error('passwordSaatIni')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password Baru</label>
                <div class="input-group">
                    <input type="password" id="password" name="password"
                        class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}"
                        required>
                    <span class="input-group-text" onclick="togglePassword()">
                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                    </span>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Konfirmasi Password</label>
                <div class="input-group">
                    <input type="password" id="confirmPassword" name="confirmPassword"
                        class="form-control @error('confirmPassword') is-invalid @enderror"
                        value="{{ old('confirmPassword') }}" required>
                    <span class="input-group-text" onclick="toggleConfirmPassword()">
                        <i class="bi bi-eye-slash" id="toggleIconConfirm"></i>
                    </span>
                    @error('confirmPassword')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-4" id="btnUpdatePassword">
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
                        Swal.fire({
                            title: "Disimpan!",
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });

                        setTimeout(() => {
                            form.submit();
                        }, 1300);
                    } else if (result.isCancelled) {
                        Swal.fire("Perubahan tidak disimpan", "", "info");
                    }
                });
            });
        });

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        }

        function toggleConfirmPassword() {
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const iconConfirm = document.getElementById('toggleIconConfirm');
            const isConfirmPassword = confirmPasswordInput.type === 'password';
            confirmPasswordInput.type = isConfirmPassword ? 'text' : 'password';
            iconConfirm.classList.toggle('bi-eye');
            iconConfirm.classList.toggle('bi-eye-slash');
        }

        function togglePasswordLama() {
            const PasswordLamaInput = document.getElementById('passwordSaatIni');
            const iconPassword = document.getElementById('toggleIconLama');
            const isPasswordLama = PasswordLamaInput.type === 'password';
            PasswordLamaInput.type = isPasswordLama ? 'text' : 'password';
            iconPassword.classList.toggle('bi-eye');
            iconPassword.classList.toggle('bi-eye-slash');
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnUpdatePassword = document.getElementById('btnUpdatePassword');
            const formPassword = btnUpdatePassword.closest('form');

            btnUpdatePassword.addEventListener('click', function(e) {
                e.preventDefault(); // Mencegah submit form langsung

                Swal.fire({
                    title: "Yakin ingin menyimpan perubahan?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Simpan",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Disimpan!",
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });

                        setTimeout(() => {
                            formPassword.submit();
                        }, 1300);
                    } else if (result.isCancelled) {
                        Swal.fire("Perubahan tidak disimpan", "", "info");
                    }
                });
            });
        });
    </script>
@endpush
