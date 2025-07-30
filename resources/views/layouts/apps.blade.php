<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Aplikasi Gudang</title>

    <link rel="icon" href="{{ asset('assets/img/naradata.png') }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- DataTables + Buttons -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/styles/style.css') }}">

    <!-- Tom Select -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- Apex Charts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.41.0/dist/apexcharts.css">
</head>

<body>
    @include('sweetalert2::index')

    {{-- Overlay --}}
    <div id="overlay"></div>

    {{-- Navbar --}}
    <nav class="navbar navbar-dark fixed-top px-3"
        style="background: linear-gradient(135deg, #0d47a1 0%, #00897b 100%); height: 55px;">
        <button class="hamburger-btn d-md-none" id="toggleSidebar">
            <i class="fas fa-bars"></i>
        </button>

        <a class="d-md-none mx-auto position-absolute start-50 translate-middle-x" href="{{ url('/') }}">
            <img src="{{ asset('assets/img/naradata.png') }}" alt="Logo" height="35">
        </a>

        <div class="d-none d-md-block text-center">
            <a class="navbar-brand text-white fw-semibold d-flex align-items-center justify-content-center gap-2"
                href="{{ url('/') }}">
                <img src="{{ asset('assets/img/naradata.png') }}" alt="Logo" height="38">
                <span class="fs-5 fw-semibold text-white">SIMAS</span>
            </a>
        </div>

        <div class="ms-auto d-flex align-items-center">
            <div class="dropdown">
                <a href="#" class="text-white text-decoration-none d-flex align-items-center gap-2"
                    data-bs-toggle="modal" data-bs-target="#profileModal" aria-expanded="false">
                    <i class="fas fa-user-circle fa-2x"></i>
                    <span class="d-none d-md-inline fw-semibold">{{ Auth::user()->name ?? 'User' }}</span>
                </a>
            </div>
        </div>

        <div class="navbar-decoration position-absolute w-100 h-100" style="pointer-events: none; z-index: 0;">
            <i class="fas fa-box icon-navbar" style="top: 15%; left: 5%;"></i>
            <i class="fas fa-couch icon-navbar" style="top: 40%; left: 30%;"></i>
            <i class="fas fa-desktop icon-navbar" style="top: 10%; left: 70%;"></i>
            <i class="fas fa-keyboard icon-navbar" style="top: 60%; left: 90%;"></i>
            <i class="fas fa-chair icon-navbar" style="top: 20%; left: 15%;"></i>
            <i class="fas fa-table icon-navbar" style="top: 35%; left: 50%;"></i>
            <i class="fas fa-tv icon-navbar" style="top: 5%; left: 80%;"></i>
            <i class="fas fa-mouse icon-navbar" style="top: 50%; left: 10%;"></i>
            <i class="fas fa-server icon-navbar" style="top: 65%; left: 25%;"></i>
            <i class="fas fa-boxes-stacked icon-navbar" style="top: 30%; left: 75%;"></i>
            <i class="fas fa-tools icon-navbar" style="top: 45%; left: 60%;"></i>
            <i class="fas fa-hdd icon-navbar" style="top: 12%; left: 40%;"></i>
            <i class="fas fa-plug icon-navbar" style="top: 70%; left: 85%;"></i>
            <i class="fas fa-warehouse icon-navbar" style="top: 22%; left: 92%;"></i>
            <i class="fas fa-screwdriver-wrench icon-navbar" style="top: 55%; left: 35%;"></i>
            <i class="fas fa-key icon-navbar" style="top: 10%; left: 20%;"></i>
            <i class="fas fa-laptop-code icon-navbar" style="top: 38%; left: 65%;"></i>
            <i class="fas fa-pallet icon-navbar" style="top: 66%; left: 45%;"></i>
        </div>
    </nav>

    <!-- Modal Profil Pengguna -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #0d47a1 0%, #00897b 100%);">
                    <h5 class="modal-title fw-bold" id="profileModalLabel">Profil Pengguna</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>Nama:</th>
                            <td>{{ Auth::user()->name }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ Auth::user()->email }}</td>
                        </tr>
                        <tr>
                            <th>Bergabung:</th>
                            <td>{{ \Carbon\Carbon::parse(Auth::user()->tanggal)->translatedFormat('d F Y') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer justify-content-between">
                    <a href="{{ route('edit.profile') }}" class="btn w-100 text-white fw-semibold"
                        style="background: linear-gradient(135deg, #0d47a1 0%, #00897b 100%);">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    @if (!Route::is('riwayat.filter*'))
        <div class="sidebar active" id="sidebar">
            @include('components.sidebar')
        </div>
    @endif

    {{-- Content Card Home --}}
    @if (Route::is('home'))
        <div class="container-fluid d-none d-md-block">
            <div class="content-card-home" id="main-content">
                @yield('content-card-home')
            </div>
        </div>

        <div class="container-fluid d-block d-md-none mt-5 pt-4">
            @yield('content-card-home')
        </div>
    @endif

    {{--  Content Card Dashboard  --}}
    @if (Route::is('dashboard'))
        <div class="container-fluid">
            <div class="content-card-dashboard" id="main-content">
                @yield('content-card-dashboard')
            </div>
        </div>
    @endif

    {{-- Content Card --}}
    @if (Route::is('edit.profile', 'kategori.index', 'lokasi.index', 'jenis.index', 'barang.index', 'riwayat.index'))
        <div class="container-fluid">
            <div class="content-card shadow-sm" id="main-content">
                @yield('content-card')
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    @if (Route::is('kategori.index', 'lokasi.index', 'jenis.index', 'barang.index', 'riwayat.index'))
        <div class="container-fluid">
            <div class="main-content-index" id="main-content">
                @yield('content-index')
            </div>
        </div>
    @endif

    @if (
        !Route::is(
            'edit.profile',
            'dashboard',
            'home',
            'kategori.index',
            'lokasi.index',
            'jenis.index',
            'barang.index',
            'riwayat.index'))
        <div class="container-fluid">
            <div class="main-content" id="main-content">
                @yield('content')
            </div>
        </div>
    @endif

    @if (Route::is('edit.profile'))
        <div class="container-fluid">
            <div class="main-content-profile" id="main-content">
                @yield('content-edit-profile')
            </div>
            <div class="main-content-profile" id="main-content">
                @yield('content-edit-password')
            </div>
        </div>
    @endif

    {{-- Scripts --}}
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="{{ asset('assets/scripts/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    @stack('scripts')
</body>

</html>
