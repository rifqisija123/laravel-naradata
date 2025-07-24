@extends('layouts.filterApps')

@section('title', 'Data Filter')

@section('content-filter')
    <div class="container-fluid mt-4 px-4">
        <div class=" mb-3">
            <h4 class="mb-0 fw-bold">Filter Riwayat</h4>
        </div>

        <hr>
        </hr>

        <div id="filter-summary" class="mb-3 text-center"></div>

        <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
            <div class="filter-card">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle"
                        data-bs-toggle="dropdown">Kategori</button>
                    <ul class="dropdown-menu">
                        @foreach ($kategoris as $kategori)
                            <li><a href="#" class="dropdown-item dropdown-check" data-filter="kategori"
                                    data-value="{{ $kategori->id }}">{{ $kategori->kategori }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle"
                        data-bs-toggle="dropdown">Ruangan</button>
                    <ul class="dropdown-menu">
                        @foreach ($lokasis as $lokasi)
                            <li><a href="#" class="dropdown-item dropdown-check" data-filter="lokasi"
                                    data-value="{{ $lokasi->id }}">{{ $lokasi->posisi }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle"
                        data-bs-toggle="dropdown">Karyawan</button>
                    <ul class="dropdown-menu">
                        @foreach ($karyawans as $karyawan)
                            <li><a href="#" class="dropdown-item dropdown-check" data-filter="karyawan"
                                    data-value="{{ $karyawan->id }}">{{ $karyawan->nama }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle"
                        data-bs-toggle="dropdown">Jenis</button>
                    <ul class="dropdown-menu">
                        @foreach ($jenisBarang->unique('jenis') as $jenis)
                            <li><a href="#" class="dropdown-item dropdown-check" data-filter="jenis_nama"
                                    data-value="{{ $jenis->jenis }}">{{ $jenis->jenis }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle"
                        data-bs-toggle="dropdown">Merek</button>
                    <ul class="dropdown-menu">
                        @foreach ($jenisBarang->unique('merek_id') as $jenis)
                            <li><a href="#" class="dropdown-item dropdown-check" data-filter="merek"
                                    data-value="{{ $jenis->merek_id }}">{{ $jenis->merek }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle"
                        data-bs-toggle="dropdown">Kelengkapan</button>
                    <ul class="dropdown-menu">
                        <li><a href="#" class="dropdown-item dropdown-check" data-filter="kelengkapan"
                                data-value="1">Lengkap</a></li>
                        <li><a href="#" class="dropdown-item dropdown-check" data-filter="kelengkapan"
                                data-value="0">Tidak Lengkap</a></li>
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle"
                        data-bs-toggle="dropdown">Status</button>
                    <ul class="dropdown-menu">
                        <li><a href="#" class="dropdown-item dropdown-check" data-filter="status"
                                data-value="1">Dipakai</a></li>
                        <li><a href="#" class="dropdown-item dropdown-check" data-filter="status" data-value="0">Tidak
                                Dipakai</a></li>
                    </ul>
                </div>

                <div class="d-inline-flex align-items-center gap-2">
                    <input type="date" id="tanggal-filter" class="form-control form-control-sm"
                        placeholder="Pilih Tanggal">
                    <button id="resetFilterBtn" class="btn btn-outline-danger btn-sm">Reset</button>
                </div>
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
                    if (Array.isArray(chosen[key])) {
                        chosen[key].forEach(value => params.append(`${key}[]`, value));
                    } else {
                        params.append(key, chosen[key]);
                    }
                }

                fetch(`/riwayat/filter/result?${params.toString()}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.length === 0) {
                            resultContainer.innerHTML =
                                `<div class="alert alert-warning text-center">Tidak ada hasil ditemukan.</div>`;
                            return;
                        }

                        let html = `
            <div class="table-responsive">
                <table class="table table-bordered table-sm align-middle" id="tbl_filter_result">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Ruangan</th>
                            <th>Karyawan</th>
                            <th>Jenis</th>
                            <th>Merek</th>
                            <th>Kelengkapan</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>`;

                        data.forEach(item => {
                            html += `
                <tr>
                    <td>${item.nama_barang}</td>
                    <td>${item.kategori}</td>
                    <td>${item.lokasi}</td>
                    <td>${item.karyawan}</td>
                    <td>${item.jenis}</td>
                    <td>${item.merek}</td>
                    <td>${item.kelengkapan}</td>
                    <td>${item.status}</td>
                    <td>${item.tanggal}</td>
                </tr>`;
                        });

                        html += `</tbody></table></div>`;
                        resultContainer.innerHTML = html;

                        // 🔁 Hapus dulu kalau sebelumnya udah pernah diinit
                        if ($.fn.DataTable.isDataTable('#tbl_filter_result')) {
                            $('#tbl_filter_result').DataTable().destroy();
                        }

                        // ✅ Inisialisasi DataTables di sini (DOM udah siap)
                        $('#tbl_filter_result').DataTable({
                            dom: "<'row mb-2'<'col-sm-6'l><'col-sm-6 text-end'f>>" +
                                "<'row'<'col-sm-12'tr>>" +
                                "<'row mt-2'<'col-sm-6'i><'col-sm-6'p>>",
                            pagingType: 'simple_numbers',
                            language: {
                                lengthMenu: 'Tampilkan _MENU_ entri',
                                paginate: {
                                    previous: '<button class="btn btn-sm me-1">Sebelumnya</button>',
                                    next: '<button class="btn btn-sm ms-1">Selanjutnya</button>'
                                },
                                search: "Cari:",
                                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                                infoEmpty: "Tidak ada data tersedia",
                                emptyTable: "Tidak ada data di tabel",
                            }
                        });
                    });
            }

            function renderSummary() {
                summary.innerHTML = '';
                if (Object.keys(chosen).length === 0) {
                    resultContainer.innerHTML =
                        `<div class="text-center text-muted">Silakan pilih filter di atas</div>`;
                    fetchFilteredResults();
                    return;
                }

                summary.innerHTML = Object.entries(chosen)
                    .flatMap(([key, values]) => {
                        const labelMap = {
                            kategori: 'Kategori',
                            jenis_nama: 'Jenis',
                            jenis: 'Jenis',
                            lokasi: 'Ruangan',
                            kelengkapan: 'Kelengkapan',
                            karyawan: 'Karyawan',
                            merek: 'Merek',
                            status: 'Status',
                            tanggal: 'Tanggal',
                        };

                        if (!Array.isArray(values)) values = [values];
                        return values.map((value, index) => {
                            let label = labels[key][index] || value;

                            if (key === 'kelengkapan') label = value === '1' ? 'Lengkap' :
                                'Tidak Lengkap';
                            if (key === 'status') label = value === '1' ? 'Dipakai' : 'Tidak Dipakai';

                            return `<span class="badge bg-light text-dark me-1">${labelMap[key]}: ${label} <button class="btn btn-sm btn-close ms-1 remove-filter" data-filter="${key}" data-value="${value}" aria-label="Close"></button></span>`;
                        });
                    }).join('');

                fetchFilteredResults();

                document.querySelectorAll('.remove-filter').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        const key = e.target.dataset.filter;
                        const value = e.target.dataset.value;

                        if (Array.isArray(chosen[key])) {
                            const index = chosen[key].indexOf(value);
                            if (index > -1) {
                                chosen[key].splice(index, 1);
                                labels[key].splice(index, 1);
                            }
                            if (chosen[key].length === 0) {
                                delete chosen[key];
                                delete labels[key];
                            }
                        } else {
                            delete chosen[key];
                            delete labels[key];
                        }

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

                    if (!chosen[filterKey]) {
                        chosen[filterKey] = [];
                        labels[filterKey] = [];
                    }

                    if (!chosen[filterKey].includes(filterValue)) {
                        chosen[filterKey].push(filterValue);
                        labels[filterKey].push(filterLabel);
                    }

                    renderSummary();
                });
            });

            const tanggalInput = document.getElementById('tanggal-filter');
            tanggalInput.addEventListener('change', () => {
                if (tanggalInput.value) {
                    chosen['tanggal'] = tanggalInput.value;
                    labels['tanggal'] = tanggalInput.value;
                } else {
                    delete chosen['tanggal'];
                    delete labels['tanggal'];
                }
                renderSummary();
            });

            fetchFilteredResults();

            document.getElementById('resetFilterBtn').addEventListener('click', () => {
                for (let key in chosen) {
                    delete chosen[key];
                    delete labels[key];
                }

                // Reset input tanggal juga
                document.getElementById('tanggal-filter').value = '';

                // Tampilkan ulang hasil tanpa filter
                renderSummary();
            });
        });
        document.getElementById('customSearch').addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            const rows = document.querySelectorAll('#tbl_filter_result tbody tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const matches = Array.from(cells).some(cell =>
                    cell.textContent.toLowerCase().includes(query)
                );

                row.style.display = matches ? '' : 'none';
            });
        });
    </script>
@endpush
