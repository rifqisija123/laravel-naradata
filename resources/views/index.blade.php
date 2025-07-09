@extends('layouts.apps')

@section('title', 'Home')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-3 fw-semibold">Dashboard</h2>
        </div>
        <div class="dashboard-card p-4 rounded-4 shadow-sm text-white">
            <h4 class="fw-bold mb-4">Data Barang</h4>
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
                            <h6 class="fw-bold m-0">{{ $barangLengkap }}</h6>
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
                            <h6 class="fw-bold m-0">{{ $barangTidakLengkap }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Styling --}}
    <style>
        :root {
            --primary-blue: #0d47a1;
            --primary-green: #00897b;
            --primary-gradient: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-green) 100%);
        }

        .dashboard-card {
            background: var(--primary-gradient);
        }

        .stat-box {
            background-color: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(2px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .stat-box:hover {
            background-color: rgba(255, 255, 255, 0.12);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .stat-box h6 {
            font-size: 1rem;
        }

        .icon-box {
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }

        .custom-card {
            max-width: 310px;
        }

        @media (max-width: 768px) {
            .stat-box {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .icon-box {
                width: 36px;
                height: 36px;
                font-size: 1.1rem;
            }

            .stat-box h6 {
                font-size: 0.95rem;
            }

            .custom-card {
                max-width: 100%;
            }
        }
    </style>
@endsection
   