$(document).ready(function(){
    $('#btnLogin').click(function(e){
        e.preventDefault();
        
        var username = $('#idUsername').val();
        var password = $('#idPassword').val();

        if(username === "" || password === ""){
            Swal.fire({ icon: 'error', text: 'Semua inputan wajib diisi!' });
            return;
        }
        $.ajax({
            url : 'proses_login.php',
            type: 'POST',

            data: {
                username : username,
                password : password
            },

            success:function(response){
                    response = response.trim();
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
                        Swal.fire({ icon: 'error', text: 'Login gagal!' });
                    }
            },
            error:function(e){
                alert("Error : " + e)
            }
        })
    })
})