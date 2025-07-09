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
        $('#formJenisModal').on('submit', function(e) {
            e.preventDefault();

            let jenis = $('#namaJenisBaru').val();
            let merek = $('#namaMerekBaru').val();
            let keterangan = $('#keteranganJenis').val();

            $.ajax({
                url: "{{ route('jenis.store') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    jenis: jenis,
                    merek: merek,
                    keterangan: keterangan
                },
                success: function(response) {
                    if (response.status === 'success') {
                        let selectJenis = $('#jenis_id')[0].tomselect;

                        selectJenis.addOption({
                            value: response.data.merek_id,
                            text: response.data.jenis + ' - ' + response.data.merek
                        });

                        selectJenis.addItem(response.data.id);

                        // Reset & tutup modal
                        $('#namaJenisBaru').val('');
                        $('#namaMerekBaru').val('');
                        $('#keteranganJenis').val('');
                        $('#exampleModalJenis').modal('hide');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 409) {
                        alert(xhr.responseJSON.message);
                    } else {
                        alert('Gagal menyimpan jenis dan merek.');
                    }
                }
            });
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
