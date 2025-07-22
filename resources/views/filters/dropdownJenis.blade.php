<div class="dropdown d-inline me-2 mb-2">
    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
        Jenis
    </button>
    <ul class="dropdown-menu">
        @foreach ($jenisList as $jenis)
            <li><a class="dropdown-item dropdown-check" href="#" data-filter="jenis" data-value="{{ $jenis->id }}">{{ $jenis->nama }}</a></li>
        @endforeach
    </ul>
</div>
