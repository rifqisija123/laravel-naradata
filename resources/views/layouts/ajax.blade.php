<script>
    $(document).ready(function() {
        $('#formKategoriModal').on('submit', function(e) {
            e.preventDefault();

            let namaKategori = $('#namaKategoriBaru').val();
            let keterangan = $('#keteranganKategori').val();

            $.ajax({
                url: "{{ route('kategori.store') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    kategori: namaKategori,
                    keterangan: keterangan
                },
                success: function(response) {
                    if (response.status === 'success') {
                        let selectKategori = $('#kategori_id')[0].tomselect;

                        selectKategori.addOption({
                            value: response.data.id,
                            text: response.data.kategori
                        });

                        selectKategori.addItem(response.data.id);

                        // Reset & tutup modal
                        $('#namaKategoriBaru').val('');
                        $('#keteranganKategori').val('');
                        $('#exampleModalKategori').modal('hide');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 409) {
                        alert(xhr.responseJSON.message);
                    } else {
                        alert('Gagal menyimpan kategori.');
                    }
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        let debounceTimeout;

        $('#inputJenisManual').on('input', function() {
            clearTimeout(debounceTimeout);
            const keyword = $(this).val().trim();

            if (keyword.length < 2) {
                closeDropdown();
                return;
            }

            debounceTimeout = setTimeout(() => {
                $.ajax({
                    url: "{{ route('jenis.autocomplete') }}",
                    type: "GET",
                    data: { keyword },
                    success: function(response) {
                        showDropdown(response);
                    }
                });
            }, 300);
        });

        function showDropdown(data) {
            closeDropdown();
            if (data.length === 0) return;

            const dropdown = $('<div class="autocomplete-dropdown border bg-white shadow-sm rounded" style="position: absolute; z-index: 9999; width: 100%;"></div>');
            data.forEach(item => {
                dropdown.append(`<div class="dropdown-item py-1 px-2 cursor-pointer">${item.jenis}</div>`);
            });

            dropdown.insertAfter('#inputJenisManual');

            $('.autocomplete-dropdown .dropdown-item').on('click', function() {
                $('#inputJenisManual').val($(this).text());
                closeDropdown();
            });
        }

        function closeDropdown() {
            $('.autocomplete-dropdown').remove();
        }

        $(document).on('click', function(e) {
            if (!$(e.target).closest('#inputJenisManual').length) {
                closeDropdown();
            }
        });
    });

    // Submit logic tetap
    $('#formJenisModal').on('submit', function(e) {
        e.preventDefault();

        let jenis = $('#inputJenisManual').val();
        let merek = $('#namaMerekBaru').val();
        let keterangan = $('#keteranganJenis').val();

        $.ajax({
            url: "{{ route('jenis.store') }}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                jenis,
                merek,
                keterangan,
                manual: 1
            },
            success: function(response) {
                if (response.status === 'success') {
                    let selectJenis = $('#jenis_id')[0].tomselect;

                    selectJenis.addOption({
                        value: response.data.merek_id,
                        text: response.data.jenis + ' - ' + response.data.merek
                    });

                    selectJenis.addItem(response.data.merek_id);
                    $('#formJenisModal')[0].reset();
                    $('#wrapperKeteranganJenis').hide();
                    $('#exampleModalJenis').modal('hide');
                }
            },
            error: function(xhr) {
                let msg = xhr.responseJSON?.message || 'Gagal menyimpan jenis dan merek.';
                Swal.fire({ icon: 'error', title: 'Gagal!', text: msg });
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#formLokasiModal').on('submit', function(e) {
            e.preventDefault();

            let lokasi = $('#namaPosisiBaru').val();
            let keterangan = $('#keteranganLokasi').val();

            $.ajax({
                url: "{{ route('lokasi.store') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    posisi: lokasi,
                    keterangan: keterangan
                },
                success: function(response) {
                    if (response.status === 'success') {
                        let selectLokasi = $('#lokasi_id')[0].tomselect;

                        selectLokasi.addOption({
                            value: response.data.id,
                            text: response.data.posisi
                        });

                        selectLokasi.addItem(response.data.id);

                        // Reset & tutup modal
                        $('#namaPosisiBaru').val('');
                        $('#keteranganLokasi').val('');
                        $('#exampleModalLokasi').modal('hide');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 409) {
                        alert(xhr.responseJSON.message);
                    } else {
                        alert('Gagal menyimpan lokasi.');
                    }
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#toggleKeteranganKategori').click(function() {
            $('#wrapperKeteranganKategori').slideToggle();
        });

        $('#toggleKeteranganJenis').click(function() {
            $('#wrapperKeteranganJenis').slideToggle();
        });

        $('#toggleKeteranganLokasi').click(function() {
            $('#wrapperKeteranganLokasi').slideToggle();
        });
    });
</script>
