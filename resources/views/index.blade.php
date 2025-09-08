@extends('layouts.apps')

@section('title', 'Dashboard')

@section('content-card-dashboard')
    <h4 class="fw-bold mb-4">Dashboard</h4>

    {{--  Stats Cards  --}}
    <div class="row justify-content-center g-3 mb-4">
        <div class="col-lg-3 col-md-3 col-sm-6 col-12 custom-card-dahsboard">
            <div class="stat-box-dashboard p-3 rounded-3 h-100 d-flex align-items-center gap-3">
                <div class="icon-box-dashboard">
                    <i class="bi bi-box-seam fs-3"></i>
                </div>
                <div>
                    <small>Total Barang</small>
                    <h6 class="fw-bold m-0">{{ $totalBarang }}</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-12 custom-card-dahsboard">
            <div class="stat-box-dashboard p-3 rounded-3 h-100 d-flex align-items-center gap-3">
                <div class="icon-box-dashboard">
                    <i class="bi bi-check-circle fs-3"></i>
                </div>
                <div>
                    <small>Total Barang Lengkap</small>
                    <h6 class="fw-bold m-0">{{ $barangLengkap }} ({{ $persenLengkap }}%) dari total barang</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-12 custom-card-dahsboard">
            <div class="stat-box-dashboard p-3 rounded-3 h-100 d-flex align-items-center gap-3">
                <div class="icon-box-dashboard">
                    <i class="bi bi-x-circle fs-3"></i>
                </div>
                <div>
                    <small>Total Barang Tidak Lengkap</small>
                    <h6 class="fw-bold m-0">{{ $barangTidakLengkap }} ({{ $persenTidakLengkap }}%) dari total barang</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-12 custom-card-dahsboard">
            <div class="stat-box-dashboard p-3 rounded-3 h-100 d-flex align-items-center gap-3">
                <div class="icon-box-dashboard">
                    <i class="bi bi-geo-alt fs-3"></i>
                </div>
                <div>
                    <small>Ruangan Terbanyak</small>
                    <h6 class="fw-bold m-0">
                        {{ $lokasiTerbanyak ? $lokasiTerbanyak->posisi . ' (' . $lokasiTerbanyak->barangs_count . ' barang)' : 'Tidak ada' }}
                    </h6>
                </div>
            </div>
        </div>
    </div>

    {{--  Charts Section  --}}
    <div class="row g-4">
        {{--  Distribusi Barang per Kategori  --}}
        <div class="col-lg-6 col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0 fw-bold">Distribusi Barang per Kategori</h6>
                </div>
                @if($kategoriData->isEmpty())
                    <div class="card-body text-center">
                        <p class="text-muted">Tidak ada data distribusi kategori barang.</p>
                    </div>
                @elseif($kategoriData->count() > 0)
                    <div class="card-body">
                        <div id="chartKategori" style="height: 300px;"></div>
                    </div>
                @endif
            </div>
        </div>

        {{--  Status Kelengkapan Barang  --}}
        <div class="col-lg-6 col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0 fw-bold">Status Kelengkapan Barang</h6>
                </div>
                @if($barangLengkap === 0 && $barangTidakLengkap === 0)
                    <div class="card-body text-center">
                        <p class="text-muted">Tidak ada data kelengkapan barang.</p>
                    </div>
                @elseif($barangLengkap > 0 || $barangTidakLengkap > 0)
                    <div class="card-body">
                        <div id="chartKelengkapan" style="height: 300px;"></div>
                    </div>
                @endif
            </div>
        </div>

        {{--  Distribusi Barang per Lokasi  --}}
        <div class="col-lg-12 col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0 fw-bold">Distribusi Barang per Lokasi</h6>
                </div>
                @if($lokasiRelasi->isEmpty())
                    <div class="card-body text-center">
                        <p class="text-muted">Tidak ada data distribusi barang per lokasi.</p>
                    </div>
                @elseif($lokasiRelasi->count() > 0)
                    <div class="card-body">
                        <div id="chartLokasi" style="height: 300px;"></div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        @php
            $kategoriLabelsWithCount = $kategoriData->map(function ($item) {
                return $item->kategori . ' (' . $item->barangs_count . ' barang)';
            });
        @endphp

        const kategoriLabels = {!! json_encode($kategoriLabelsWithCount->toArray()) !!};
        const kategoriValues = {!! json_encode($kategoriData->pluck('barangs_count')->toArray()) !!};

        const lokasiLabels = {!! json_encode($lokasiRelasi->pluck('posisi')->toArray()) !!};
        const lokasiValues = {!! json_encode($lokasiRelasi->pluck('barangs_count')->toArray()) !!};

        const lengkap = {{ $barangLengkap }};
        const tidakLengkap = {{ $barangTidakLengkap }};
    </script>
    <script src="{{ asset('assets/scripts/apexcharts.js') }}"></script>
@endpush
