<div class="dropdown d-inline me-2 mb-2">
    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
        Karyawan
    </button>
    <ul class="dropdown-menu">
        @foreach ($karyawanList as $karyawan)
            <li><a class="dropdown-item dropdown-check" href="#" data-filter="karyawan" data-value="{{ $karyawan->id }}">{{ $karyawan->nama }}</a></li>
        @endforeach
    </ul>
</div>
