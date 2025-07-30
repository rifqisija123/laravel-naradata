@extends('importExcel')

@section('importExcel')
    <div class="container mt-4">
        <h4 class="mb-4 fw-semibold">Import Kategori</h4>

        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0"><i class="fa-solid fa-file-import me-2 text-primary"></i>Import Data Kategori</h5>
            </div>

            <div class="card-body row g-4">
                <!-- Petunjuk Import -->
                <div class="col-md-6">
                    <div class="p-3 border rounded bg-light">
                        <h6 class="fw-bold">Petunjuk Import</h6>
                        <ol class="ps-3">
                            <li>Download template Excel yang telah disediakan.</li>
                            <li>Isi data sesuai dengan format yang ada pada template.</li>
                            <li>Pastikan kolom dengan tanda <span class="text-danger">*</span> wajib diisi.</li>
                            <li>Simpan file Excel yang telah diisi.</li>
                            <li>Upload file Excel tersebut melalui form di samping.</li>
                            <li>Klik tombol "Import Kategori" untuk memulai proses import.</li>
                        </ol>
                        <a href="{{ asset('template/DataKategori.xlsx') }}" class="btn btn-outline-primary mt-2">
                            <i class="fa-solid fa-download me-1"></i>Download Template Excel
                        </a>
                    </div>
                </div>

                <!-- Upload File -->
                <div class="col-md-6">
                    <div class="p-3 border rounded bg-light">
                        <form method="POST" action="{{ route('import.kategori') }}" enctype="multipart/form-data"
                            id="formImport">
                            @csrf
                            <div class="mb-3">
                                <label for="file_excel" class="form-label fw-semibold">File Excel <span
                                        class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="file_excel" id="file_excel"
                                    accept=".xlsx,.xls" required>
                                <small class="text-muted">Format file: .xlsx atau .xls</small>
                            </div>
                            <button type="button" class="btn btn-primary w-100" id="btnImport"
                                style="background: linear-gradient(to right, #1e3c72, #2a5298);">
                                <i class="fa-solid fa-cloud-arrow-up me-1"></i>Import Kategori
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 d-flex justify-content-end my-5">
            <a href="{{ route('kategori.index') }}" class="btn btn-secondary mt-4">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
@endsection