$(document).ready(function() {
    $('#btnAddLaporan').click(function() {
        $('#id_laporan, #nama_pelapor, #alamat_pelapor, #lokasi_wisata, #isi_laporan').val('');
        $('.modal-title').html('<i class="fas fa-plus-circle mr-2"></i> Tambah Laporan Wisata');
        $('#modalAddLaporan').modal('show');
    });

    $('#btnSimpanLaporan').click(function() {
        var id     = $('#id_laporan').val();
        var action = id ? 'update' : 'create';

        $.post('proses_laporan.php', {
            action         : action,
            id_laporan     : id,
            nama_pelapor   : $('#nama_pelapor').val(),
            alamat_pelapor : $('#alamat_pelapor').val(),
            lokasi_wisata  : $('#lokasi_wisata').val(),
            isi_laporan    : $('#isi_laporan').val()
        }, function(res) {
            if (res.status == 'success') {
                $('#modalAddLaporan').modal('hide');
                loadData();
                Swal.fire({
                    icon             : 'success',
                    title            : 'Berhasil!',
                    text             : res.message,
                    timer            : 2000,
                    showConfirmButton : false
                });
            } else {
                Swal.fire({
                    icon  : 'error',
                    title : 'Gagal!',
                    text  : res.message
                });
            }
        }, 'json');
    });

    $(document).on('click', '.btn-edit', function() {
        var id = $(this).data('id');

        $.get('proses_laporan.php', { action: 'getById', id: id }, function(res) {
            var d = res.data;
            $('#id_laporan').val(d.id_laporan);
            $('#nama_pelapor').val(d.nama_pelapor);
            $('#alamat_pelapor').val(d.alamat_pelapor);
            $('#lokasi_wisata').val(d.lokasi_wisata);
            $('#isi_laporan').val(d.isi_laporan);
            $('.modal-title').html('<i class="fas fa-edit mr-2"></i> Edit Laporan Wisata');
            $('#modalAddLaporan').modal('show');
        }, 'json');
    });

    $(document).on('click', '.btn-hapus', function() {
        var id = $(this).data('id');

        Swal.fire({
            title             : 'Yakin ingin menghapus?',
            text              : 'Data yang dihapus tidak bisa dikembalikan!',
            icon              : 'warning',
            showCancelButton  : true,
            confirmButtonColor: '#d33',
            cancelButtonColor : '#6c757d',
            confirmButtonText : 'Ya, Hapus!',
            cancelButtonText  : 'Batal'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.post('proses_laporan.php', { action: 'delete', id: id }, function(res) {
                    if (res.status == 'success') {
                        $('#row-' + id).fadeOut(400, function() {
                            $(this).remove();
                        });
                        Swal.fire({
                            icon             : 'success',
                            title            : 'Terhapus!',
                            text             : res.message,
                            timer            : 2000,
                            showConfirmButton : false
                        });
                    } else {
                        Swal.fire({
                            icon  : 'error',
                            title : 'Gagal!',
                            text  : res.message
                        });
                    }
                }, 'json');
            }
        });
    });

    // load data saat halaman dibuka
    loadData();
});

function loadData() {
    $.get('proses_laporan.php', { action: 'read' }, function(res) {
        var tbody = $('#tbodyLaporan');
        tbody.empty();

        if (!res.data || res.data.length == 0) {
            tbody.append(
                '<tr>' +
                    '<td colspan="8" class="text-center text-muted py-3">' +
                        '<i class="fas fa-inbox mr-2"></i> Belum ada data laporan' +
                    '</td>' +
                '</tr>'
            );
            return;
        }

        $.each(res.data, function(i, row) {
            tbody.append(
                '<tr id="row-' + row.id_laporan + '">' +
                    '<td class="text-center">' + (i+1) + '</td>' +
                    '<td>' + row.id_laporan + '</td>' +
                    '<td>' + row.nama_pelapor + '</td>' +
                    '<td>' + row.alamat_pelapor + '</td>' +
                    '<td>' + row.lokasi_wisata + '</td>' +
                    '<td>' + row.isi_laporan + '</td>' +
                    '<td class="text-center">' +
                        '<button class="btn btn-warning btn-xs mr-1 btn-edit" data-id="' + row.id_laporan + '">' +
                            '<i class="fas fa-edit"></i>' +
                        '</button>' +
                        '<button class="btn btn-danger btn-xs btn-hapus" data-id="' + row.id_laporan + '">' +
                            '<i class="fas fa-trash"></i>' +
                        '</button>' +
                    '</td>' +
                '</tr>'
            );
        });
    }, 'json');
}