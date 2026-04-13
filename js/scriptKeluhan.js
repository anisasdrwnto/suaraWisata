console.log("ini laporan js");
var laporan = {}

$(document).ready(function(){

    $('#btnAddLaporan').click(function(){
        $('#id_laporan').val('');
        $('#nama_pelapor').val('');
        $('#alamat_pelapor').val('');
        $('#lokasi_wisata').val('');
        $('#isi_laporan').val('');
        $('.modal-title').html('<i class="fas fa-plus mr-2"></i> Add Laporan Keluhan Wisata');
        $('#modalAddLaporan').modal('show');
    });

    $('#btnSimpanLaporan').click(function(){
        var idLaporan = $('#id_laporan').val();
        var action    = idLaporan ? 'update' : 'create';

        var json = {
            action         : action,
            nama_pelapor   : $('#nama_pelapor').val(),
            alamat_pelapor : $('#alamat_pelapor').val(),
            lokasi_wisata  : $('#lokasi_wisata').val(),
            isi_laporan    : $('#isi_laporan').val()
        };

        if(action == 'update'){
            json.id_laporan = idLaporan;
        }

        console.log(json);

        var url = 'proses_laporan.php';
        $.post(url, json, function(response){
            console.log(response);
            if(response.status == 'success'){
                $('#modalAddLaporan').modal('hide');
                $('#id_laporan').val('');
                $('#nama_pelapor').val('');
                $('#alamat_pelapor').val('');
                $('#lokasi_wisata').val('');
                $('#isi_laporan').val('');
                loadData();
                Swal.fire({
                    icon             : 'success',
                    title            : 'Berhasil!',
                    text             : response.message,
                    timer            : 2000,
                    showConfirmButton : false
                });
            } else {
                Swal.fire({
                    icon  : 'error',
                    title : 'Gagal!',
                    text  : response.message
                });
            }
        }, 'json');

    });

    

    $(document).on('click', '.btnEdit', function(){
        var id = $(this).data('id');

        $.get('proses_laporan.php', { action: 'getById', id: id }, function(response){
            console.log(response);
            var d = response.data;
            $('#id_laporan').val(d.id_laporan);
            $('#nama_pelapor').val(d.nama_pelapor);
            $('#alamat_pelapor').val(d.alamat_pelapor);
            $('#lokasi_wisata').val(d.lokasi_wisata);
            $('#isi_laporan').val(d.isi_laporan);
            $('.modal-title').html('<i class="fas fa-edit mr-2"></i> Edit Laporan Wisata');
            $('#modalAddLaporan').modal('show');
        }, 'json');

    });

    $(document).on('click', '.btnHapus', function(){
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
        }).then(function(result){
            if(result.isConfirmed){
                var json = {
                    action : 'delete',
                    id     : id
                };

                var url = 'proses_laporan.php';
                $.post(url, json, function(response){
                    console.log(response);
                    if(response.status == 'success'){
                        $('#row-' + id).fadeOut(400, function(){
                            $(this).remove();
                        });
                        Swal.fire({
                            icon             : 'success',
                            title            : 'Terhapus!',
                            text             : response.message,
                            timer            : 2000,
                            showConfirmButton : false
                        });
                    } else {
                        Swal.fire({
                            icon  : 'error',
                            title : 'Gagal!',
                            text  : response.message
                        });
                    }
                }, 'json');
            }
        });

    });

    loadData();

});

function loadData(){
    $.get('proses_laporan.php', { action: 'read' }, function(response){
        console.log(response);
        var tbody = $('#tbodyLaporan');
        tbody.empty();

        if(!response.data || response.data.length == 0){
            tbody.append(
                '<tr>' +
                    '<td colspan="7" class="text-center text-muted py-3">' +
                        '<i class="fas fa-inbox mr-2"></i> Belum ada data laporan' +
                    '</td>' +
                '</tr>'
            );
            return;
        }

        $.each(response.data, function(i, row){
            tbody.append(
                '<tr id="row-' + row.id_laporan + '">' +
                    '<td class="text-center">' + (i+1) + '</td>' +
                    '<td>' + row.id_laporan + '</td>' +
                    '<td>' + row.nama_pelapor + '</td>' +
                    '<td>' + row.alamat_pelapor + '</td>' +
                    '<td>' + row.lokasi_wisata + '</td>' +
                    '<td>' + row.isi_laporan + '</td>' +
                    '<td class="text-center">' +
                        '<button class="btn btn-warning btn-xs mr-1 btnEdit" data-id="' + row.id_laporan + '">' +
                            '<i class="fas fa-edit"></i>' +
                        '</button>' +
                        '<button class="btn btn-danger btn-xs btnHapus"  data-id="' + row.id_laporan + '">' +
                            '<i class="fas fa-trash"></i>' +
                        '</button>' +
                    '</td>' +
                '</tr>'
            );
        });

    }, 'json');
}