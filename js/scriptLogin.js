$(document).ready(function(){
    // Taruh event listener DI LUAR click handler
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

    $('#btnLogin').click(function(e){
        e.preventDefault(); // ← INI KUNCI UTAMA, cegah form submit via GET

        var username = $('#idUsername').val().trim();
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

        if(isValid == 0) return;

        // Disable tombol biar ga double submit
        $('#btnLogin').prop('disabled', true);

        $.ajax({
            url : BASE_URL + 'proses/proses_login.php',
            type: 'POST',
            dataType: 'json',
            data: {
                username : username,
                password : password
            },
            success: function(data){
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        text: 'Login berhasil!',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function(){
                        // Redirect sesuai role
                        if (data.role === 'ADMIN_MASTER') {
                            window.location.replace(BASE_URL + 'dashboard/dashboard_master.php');
                        } else if (data.role === 'ADMIN') {
                            window.location.replace(BASE_URL + 'dashboard/dashboard_admin.php');
                        } else if (data.role === 'USR') {
                            window.location.replace(BASE_URL + 'dashboard/dashboard_user.php');
                        }
                    });
                } else {
                    Swal.fire({ icon: 'error', text: data.message || 'Username atau Password salah!' });
                    $('#btnLogin').prop('disabled', false);
                }
            },
            error: function(){
                Swal.fire({ icon: 'error', text: 'Terjadi kesalahan pada server' });
                $('#btnLogin').prop('disabled', false);
            }
        });
    });
});