<div class="dropdown d-inline me-2 mb-2">
    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
        Ruangan
    </button>
    <ul class="dropdown-menu">
        @foreach ($lokasiList as $lokasi)
            <li><a class="dropdown-item dropdown-check" href="#" data-filter="lokasi" data-value="{{ $lokasi->id }}">{{ $lokasi->nama }}</a></li>
        @endforeach
    </ul>
</div>
