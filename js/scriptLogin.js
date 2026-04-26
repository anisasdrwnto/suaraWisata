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
        })

        $('#idPassword').on('input', function(){
            if($(this).val() !== ''){
                $(this).removeClass('is-invalid');
                $('#errorPassword').html('');
            }
        })

        if(isValid == 0) return;

        $.ajax({
            url : BASE_URL + 'proses/proses_login.php',
            type: 'POST',

            data: {
                username : username,
                password : password
            },

          success: function(response){
                response = response.trim();
                console.log("RESPONSE:", response);

                if(response === "ADMIN_MASTER"){
                    Swal.fire({ icon: 'success', text: 'Login berhasil!', timer: 2000 })
                    window.location = '/api/dashboard/dashboard_master.php?user=' + encodeURIComponent(username) + '&role=ADMIN_MASTER';
                }else if(response === "ADMIN"){
                    Swal.fire({ icon: 'success', text: 'Login berhasil!', timer: 2000 })
                    .then(() => {  window.location = '/api/dashboard/dashboard_user.php?user=' + encodeURIComponent(username) + '&role=USR';});
                } else if(response === "USR"){
                Swal.fire({ icon: 'success', text: 'Login berhasil!', timer: 2000 })
                .then(() => { 
                    window.location = '/api/dashboard/dashboard_user.php?user=' + encodeURIComponent(username) + '&role=USR';
                });
                } else if(response === "WRONG_PASSWORD" || response === "USER_NOT_FOUND"){
                    Swal.fire({ icon: 'error', text: 'Username atau Password salah!' });
                } else {
                    Swal.fire({ icon: 'error', text: 'Terjadi kesalahan: ' + response });
                }
            },
            error: function(){
                Swal.fire({ icon: 'error', text: 'Terjadi kesalahan pada server' });
            }
        })
    })
})