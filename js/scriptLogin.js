$(document).ready(function(){
    $('#btnLogin').click(function(){
        var username = $('#idUsername').val();
        var password = $('#idPassword').val();

        let isValid = 1;
        if(username === ""){
            $('#idUsername').addClass('is-invalid');
            $('#errorUsername').html('Username harus diisi');
            isValid = 0;
        }
        
        if(password === ""){
            $('#idPassword').addClass('is-invalid');
            $('#errorPassword').html('Password harus diisi');
            isValid = 0;
        }

        $('#idUsername').on('input', function(){
            if($(this).val() !== ''){
                $(this).removeClass('is-invalid');
                $('#errorUsername').html('');
            }
        });

        $('#idPassword').on('input', function(){
            if($(this).val() !== ''){
                $(this).removeClass('is-invalid');
                $('#errorPassword').html('');
            }
        });

        if(isValid == 0) return;

        $.ajax({
            url : BASE_URL + 'proses/proses_login.php',
            type: 'POST',
            dataType: 'json',
            data: {
                username : username,
                password : password
            },
            success: function(data){
                console.log("RESPONSE:", data);

                if(data.status === 'success'){
                    var role    = data.role;
                    var uname   = encodeURIComponent(data.username);
                    var idUsers = encodeURIComponent(data.id_users);

                    Swal.fire({ icon: 'success', text: 'Login berhasil!', timer: 2000, showConfirmButton: false })
                    .then(function(){
                        if(role === 'ADMIN_MASTER'){
                            window.location = 'api/dashboard/dashboard_master.php?user=' + uname + '&role=ADMIN_MASTER&id_users=' + idUsers;
                        } else if(role === 'ADMIN'){
                            window.location = 'api/dashboard/dashboard_admin.php?user=' + uname + '&role=ADMIN&id_users=' + idUsers;
                        } else if(role === 'USR'){
                            window.location = 'api/dashboard/dashboard_user.php?user=' + uname + '&role=USR&id_users=' + idUsers;
                        }
                    });

                } else {
                    Swal.fire({ icon: 'error', text: 'Username atau Password salah!' });
                }
            },
            error: function(){
                Swal.fire({ icon: 'error', text: 'Terjadi kesalahan pada server' });
            }
        });
    });
});