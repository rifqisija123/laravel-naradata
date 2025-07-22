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

            const tsJenis = new TomSelect('#jenis_id', {
                ...configTomSelect,
                placeholder: '-- Pilih Jenis & Merek --'
            });

            const tsBarang = new TomSelect('#barang_id', {
                ...configTomSelect,
                placeholder: '-- Pilih Barang --'
            });

            const tsKaryawan = new TomSelect('#karyawan_id', {
                ...configTomSelect,
                placeholder: '-- Pilih Karyawan --'
            });

            tsBarang.disable();

            tsJenis.on('change', value => {
                if (!value) {
                    tsBarang.disable();
                    tsBarang.clear(true);
                    tsBarang.clearOptions();
                    return;
                }

                fetch("{{ url('api/barang-by-jenis') }}/" + value)
                    .then(res => res.json())
                    .then(data => {
                        tsBarang.clear(true);
                        tsBarang.clearOptions();
                        tsBarang.addOptions(
                            data.map(b => {
                                const statusKelengkapan = b.kelengkapan == 1 ? '(Lengkap)' :
                                    '(Tidak Lengkap)';
                                return {
                                    value: b.id,
                                    text: `${b.id} - ${b.nama_barang}${statusKelengkapan}`
                                };
                            })
                        );

                        tsBarang.enable();
                        tsBarang.refreshOptions(false);

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
            const form = document.getElementById('formCreateRiwayat');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: `Yakin ingin menambahkan?`,
                    text: "Data akan disimpan ke dalam tabel.",
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
