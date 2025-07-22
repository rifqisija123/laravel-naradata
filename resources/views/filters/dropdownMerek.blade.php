<div class="dropdown d-inline me-2 mb-2">
    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
        Merek
    </button>
    <ul class="dropdown-menu">
        @foreach ($merekList as $merek)
            <li><a class="dropdown-item dropdown-check" href="#" data-filter="merek" data-value="{{ $merek->id }}">{{ $merek->nama }}</a></li>
        @endforeach
    </ul>
</div>
