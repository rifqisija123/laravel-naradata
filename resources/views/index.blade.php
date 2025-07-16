@extends('layouts.apps')

@section('title', 'Home')

@section('content-card')
    <h4 class="fw-bold mb-4">Dashboard</h4>
    <div class="row justify-content-center g-5">
        <div class="col-lg-3-5 col-md-4 col-sm-6 col-12 custom-card">
            <div class="stat-box p-3 rounded-3 h-100 d-flex align-items-center gap-3">
                <div class="icon-box">
                    <i class="bi bi-box-seam fs-3"></i>
                </div>
                <div>
                    <small>Total Barang</small>
                    <h6 class="fw-bold m-0">{{ $totalBarang }}</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3-5 col-md-4 col-sm-6 col-12 custom-card">
            <div class="stat-box p-3 rounded-3 h-100 d-flex align-items-center gap-3">
                <div class="icon-box">
                    <i class="bi bi-check-circle fs-3"></i>
                </div>
                <div>
                    <small>Total Barang Lengkap</small>
                    <h6 class="fw-bold m-0">{{ $barangLengkap }} ({{ $persenLengkap }}%) dari total barang</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-3-5 col-md-4 col-sm-6 col-12 custom-card">
            <div class="stat-box p-3 rounded-3 h-100 d-flex align-items-center gap-3">
                <div class="icon-box">
                    <i class="bi bi-x-circle fs-3"></i>
                </div>
                <div>
                    <small>Total Barang Tidak Lengkap</small>
                    <h6 class="fw-bold m-0">{{ $barangTidakLengkap }} ({{ $persenTidakLengkap }}%) dari total barang</h6>
                </div>
            </div>
        </div>
    </div>
@endsection