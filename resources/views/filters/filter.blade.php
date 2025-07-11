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
                                        data-value="{{ $jenis->merek_id }}">{{ $jenis->jenis }} - {{ $jenis->merek }}</a>
                                </li>
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
        <div id="result-container" class="mt-4">
            <div class="text-center text-muted">Silakan pilih filter di atas</div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const chosen = {};
            const labels = {};
            const summary = document.getElementById('filter-summary');
            const resultContainer = document.getElementById('result-container');

            function fetchFilteredResults() {
                const params = new URLSearchParams();
                for (let key in chosen) {
                    params.append(key, chosen[key]);
                }

                fetch(`/riwayat/filter/result?${params.toString()}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.length === 0) {
                            resultContainer.innerHTML =
                                `<div class="alert alert-warning text-center">Tidak ada hasil ditemukan.</div>`;
                            return;
                        }

                        let html = '<div class="list-group">';
                        data.forEach(item => {
                            html += `
                        <div class="list-group-item py-2">
                            <div class="fw-bold" style="color: #0d47a1;">${item.nama_barang}</div>
                            <small class="text-muted"><i class="fas fa-id-badge me-1"></i>${item.id}</small>
                        </div>`;
                        });
                        html += '</div>';
                        resultContainer.innerHTML = html;
                    });
            }

            function renderSummary() {
                if (Object.keys(chosen).length === 0) {
                    summary.innerHTML = '';
                    resultContainer.innerHTML =
                        `<div class="text-center text-muted">Silakan pilih filter di atas</div>`;
                    return;
                }

                summary.innerHTML = Object.entries(chosen)
                    .map(([key, value]) => {
                        let label = labels[key] || value;
                        if (key === 'kelengkapan') {
                            label = value === '1' ? 'Lengkap' : 'Tidak Lengkap';
                        }

                        const labelMap = {
                            kategori: 'Kategori',
                            jenis: 'Jenis & Merek',
                            lokasi: 'Lokasi',
                            kelengkapan: 'Kelengkapan',
                            karyawan: 'Karyawan'
                        };

                        return `
                <span class="badge bg-light text-dark me-1">
                    ${labelMap[key]}: ${label}
                    <button class="btn btn-sm btn-close ms-1 remove-filter" data-filter="${key}" aria-label="Close"></button>
                </span>`;
                    })
                    .join('');

                fetchFilteredResults();

                document.querySelectorAll('.remove-filter').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        const key = e.target.dataset.filter;
                        delete chosen[key];
                        delete labels[key];
                        renderSummary();
                    });
                });
            }

            document.querySelectorAll('.dropdown-check').forEach(el => {
                el.addEventListener('click', (e) => {
                    e.preventDefault();
                    const filterKey = e.target.dataset.filter;
                    const filterValue = e.target.dataset.value;
                    const filterLabel = e.target.textContent.trim();

                    chosen[filterKey] = filterValue;
                    labels[filterKey] = filterLabel;

                    renderSummary();
                });
            });
        });

        // Dropdown hover tetap seperti sebelumnya
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
