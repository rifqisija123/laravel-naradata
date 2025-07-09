@extends('layouts.filterApps')

@section('title', 'Data Filter')

@section('content-filter')
    <div class="container mt-4 px-3">
        <div class="d-flex justify-content-center mb-3">
            <h5 class="mb-0 fw-semibold">Filter Barang</h5>
        </div>

        {{-- Ringkasan filter --}}
        <div id="filter-summary" class="mb-3 text-center"></div>

        <div class="filter-card">
            <div class="dropdown d-inline-block me-2">
                <button class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-sliders me-1"></i> Detail
                </button>
                <ul class="dropdown-menu">
                    <li class="dropdown-submenu">
                        <a href="" class="dropdown-item dropdown-toggle">Kategori</a>
                        <ul class="dropdown-menu">
                            @foreach ($kategoris as $kategori)
                                <li><a href="#" class="dropdown-item dropdown-check" data-filter="kategori"
                                        data-value="{{ $kategori->id }}">{{ $kategori->kategori }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a href="" class="dropdown-item dropdown-toggle">Jenis & Merek</a>
                        <ul class="dropdown-menu">
                            @foreach ($jenisBarang as $jenis)
                                <li><a href="#" class="dropdown-item dropdown-check" data-filter="jenis"
                                        data-value="{{ $jenis->merek_id }}">{{ $jenis->jenis }} - {{ $jenis->merek }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a href="" class="dropdown-item dropdown-toggle">Lokasi</a>
                        <ul class="dropdown-menu">
                            @foreach ($lokasis as $lokasi)
                                <li><a href="#" class="dropdown-item dropdown-check" data-filter="lokasi"
                                        data-value="{{ $lokasi->id }}">{{ $lokasi->posisi }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a href="" class="dropdown-item dropdown-toggle">Kelengkapan</a>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="dropdown-item dropdown-check" data-filter="kelengkapan"
                                    data-value="1">Lengkap</a></li>
                            <li><a href="#" class="dropdown-item dropdown-check" data-filter="kelengkapan"
                                    data-value="0">Tidak Lengkap</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="dropdown d-inline-block">
                <button class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fas fa-user me-1"></i> Karyawan
                </button>
                <ul class="dropdown-menu">
                    @foreach ($karyawans as $karyawan)
                        <li><a href="#" class="dropdown-item dropdown-check" data-filter="karyawan"
                                data-value="{{ $karyawan->id }}">{{ $karyawan->nama }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const summary = document.getElementById('filter-summary')
            const chosen = {}

            document.querySelectorAll('.dropdown-check').forEach(item => {
                item.addEventListener('click', e => {
                    e.preventDefault()
                    const el = e.currentTarget
                    const group = el.dataset.filter
                    const label = el.textContent.trim()

                    document.querySelectorAll(`[data-filter="${group}"]`).forEach(a => a.classList
                        .remove('active'))
                    el.classList.add('active')
                    chosen[group] = label
                    renderSummary()
                })
            })

            function renderSummary() {
                summary.innerHTML = Object.entries(chosen)
                    .map(([k, v]) => `<span class="badge bg-light text-dark me-1">${k}: ${v}</span>`)
                    .join('')
            }
        });
        document.querySelectorAll('.dropdown-submenu > a').forEach(function(element) {
            element.addEventListener('mouseover', function(e) {
                let nextEl = element.nextElementSibling;
                if (nextEl && nextEl.classList.contains('dropdown-menu')) {
                    nextEl.classList.add('show');
                }
            });
            element.parentElement.addEventListener('mouseleave', function(e) {
                let nextEl = element.nextElementSibling;
                if (nextEl && nextEl.classList.contains('dropdown-menu')) {
                    nextEl.classList.remove('show');
                }
            });
        });
    </script>
@endpush
