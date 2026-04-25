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

            success:function(response){
                    response = response.trim();
                    console.log("RESPONSE:", response); // ← tambahkan ini
                    if(response === "ADMIN_MASTER"){
                            Swal.fire({
                            icon: 'success',
                            text: 'Login berhasil!',
                            timer: 2000
                        }).then(() => {
                            window.location = 'dashboard/dashboard_master.php';  
                        }); 
                    }else if(response === "ADMIN"){
                        Swal.fire({
                            icon: 'success',
                            text: 'Login berhasil!',
                            timer: 2000
                        }).then(() => {
                            window.location = 'dashboard/dashboard_admin.php';
                        }); 
                    }else if(response === "USR"){
                        Swal.fire({
                            icon: 'success',
                            text: 'Login berhasil!',
                            timer: 2000
                        }).then(() => {
                           window.location = 'dashboard/dashboard_user.php';
                        }); 
                    }else{
                        Swal.fire({ icon: 'error', text: 'Login gagal' });
                    }
            },
            error: function(e){
            alert("Error : " + e.status + " - " + e.responseText);
        }
                })
    })
})