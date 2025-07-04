@extends('layouts.apps')

@section('title', 'Home')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-3 fw-semibold">Dashboard</h2>
        </div>
        <div class="dashboard-card p-4 rounded-4 shadow-sm text-white">
            <h3 class="mb-4 fw-bold">Data Barang</h3>
            <div class="row g-3">
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="stat-box p-3 rounded-3 h-100">
                        <small>Total Barang</small>
                        <h4 class="fw-bold m-0">{{ $totalBarang }}</h4>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="stat-box p-3 rounded-3 h-100">
                        <small>Total Barang Lengkap</small>
                        <h4 class="fw-bold m-0">{{ $barangLengkap }}</h4>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="stat-box p-3 rounded-3 h-100">
                        <small>Total Barang Tidak Lengkap</small>
                        <h4 class="fw-bold m-0">{{ $barangTidakLengkap }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection