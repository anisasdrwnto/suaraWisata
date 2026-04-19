console.log("ini manage user js");
var manageUser = {}
var BASE_URL = '/suaraWisata/';
$(document).ready(function(){
    $('#btnAddUser').click(function(){
        $('#id_users').val('');
        $('#nama').val('');
        $('#nama').attr('placeholder', 'Masukkan nama pengguna')
        $('#username').val('');
        $('#username').attr('placeholder', 'Masukkan username');
        $('#password').val('');
        $('#password').removeAttr('readonly');
        $('#password').removeClass('bg-light');
        $('#password').attr('placeholder', 'Masukkan password');
        $('#role').val('');
        $('.modal-title').html('<i class="fas fa-plus mr-2"></i> Add User');
        $('#modalAddUser').modal('show');
    });

    $('#btnSimpanUser').click(function(){
        var id_users    = $('#id_users').val();
        var action      = id_users ? 'update' : 'create';
        var passwordVal = $('#password').val();
        var nama     = $('#nama').val();
        var username = $('#username').val();

      
        let isValid = 1;

        if(action == 'create'){
            if(nama === ''){
                $("#nama").addClass("is-invalid");
                $('#errorNama').html('Nama pengguna wajib diisi');
                isValid = 0;
            }
            
            if(username === ''){
                $("#username").addClass("is-invalid");
                $('#errorUsername').html('Username wajib diisi');
                isValid = 0;
            }

            if(passwordVal === ''){
                $('#password').addClass('is-invalid');
                $('#errorPassword').html('Password wajib diisi');
                isValid = 0;
            }

            if($('#role').val() === ''){
                $('#role').addClass('is-invalid');
                $('#errorRole').html('Role wajib dipilih');
                isValid = 0;
            }

            $('#nama').on('input', function(){
                if($(this).val() !== ''){
                    $(this).removeClass('is-invalid');
                    $('#errorNama').html('');
                }
            });

            $('#username').on('input', function(){
                if($(this).val() !== ''){
                    $(this).removeClass('is-invalid');
                    $('#errorUsername').html('');
                }
            })

            $('#password').on('input', function(){
                if($(this).val() !== ''){
                    $(this).removeClass('is-invalid');
                    $('#errorPassword').html('');
                }
            })

            $('#role').change(function(){
                if($(this).val() !== ''){
                    $(this).removeClass('is-invalid');
                    $('#errorRole').html('');
                }
            });

           
        }


        if(isValid == 0) return;

        var json = {
            action   : action,
            nama     : $('#nama').val(),
            username : $('#username').val(),
            password : passwordVal === '********' ? '' : passwordVal,
            role     : $('#role').val()
        };
        console.log(json);

        if(action == 'update'){
            json.id_users = id_users;
        }

        var url = BASE_URL + 'proses/proses_manageUser.php';
        $.post(url, json, function(response){
            console.log(response);
            if(response.status == 'success'){
                $('#modalAddUser').modal('hide');
                $('#id_users').val('');
                $('#nama').val('');
                $('#username').val('');
                $('#password').val('');
                $('#role').val('USR');
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

        $.get(BASE_URL + 'proses/proses_manageUser.php', { action: 'getById', id: id }, function(response){
            console.log(response);
            var d = response.data;
            $('#id_users').val(d.id_users);
            $('#nama').val(d.nama);
            $('#username').val(d.username);
            $('#password').val('********');
            $('#password').attr('readonly', true);
            $('#password').addClass('bg-light');
            $('#role').val(d.ROLE);
            $('.modal-title').html('<i class="fas fa-edit mr-2"></i> Edit User');
            $('#modalAddUser').modal('show');
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
                    action   : 'delete',
                    id_users : id
                };

                var url = BASE_URL + 'proses/proses_manageUser.php';
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
    $.get(BASE_URL + 'proses/proses_manageUser.php', { action: 'read' }, function(response){
        console.log(response);
        var tbody = $('#tbodyUser');
        tbody.empty();

        if(!response.data || response.data.length == 0){
            tbody.append(
                '<tr>' +
                    '<td colspan="6" class="text-center text-muted py-3">' +
                        '<i class="fas fa-inbox mr-2"></i> Belum ada data user' +
                    '</td>' +
                '</tr>'
            );
            return;
        }

        $.each(response.data, function(i, row){
            tbody.append(
                '<tr id="row-' + row.id_users + '">' +
                    '<td class="text-center">' + (i+1) + '</td>' +
                    '<td>' + row.id_users  + '</td>' +
                    '<td>' + row.nama      + '</td>' +
                    '<td>' + row.username  + '</td>' +
                    '<td><span class="badge badge-info">' + row.ROLE + '</span></td>' +
                    '<td class="text-center">' +
                        '<button class="btn btn-warning btn-xs mr-1 btnEdit" data-id="' + row.id_users + '">' +
                            '<i class="fas fa-edit"></i>' +
                        '</button>' +
                        '<button class="btn btn-danger btn-xs btnHapus" data-id="' + row.id_users + '">' +
                            '<i class="fas fa-trash"></i>' +
                        '</button>' +
                    '</td>' +
                '</tr>'
            );
        });

    }, 'json');
}