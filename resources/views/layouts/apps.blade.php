<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Aplikasi Gudang</title>

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
    </nav>

    {{-- Sidebar --}}
    @if (!Route::is('riwayat.filter*'))
        <div class="sidebar active" id="sidebar">
            @include('components.sidebar')
        </div>
    @endif

    {{-- Content Card Dashboard and Home --}}
    @if(Route::is( 'home'))
        <div class="container-fluid">
            <div class="content-card-dashboard" id="main-content">
                @yield('content-card-dashboard')
            </div>
        </div>
    @endif

    {{-- Content Card --}}
    @if(Route::is('dashboard', 'kategori.index', 'lokasi.index', 'jenis.index', 'barang.index', 'riwayat.index'))
        <div class="container-fluid">
            <div class="content-card" id="main-content">
                @yield('content-card')
            </div>
        </div>
    @endif
    
    {{-- Main Content --}}
    @if(Route::is('kategori.index', 'lokasi.index', 'jenis.index', 'barang.index', 'riwayat.index'))
        <div class="container-fluid">
            <div class="main-content-index" id="main-content">
                @yield('content-index')
            </div>
        </div>
    @endif

    @if(!Route::is('dashboard', 'home', 'kategori.index', 'lokasi.index', 'jenis.index', 'barang.index', 'riwayat.index'))
        <div class="container-fluid">
            <div class="main-content" id="main-content">
                @yield('content')
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

    @stack('scripts')
</body>

</html>
