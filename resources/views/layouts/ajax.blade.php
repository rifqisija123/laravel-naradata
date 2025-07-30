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
    $('#formJenisModal').on('submit', function(e) {
        e.preventDefault();

        let jenis = $('#inputJenisManual').is(':visible') ? $('#inputJenisManual').val() : $(
            '#selectJenisExisting').val();
        let isManual = $('#inputJenisManual').is(':visible') ? 1 : 0;
        let merek = $('#namaMerekBaru').val();
        let keterangan = $('#keteranganJenis').val();

        $.ajax({
            url: "{{ route('jenis.store') }}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                jenis: jenis,
                merek: merek,
                keterangan: keterangan,
                manual: isManual
            },
            success: function(response) {
                if (response.status === 'success') {
                    let selectJenis = $('#jenis_id')[0].tomselect;

                    selectJenis.addOption({
                        value: response.data.merek_id,
                        text: response.data.jenis + ' - ' + response.data.merek
                    });

                    selectJenis.addItem(response.data.merek_id);

                    $('#inputJenisManual').val('').addClass('d-none').attr('disabled', true);
                    $('#selectJenisManual').attr('required', false);

                    $('#selectJenisExisting')[0].tomselect.clear();
                    $('#namaMerekBaru').val('');
                    $('#keteranganJenis').val('');
                    $('#wrapperKeteranganJenis').hide();

                    $('.ts-control').removeClass('d-none');
                    $('#selectJenisExisting').removeClass('d-none');

                    manualMode = false;

                    $('#exampleModalJenis').modal('hide');
                }
            },
            error: function(xhr) {
                if (xhr.status === 409) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: xhr.responseJSON.message
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Gagal menyimpan jenis dan merek.'
                    });
                }
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
