console.log("ini role js");
var  role = {}

$(document).ready(function(){

    $('#btnAddRole').click(function(){
        $('#id_role').val('');
        $('#code_role').val('');
        $('#nama_role').val('');
        $('.modal-title').html('<i class="fas fa-plus mr-2"></i> Add Role');
        $('#modalAddRole').modal('show');
    });

    $('#btnSimpanRole').click(function(){
        var id_role = $('#id_role').val();
        var action    = id_role ? 'update' : 'create';

        var json = {
            action         : action,
            code_role      : $('#code_role').val(),
            nama_role      : $('#nama_role').val()
        };

        if(action == 'update'){
            json.id_role = id_role;
        }

        console.log(json);

        var url = 'proses_role.php';
        $.post(url, json, function(response){
            console.log(response);
            if(response.status == 'success'){
                $('#modalAddRole').modal('hide');
                $('#id_role').val('');
                $('#code_role').val('');
                $('#nama_role').val('');
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

        $.get('proses_role.php', { action: 'getById', id: id }, function(response){
            console.log(response);
            var d = response.data;
            $('#id_role').val(d.id_role);
            $('#code_role').val(d.code_role);
            $('#nama_role').val(d.nama_role);
            $('.modal-title').html('<i class="fas fa-edit mr-2"></i> Edit Role');
            $('#modalAddRole').modal('show');
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

                var url = 'proses_role.php';
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
    $.get('proses_role.php', { action: 'read' }, function(response){
        console.log(response);
        var tbody = $('#tbodyRole');
        tbody.empty();

        if(!response.data || response.data.length == 0){
            tbody.append(
                '<tr>' +
                    '<td colspan="7" class="text-center text-muted py-3">' +
                        '<i class="fas fa-inbox mr-2"></i> Belum ada data role' +
                    '</td>' +
                '</tr>'
            );
            return;
        }

        $.each(response.data, function(i, row){
            tbody.append(
                '<tr id="row-' + row.id_role + '">' +
                    '<td class="text-center">' + (i+1) + '</td>' +
                    '<td>' + row.code_role + '</td>' +
                    '<td>' + row.nama_role + '</td>' +
                    '<td>' + row.isActive  + '</td>' +
                    '<td class="text-center">' +
                        '<button class="btn btn-warning btn-xs mr-1 btnEdit" data-id="' + row.id_role + '">' +
                            '<i class="fas fa-edit"></i>' +
                        '</button>' +
                        '<button class="btn btn-danger btn-xs btnHapus"  data-id="' + row.id_role + '">' +
                            '<i class="fas fa-trash"></i>' +
                        '</button>' +
                    '</td>' +
                '</tr>'
            );
        });

    }, 'json');
}