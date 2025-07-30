@extends('layouts.apps')

@section('title', 'Create Riwayat')

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
        <ul class="nav nav-tabs mb-3" id="riwayatTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="peminjaman-tab" data-bs-toggle="tab" data-bs-target="#peminjaman"
                    type="button" role="tab" aria-controls="peminjaman" aria-selected="true">
                    Peminjaman
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pengembalian-tab" data-bs-toggle="tab" data-bs-target="#pengembalian"
                    type="button" role="tab" aria-controls="pengembalian" aria-selected="false">
                    Pengembalian
                </button>
            </li>
        </ul>
        <div class="tab-content" id="riwayatTabContent">
            <div class="tab-pane fade show active" id="peminjaman" role="tabpanel" aria-labelledby="peminjaman-tab">
                <div class="card shadow-sm rounded-4">
                    <div class="card-body px-4 py-4">
                        <h3 class="fw-bold mb-3" style="color: #0d47a1;">Tambah Riwayat Peminjaman</h3>
                        <hr
                            style="height: 4px; border: none; background: linear-gradient(135deg, #0d47a1 0%, #00897b 100%); border-radius: 10px; margin-top: -10px;">
                        @include('riwayats.formPeminjaman')
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pengembalian" role="tabpanel" aria-labelledby="pengembalian-tab">
                <div class="card shadow-sm rounded-4">
                    <div class="card-body px-4 py-4">
                        <h3 class="fw-bold mb-3" style="color: #0d47a1;">Tambah Riwayat Pengembalian</h3>
                        <hr
                            style="height: 4px; border: none; background: linear-gradient(135deg, #0d47a1 0%, #00897b 100%); border-radius: 10px; margin-top: -10px;">
                        @include('riwayats.formPengembalian')
                    </div>
                </div>
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

            const tsJenisPengembalian = new TomSelect('#pengembalian #jenis_id', {
                ...configTomSelect,
                placeholder: '-- Pilih Jenis --'
            });
            const tsMerekPengembalian = new TomSelect('#pengembalian #merek_id', {
                ...configTomSelect,
                placeholder: '-- Pilih Merek --'
            });
            const tsBarangPengembalian = new TomSelect('#pengembalian #barang_id', {
                ...configTomSelect,
                placeholder: '-- Pilih Barang --'
            });
            const tsKaryawanPengembalian = new TomSelect('#pengembalian #karyawan_id', {
                ...configTomSelect,
                placeholder: '-- Pilih Karyawan --'
            });

            tsJenisPengembalian.disable();
            tsMerekPengembalian.disable();
            tsBarangPengembalian.disable();

            tsKaryawanPengembalian.on('change', karyawanId => {
                if (!karyawanId) {
                    tsJenisPengembalian.disable();
                    tsMerekPengembalian.disable();
                    tsBarangPengembalian.disable();
                    return;
                }

                fetch(`/api/barang-by-karyawan/${karyawanId}`)
                    .then(res => res.json())
                    .then(data => {
                        tsJenisPengembalian.clear(true);
                        tsJenisPengembalian.clearOptions();
                        tsJenisPengembalian.clear(true);
                        tsJenisPengembalian.clearOptions();
                        tsBarangPengembalian.clear(true);
                        tsBarangPengembalian.clearOptions();

                        const jenisMap = new Map();
                        const barangOptions = [];

                        data.forEach(b => {
                            const jenisKey = b.jenis.toLowerCase();
                            if (!jenisMap.has(jenisKey)) {
                                jenisMap.set(jenisKey, {
                                    value: b.jenis_id,
                                    text: `${b.jenis}`
                                });
                            }

                            barangOptions.push({
                                value: b.id,
                                text: `${b.id} - ${b.nama_barang}${b.kelengkapan == 1 ? ' (Lengkap)' : ' (Tidak Lengkap)'}`
                            });
                        });

                        tsJenisPengembalian.addOptions(Array.from(jenisMap.values()));
                        tsJenisPengembalian.enable();
                        tsBarangPengembalian.disable();
                        tsBarangPengembalian.clear();
                        tsBarangPengembalian.clearOptions();
                    })
                    .catch(() => {
                        Swal.fire('Error', 'Gagal memuat data riwayat pengembalian', 'error');
                    });
            });

            tsJenisPengembalian.on('change', jenisId => {
                const selectedKaryawanId = tsKaryawanPengembalian.getValue();

                if (!jenisId || !selectedKaryawanId) {
                    tsMerekPengembalian.disable();
                    tsMerekPengembalian.clear(true);
                    tsMerek.clearOptions();
                    tsBarangPengembalian.disable();
                    return;
                }

                fetch(`/merek-by-jenis-karyawan/${jenisId}/${selectedKaryawanId}`)
                    .then(res => res.json())
                    .then(data => {
                        const options = data.map(m => ({
                            value: m.merek_id,
                            text: m.merek
                        }));

                        tsMerekPengembalian.clear(true);
                        tsMerekPengembalian.clearOptions();
                        tsMerekPengembalian.addOptions(options);
                        tsMerekPengembalian.enable();
                    })
                    .catch(() => {
                        Swal.fire('Error', 'Gagal memuat data merek', 'error');
                    });
            });

            tsMerekPengembalian.on('change', merekId => {
                const jenisId = tsJenisPengembalian.getValue();
                const karyawanId = tsKaryawanPengembalian.getValue();

                if (!merekId || !jenisId || !karyawanId) {
                    tsBarangPengembalian.disable();
                    tsBarangPengembalian.clear();
                    return;
                }

                fetch(`/barang-by-karyawan-jenis-merek/${karyawanId}/${jenisId}/${merekId}`)
                    .then(res => res.json())
                    .then(data => {
                        const options = data.map(b => ({
                            value: b.id,
                            text: `${b.id} - ${b.nama_barang} ${b.kelengkapan == 1 ? '(Lengkap)' : '(Tidak Lengkap)'}`
                        }));

                        tsBarangPengembalian.clear(true);
                        tsBarangPengembalian.clearOptions();
                        tsBarangPengembalian.addOptions(options);
                        tsBarangPengembalian.enable();
                    })
                    .catch(() => {
                        Swal.fire('Error', 'Gagal memuat data barang', 'error');
                        tsBarangPengembalian.disable();
                    });
            });

            const tsJenis = new TomSelect('#jenis_id', {
                ...configTomSelect,
                placeholder: '-- Pilih Jenis --'
            });

            const tsMerek = new TomSelect('#merek_id', {
                ...configTomSelect,
                placeholder: '-- Pilih Merek --'
            });
            tsMerek.disable();

            const tsBarang = new TomSelect('#barang_id', {
                ...configTomSelect,
                placeholder: '-- Pilih Barang --'
            });

            const tsKaryawan = new TomSelect('#karyawan_id', {
                ...configTomSelect,
                placeholder: '-- Pilih Karyawan --'
            });
            tsBarang.disable();

            tsJenis.on('change', jenisId => {
                if (!jenisId) {
                    tsMerek.disable();
                    tsMerek.clear(true);
                    tsMerek.clearOptions();
                    tsBarang.disable();
                    tsBarang.clear(true);
                    tsBarang.clearOptions();
                    return;
                }

                fetch(`/api/merek-by-jenis/${jenisId}`)
                    .then(res => res.json())
                    .then(data => {
                        tsMerek.clear(true);
                        tsMerek.clearOptions();

                        const options = data.map(m => ({
                            value: m.merek_id,
                            text: m.merek
                        }));

                        tsMerek.addOptions(options);
                        tsMerek.enable();
                    })
                    .catch(() => {
                        Swal.fire('Error', 'Gagal memuat data merek', 'error');
                    });
            });
            tsMerek.on('change', merekId => {
                const jenisId = tsJenis.getValue();

                if (!merekId || !jenisId) {
                    tsBarang.disable();
                    tsBarang.clear(true);
                    tsBarang.clearOptions();
                    return;
                }

                fetch(`/api/barang-by-jenis-merek/${jenisId}/${merekId}`)
                    .then(res => res.json())
                    .then(data => {
                        const options = data.map(b => {
                            const status = b.kelengkapan == 1 ? '(Lengkap)' : '(Tidak Lengkap)';
                            return {
                                value: b.id,
                                text: `${b.id} - ${b.nama_barang} ${status}`
                            };
                        });

                        tsBarang.clear(true);
                        tsBarang.clearOptions();
                        tsBarang.addOptions(options);
                        tsBarang.enable();

                        tsBarang.on('change', value => {
                            const selectedItem = tsBarang.options[value];
                            if (selectedItem && selectedItem.text.includes('(Tidak Lengkap)')) {
                                Swal.fire({
                                    icon: 'question',
                                    title: 'Perhatian',
                                    text: 'Barang ini "Tidak Lengkap", apakah ingin melanjutkan?',
                                    showConfirmButton: true,
                                    showCancelButton: true,
                                    confirmButtonText: "Lanjut",
                                    cancelButtonText: "Batal",
                                });
                            }
                        });
                    })
                    .catch(() => {
                        tsBarang.disable();
                        Swal.fire('Error', 'Gagal memuat data barang', 'error');
                    });
            });
            const handleFormSubmitWithConfirm = (formId, confirmText) => {
                const form = document.getElementById(formId);
                if (!form) return;

                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: `Yakin ingin menambahkan?`,
                        text: confirmText,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, tambahkan!',
                        cancelButtonText: 'Batal',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: "Ditambahkan!",
                                icon: "success",
                                timer: 1500,
                                showConfirmButton: false,
                            });
                            setTimeout(() => {
                                form.submit();
                            }, 1300);
                        }
                    });
                });
            };
            handleFormSubmitWithConfirm('formPeminjaman', 'Data peminjaman akan disimpan ke dalam tabel.');
            handleFormSubmitWithConfirm('formPengembalian', 'Data pengembalian akan disimpan ke dalam tabel.');
        });
        document.querySelectorAll('button[data-bs-toggle="tab"]').forEach(function(tabButton) {
            tabButton.addEventListener("shown.bs.tab", function() {
                setTimeout(() => {
                    document.querySelectorAll("select.tom-select").forEach(function(el) {
                        if (!el.tomselect) {
                            new TomSelect(el, {
                                placeholder: el.dataset.placeholder || "-- Pilih --"
                            });
                        }
                    });
                }, 100);
            });
        });
    </script>
@endpush
