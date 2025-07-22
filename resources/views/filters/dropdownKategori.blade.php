<div class="dropdown d-inline me-2 mb-2">
    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
        Kategori
    </button>
    <ul class="dropdown-menu">
        @foreach ($kategoriList as $kategori)
            <li><a class="dropdown-item dropdown-check" href="#" data-filter="kategori" data-value="{{ $kategori->id }}">{{ $kategori->nama }}</a></li>
        @endforeach
    </ul>
</div>
