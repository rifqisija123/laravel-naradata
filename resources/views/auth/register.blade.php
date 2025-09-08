<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Aplikasi Gudang</title>

    <link rel="icon" href="{{ asset('assets/img/naradata.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }

        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(135deg, #cfd9df 0%, #e2ebf0 100%);
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 1rem;
            background-color: #fff;
            border-radius: 1rem;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            z-index: 1;
        }

        .logo {
            width: 50px;
            height: 70px;
            object-fit: contain;
            margin-bottom: 1rem;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #0d6efd;
        }

        .btn-primary {
            width: 100%;
        }

        .center-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
        }
    </style>
</head>

<body>
    <div id="particles-js"></div>

    <div class="center-wrapper">
        <div class="login-card text-center">
            <img src="{{ asset('assets/img/naradata.png') }}" alt="Logo" class="logo">
            <h5 class="mb-1 fw-bold">Register Akun</h5>
            <p class="text-muted mb-4" style="font-size: 14px;">Silakan buat akun baru Anda</p>

            {{--  @if ($errors->has('confirm_password'))
                <div class="alert alert-danger alert-dismissible fade show text-start" role="alert">
                    {{ $errors->first('confirm_password') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif ($errors->has('email'))
                <div class="alert alert-danger alert-dismissible fade show text-start" role="alert">
                    {{ $errors->first('email') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif  --}}

            <form method="POST" action="{{ route('register.action') }}">
                @csrf
                <div class="mb-3 text-start">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 text-start">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 text-start">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" id="password"
                            value="{{ old('password') }}" required>
                        <span class="input-group-text" onclick="togglePassword()">
                            <i class="bi bi-eye-slash" id="toggleIcon"></i>
                        </span>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4 text-start">
                    <label class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" name="confirm_password" class="form-control" id="confirm-password"
                            value="{{ old('confirm_password') }}" required>
                        <span class="input-group-text" onclick="toggleConfirmPassword()">
                            <i class="bi bi-eye-slash" id="toggleIconConfirm"></i>
                        </span>
                    </div>
                    @error('confirm_password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary" type="submit">Register</button>

                <p class="mt-3 mb-0 text-muted" style="font-size: 14px;">
                    Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
                </p>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        }

        function toggleConfirmPassword() {
            const confirmPasswordInput = document.getElementById('confirm-password');
            const iconConfirm = document.getElementById('toggleIconConfirm');
            const isConfirmPassword = confirmPasswordInput.type === 'password';
            confirmPasswordInput.type = isConfirmPassword ? 'text' : 'password';
            iconConfirm.classList.toggle('bi-eye');
            iconConfirm.classList.toggle('bi-eye-slash');
        }
    </script>

    <script>
        particlesJS("particles-js", {
            "particles": {
                "number": {
                    "value": 60,
                    "density": {
                        "enable": true,
                        "value_area": 800
                    }
                },
                "color": {
                    "value": "#007bff"
                },
                "shape": {
                    "type": "circle"
                },
                "opacity": {
                    "value": 0.3
                },
                "size": {
                    "value": 4
                },
                "move": {
                    "enable": true,
                    "speed": 2
                }
            },
            "interactivity": {
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "repulse"
                    }
                }
            },
            "retina_detect": true
        });
    </script>
</body>

</html>
