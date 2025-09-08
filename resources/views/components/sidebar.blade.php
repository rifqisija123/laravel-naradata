@include('icons.iconSidebar')
{{-- Dashboard --}}
<a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
    <i class="bi bi-house-door-fill me-2"></i> Dashboard
</a>

<a href="{{ route('kategori.index') }}" class="{{ request()->routeIs('kategori.index') ? 'active' : '' }}">
    <i class="fa-solid fa-layer-group me-2"></i> Kategori
</a>

<a href="{{ route('lokasi.index') }}" class="{{ request()->routeIs('lokasi.index') ? 'active' : '' }}">
    <i class="bi bi-geo-alt-fill me-2"></i> Ruangan
</a>

<a href="{{ route('karyawan.index') }}" class="{{ request()->routeIs('karyawan.index') ? 'active' : '' }}">
    <i class="fas fa-user me-2"></i> Karyawan
</a>

<a href="{{ route('jenis.index') }}" class="{{ request()->routeIs('jenis.index') ? 'active' : '' }}">
    <i class="fas fa-cubes me-2"></i> Jenis
</a>

<a href="{{ route('barang.index') }}" class="{{ request()->routeIs('barang.index') ? 'active' : '' }}">
    <i class="fas fa-box-open me-2"></i> Barang
</a>

<a href="{{ route('riwayat.index') }}" class="{{ request()->routeIs('riwayat.index') ? 'active' : '' }}">
    <i class="bi bi-clock-history me-2"></i> Riwayat
</a>

<a href="{{ route('riwayat.filter') }}" class="{{ request()->routeIs('riwayat.filter') ? 'active' : '' }}">
    <i class="bi bi-funnel-fill me-2"></i> Filter
</a>

<a href="{{ route('chat') }}" class="{{ request()->routeIs('chat') ? 'active' : '' }}">
    <i class="fa fa-comment me-2"></i> Chat
</a>

<a href="{{ route('logout') }}" id="logout-link">
    <i class="fas fa-sign-out me-2"></i> Logout
</a>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const logoutLink = document.getElementById('logout-link');

        logoutLink.addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin ingin Logout dari aplikasi?',
                icon: 'question',
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                backdrop: `
                    rgba(0.5, 0.5, 0.5, 0.5)
                    left top
                    no-repeat
                `,
                customClass: {
                    popup: 'custom-swal-popup'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Berhasil Logout!",
                        icon: "success",
                        timer: 1500,
                        showConfirmButton: false,
                        backdrop: `
                            rgba(0.5, 0.5, 0.5, 0.4)
                            left top
                            no-repeat
                        `,
                        customClass: {
                            popup: 'custom-swal-popup'
                        },
                        willClose: () => {
                            window.location.href = logoutLink.href;
                        }
                    });
                }
            });
        });
    });
</script>
