@extends('layouts.apps')

@section('title', 'Edit Barang')

@section('content')
    <div class="container mt-4">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Terjadi kesalahan!</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="card shadow-sm rounded-4">
            <div class="card-body px-4 py-4">
                <h3 class="fw-bold mb-3" style="color: #0d47a1;">Edit Barang</h3>
                <hr
                    style="height: 4px; border: none; background: linear-gradient(135deg, #0d47a1 0%, #00897b 100%); border-radius: 10px; margin-top: -10px;">
                <form method="POST" action="{{ route('barang.update', $barang->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label for="id" class="form-label">ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="id" id="id"
                                value="{{ old('id', $barang->id) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="namaBarang" class="form-label">Nama Barang <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="namaBarang" id="namaBarang"
                                value="{{ old('namaBarang', $barang->nama_barang) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="kategori_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-stretch">
                                <div class="flex-grow-1">
                                    <select name="kategori_id" id="kategori_id" class="tom-select w-100" required
                                        data-placeholder="-- Pilih Kategori --">
                                        <option value="" disabled selected hidden>-- Pilih Kategori --</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}"
                                                {{ $barang->kategori_id == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" class="btn btn-primary rounded-start-0" data-bs-toggle="modal"
                                    data-bs-target="#exampleModalKategori"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="jenis_id" class="form-label">Jenis & Merek <span
                                    class="text-danger">*</span></label>
                            <div class="d-flex align-items-stretch">
                                <div class="flex-grow-1">
                                    <select name="jenis_id" id="jenis_id" class="tom-select w-100" required
                                        data-placeholder="-- Pilih Jenis & Merek --">
                                        <option value="" disabled selected hidden>-- Pilih Jenis & Merek --</option>
                                        @foreach ($jenisBarang as $jenis)
                                            <option value="{{ $jenis->merek_id }}"
                                                {{ $barang->jenis_id == $jenis->merek_id ? 'selected' : '' }}>
                                                {{ $jenis->jenis }} - {{ $jenis->merek }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" class="btn btn-primary rounded-start-0" data-bs-toggle="modal"
                                    data-bs-target="#exampleModalJenis"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="lokasi_id" class="form-label">Ruangan <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-stretch">
                                <div class="flex-grow-1">
                                    <select name="lokasi_id" id="lokasi_id" class="tom-select w-100" required
                                        data-placeholder="-- Pilih Ruangan --">
                                        <option value="" disabled selected hidden>-- Pilih Ruangan --</option>
                                        @foreach ($lokasis as $lokasi)
                                            <option value="{{ $lokasi->id }}"
                                                {{ $barang->lokasi_id == $lokasi->id ? 'selected' : '' }}>
                                                {{ $lokasi->posisi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" class="btn btn-primary rounded-start-0" data-bs-toggle="modal"
                                    data-bs-target="#exampleModalLokasi"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label d-block">Kelengkapan <span class="text-danger">*</span></label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="kelengkapan" id="kelengkapan1"
                                    value="1" {{ $barang->kelengkapan == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="kelengkapan1">Lengkap</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="kelengkapan" id="kelengkapan0"
                                    value="0" {{ $barang->kelengkapan == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="kelengkapan0">Tidak Lengkap</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea id="keterangan" name="keterangan" class="form-control" rows="5">{{ old('keterangan', $barang->keterangan) }}</textarea>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end my-5">
                        <a href="{{ route('barang.index') }}" class="btn btn-secondary me-2">Kembali</a>
                        <button type="submit" class="btn btn-primary px-4" id="btnUpdate">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalKategori" tabindex="-1" aria-labelledby="modalKategoriLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="formKategoriModal">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="namaKategoriBaru" class="form-label">Kategori:</label>
                        <input type="text" class="form-control" name="kategori" id="namaKategoriBaru" required>
                    </div>
                    <div class="modal-body">
                        <button type="button" class="btn btn-sm btn-secondary mb-2" id="toggleKeteranganKategori">Tambah
                            Keterangan</button>
                        <div id="wrapperKeteranganKategori" style="display: none;">
                            <label for="keterangan" class="form-label">Keterangan:</label>
                            <input type="text" class="form-control" name="keterangan" id="keteranganKategori">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
<div class="modal fade" id="exampleModalJenis" tabindex="-1" aria-labelledby="modalJenisLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formJenisModal">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jenis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="namaJenisBaru" class="form-label">Jenis:</label>
                    <input type="text" class="form-control" name="jenis" id="namaJenisBaru" list="listJenis"
                        autocomplete="off" required>
                    <datalist id="listJenis">
                        @foreach ($jenisBarang as $j)
                            <option value="{{ $j->jenis }}"></option>
                        @endforeach
                    </datalist>
                </div>
                <div class="modal-body">
                    <label for="namaMerekBaru" class="form-label">Merek:</label>
                    <input type="text" class="form-control" name="merek" id="namaMerekBaru" required>
                </div>
                <div class="modal-body">
                    <button type="button" class="btn btn-sm btn-secondary mb-2" id="toggleKeteranganJenis">Tambah
                        Keterangan</button>
                    <div id="wrapperKeteranganJenis" style="display: none;">
                        <label for="keterangan" class="form-label">Keterangan:</label>
                        <input type="text" class="form-control" name="keterangan" id="keteranganJenis">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="exampleModalLokasi" tabindex="-1" aria-labelledby="modalLokasiLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form id="formLokasiModal">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Ruangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="namaPosisiBaru" class="form-label">Posisi:</label>
                    <input type="text" class="form-control" name="posisi" id="namaPosisiBaru" required>
                </div>
                <div class="modal-body">
                    <button type="button" class="btn btn-sm btn-secondary mb-2" id="toggleKeteranganLokasi">Tambah
                        Keterangan</button>
                    <div id="wrapperKeteranganLokasi" style="display: none;">
                        <label for="keterangan" class="form-label">Keterangan:</label>
                        <input type="text" class="form-control" name="keterangan" id="keteranganLokasi">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@push('scripts')
    @include('layouts.ajax')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectors = ['#kategori_id', '#jenis_id', '#lokasi_id'];

            selectors.forEach(selector => {
                new TomSelect(selector, {
                    placeholder: document.querySelector(selector).dataset.placeholder,
                    allowEmptyOption: false,
                    create: false,
                    maxOptions: 500,
                    plugins: {
                        dropdown_input: {
                            inputClass: 'ts-custom-search'
                        }
                    },
                    render: {
                        option: function(data, escape) {
                            return `<div class="py-2 px-2">${escape(data.text)}</div>`;
                        },
                        item: function(data, escape) {
                            return `<div>${escape(data.text)}</div>`;
                        }
                    }
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const btnUpdate = document.getElementById('btnUpdate');
            const form = btnUpdate.closest('form');

            btnUpdate.addEventListener('click', function(e) {
                e.preventDefault(); // Mencegah submit form langsung

                Swal.fire({
                    title: "Yakin ingin menyimpan perubahan?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Simpan",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Tampilkan alert sukses singkat
                        Swal.fire({
                            title: "Disimpan!",
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });

                        // Submit form setelah sedikit delay agar alert terlihat
                        setTimeout(() => {
                            form.submit();
                        }, 1300);
                    } else if (result.isCancelled) {
                        Swal.fire("Perubahan tidak disimpan", "", "info");
                    }
                });
            });
        });
    </script>
@endpush
