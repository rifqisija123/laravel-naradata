@extends('layouts.apps')

@section('title', 'Edit Riwayat Pengembalian')

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
                <h3 class="fw-bold mb-3" style="color: #0d47a1;">Edit Riwayat Pengembalian</h3>
                <hr
                    style="height: 4px; border: none; background: linear-gradient(135deg, #0d47a1 0%, #00897b 100%); border-radius: 10px; margin-top: -10px;">
                <form method="POST" action="{{ route('riwayat.pengembalian.update', $riwayatPengembalian->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label for="karyawan_id" class="form-label">Karyawan <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-stretch">
                                <div class="flex-grow-1">
                                    <select name="karyawan_id" id="karyawan_id" class="tom-select w-100" required
                                        data-placeholder="-- Pilih Karyawan --">
                                        <option value="" disabled selected hidden>-- Pilih Karyawan --</option>
                                        @foreach ($karyawanPeminjaman as $karyawan)
                                            <option value="{{ $karyawan->id }}"
                                                {{ $riwayatPengembalian->karyawan_id == $karyawan->id ? 'selected' : '' }}>
                                                {{ $karyawan->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="jenis_id" class="form-label">Jenis <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-stretch">
                                <div class="flex-grow-1">
                                    <select name="jenis_id" id="jenis_id" class="tom-select w-100" required
                                        data-placeholder="-- Pilih Jenis --">
                                        <option value="" disabled selected hidden>-- Pilih Jenis --</option>
                                        @foreach ($jenisBarang as $jenis)
                                            <option value="{{ $jenis->id }}"
                                                {{ $riwayatPengembalian->jenis_id == $jenis->merek_id ? 'selected' : '' }}>
                                                {{ $jenis->jenis }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="merek_id" class="form-label">Merek <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-stretch">
                                <div class="flex-grow-1">
                                    <select name="merek_id" id="merek_id" class="tom-select w-100" required
                                        data-placeholder="-- Pilih Merek --">
                                        <option value="" disabled selected hidden>-- Pilih Merek --</option>
                                        @foreach ($jenisBarang->where('merek_id', $riwayatPengembalian->jenis_id) as $merek)
                                            <option value="{{ $merek->merek_id }}"
                                                {{ $riwayatPengembalian->jenis_id == $merek->merek_id ? 'selected' : '' }}>
                                                {{ $merek->merek }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="barang_id" class="form-label">Barang <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-stretch">
                                <div class="flex-grow-1">
                                    <select name="barang_id" id="barang_id" class="tom-select w-100" required
                                        data-placeholder="-- Pilih Barang --">
                                        <option value="" disabled selected hidden>-- Pilih Barang --</option>
                                        @foreach ($barangs->where('jenis_id', $riwayatPengembalian->jenis_id) as $barang)
                                            @if (
                                                ($barang->status == 1 && $barang->karyawan_id == $riwayatPengembalian->karyawan_id) ||
                                                    $barang->id == $riwayatPengembalian->barang_id)
                                                <option value="{{ $barang->id }}"
                                                    {{ $riwayatPengembalian->barang_id == $barang->id ? 'selected' : '' }}>
                                                    {{ $barang->id }} - {{ $barang->nama_barang }}
                                                    {{ $barang->kelengkapan == 1 ? '(Lengkap)' : '(Tidak Lengkap)' }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="kondisi" class="form-label">Kondisi <span class="text-danger">*</span></label>
                            <textarea id="kondisi" name="kondisi" class="form-control" rows="3" required>{{ old('kondisi', $riwayatPengembalian->kondisi) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea id="keterangan" name="keterangan" class="form-control" rows="3">{{ old('keterangan', $riwayatPengembalian->keterangan) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tanggal" id="tanggal"
                                value="{{ old('tanggal', $riwayatPengembalian->tanggal) }}" required>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end my-5">
                        <a href="{{ route('riwayat.index') }}" class="btn btn-secondary me-2">Kembali</a>
                        <button type="submit" class="btn btn-primary px-4" id="btnUpdate">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const configTomSelect = {
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
            };

            const tsJenis = new TomSelect('#jenis_id', {
                ...configTomSelect,
                placeholder: '-- Pilih Jenis --'
            });

            const tsMerek = new TomSelect('#merek_id', {
                ...configTomSelect,
                placeholder: '-- Pilih Merek --'
            });

            const tsBarang = new TomSelect('#barang_id', {
                ...configTomSelect,
                placeholder: '-- Pilih Barang --'
            });

            const tsKaryawan = new TomSelect('#karyawan_id', {
                ...configTomSelect,
                placeholder: '-- Pilih Karyawan --'
            });

            tsKaryawan.on('change', function() {
                const karyawanId = tsKaryawan.getValue();

                tsJenis.clear(true);
                tsJenis.clearOptions();
                tsMerek.clear(true);
                tsMerek.clearOptions();
                tsBarang.clear(true);
                tsBarang.clearOptions();

                if (!karyawanId) return;

                // Fetch jenis berdasarkan karyawan
                fetch(`/api/jenisByKaryawan/${karyawanId}`)
                    .then(res => res.json())
                    .then(data => {
                        const options = data.map(j => ({
                            value: j.id,
                            text: j.jenis
                        }));
                        tsJenis.addOptions(options);
                        tsJenis.enable();
                    })
                    .catch(() => {
                        Swal.fire('Error', 'Gagal memuat data jenis', 'error');
                    });
            });
            tsJenis.on('change', function() {
                const jenisId = tsJenis.getValue();
                const karyawanId = tsKaryawan.getValue();

                if (!jenisId || !karyawanId) {
                    tsMerek.disable();
                    return;
                }

                fetch(`/api/merek-by-jenis-karyawan/${jenisId}/${karyawanId}`)
                    .then(res => res.json())
                    .then(data => {
                        const options = data.map(m => ({
                            value: m.merek_id,
                            text: m.merek
                        }));
                        tsMerek.clear(true);
                        tsMerek.clearOptions();
                        tsMerek.addOptions(options);
                        tsMerek.enable();
                    })
                    .catch(() => {
                        Swal.fire('Error', 'Gagal memuat data merek', 'error');
                    });
                reloadBarangOptions();
            });

            tsMerek.on('change', reloadBarangOptions);
            tsKaryawan.on('change', reloadBarangOptions);

            function reloadBarangOptions() {
                const jenisId = tsJenis.getValue();
                const merekId = tsMerek.getValue();
                const karyawanId = tsKaryawan.getValue();
                const currentBarangId = "{{ $riwayatPengembalian->barang_id }}";

                if (!jenisId || !karyawanId || !merekId) {
                    tsBarang.disable();
                    tsBarang.clear(true);
                    tsBarang.clearOptions();
                    return;
                }

                fetch(
                        `/api/barang-edit?jenis_id=${jenisId}&merek_id=${merekId}&karyawan_id=${karyawanId}&current_id=${currentBarangId}`
                        )
                    .then(res => res.json())
                    .then(data => {
                        console.log('Barang data:', data);
                        const options = data.map(b => ({
                            value: b.id,
                            text: `${b.id} - ${b.nama_barang} ${b.kelengkapan == 1 ? '(Lengkap)' : '(Tidak Lengkap)'}`
                        }));
                        tsBarang.clear(true);
                        tsBarang.clearOptions();
                        tsBarang.addOptions(options);
                        tsBarang.enable();
                    })
                    .catch(() => {
                        tsBarang.disable();
                        Swal.fire('Error', 'Gagal memuat data barang', 'error');
                    });
            }
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
