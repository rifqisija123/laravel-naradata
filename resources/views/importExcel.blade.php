@extends('layouts.apps')

@section('title', 'Import Barang')

@section('content')
    @yield('importExcel')
@endsection
@push('scripts')
    <script>
        document.getElementById('btnImport').addEventListener('click', function(e) {
            e.preventDefault();

            const fileInput = document.getElementById('file_excel');
            if (!fileInput.value) {
                Swal.fire({
                    icon: 'warning',
                    title: 'File belum dipilih!',
                    text: 'Silakan pilih file Excel terlebih dahulu.',
                });
                return;
            }

            Swal.fire({
                title: 'Yakin ingin mengimport data?',
                text: 'Pastikan file Excel sudah sesuai format!',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, import!',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-secondary ms-2'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formImport').submit();
                }
            });
        });
    </script>
@endpush
