{{-- Dashboard --}}
<a href="{{ route('dashboard') }}">
    <i class="bi bi-house-door-fill me-2"></i> Dashboard
</a>

<a href="{{ route('kategori.index') }}">
    <i class="fa-solid fa-layer-group me-2"></i> Kategori
</a>

<a href="{{ route('lokasi.index') }}">
    <i class="bi bi-geo-alt-fill me-2"></i> Ruangan
</a>

<a href="{{ route('karyawan.index') }}">
    <i class="fas fa-user me-2"></i> Karyawan
</a>

<a href="{{ route('jenis.index') }}">
    <i class="fas fa-cubes me-2"></i> Jenis
</a>

<a href="{{ route('barang.index') }}">
    <i class="fas fa-box-open me-2"></i> Barang
</a>

<a href="{{ route('riwayat.index') }}">
    <i class="bi bi-clock-history me-2"></i> Riwayat
</a>

<a href="{{ route('riwayat.filter') }}">
    <i class="bi bi-funnel-fill me-2"></i> Filter
</a>

<a href="{{ route('logout') }}">
    <i class="fas fa-sign-out me-2"></i> Logout
</a>
