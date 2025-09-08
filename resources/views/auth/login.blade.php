<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Aplikasi Gudang</title>

    <link rel="icon" href="{{ asset('assets/img/naradata.png') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
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
            padding: 2rem;
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

        .input-group-text {
            background: transparent;
            border-left: none;
            cursor: pointer;
        }

        .input-group .form-control {
            border-right: none;
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

            <!-- Logo -->
            <img src="{{ asset('assets/img/naradata.png') }}" alt="Logo" class="logo">

            <!-- Title -->
            <h5 class="mb-1 fw-bold">SIMAS-App</h5>
            <p class="text-muted mb-4" style="font-size: 14px;">Masukkan email dan password Anda</p>

            @if (session('message'))
                <div class="alert alert-success alert-dismissible fade show text-start" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->has('login'))
                <div class="alert alert-danger alert-dismissible fade show text-start" role="alert">
                    {{ $errors->first('login') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login.action') }}">
                @csrf
                <div class="mb-3 text-start">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="mb-3 text-start">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group mb-2">
                        <input type="password" name="password" class="form-control" id="password" value="{{ old('password') }}" required>
                        <span class="input-group-text" onclick="togglePassword()">
                            <i class="bi bi-eye-slash" id="toggleIcon"></i>
                        </span>
                    </div>
                    <a href="{{ route('forgot.password') }}"
                        class="d-block text-end mt-1 text-primary text-decoration" style="font-size: 15px;">
                        Lupa password?
                    </a>
                </div>
                <button class="btn btn-primary" type="submit">Login</button>
            </form>
            <p class="mt-3 text-center">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-primary">Daftar di sini</a>
            </p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Particles.js -->
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
