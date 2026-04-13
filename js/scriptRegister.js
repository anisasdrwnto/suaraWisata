$(document).ready(function () {
    $("#btnRegister").click(function (e) {
        e.preventDefault();
        //ambil nilai inputan
        var nama     = $("#idNama").val();
        var username = $("#idUsername").val();
        var password = $("#idPassword").val();

        if(nama === "" || username === "" || password === ""){
            Swal.fire({ icon: 'error', text: 'Semua inputan wajib diisi!' });
            return;
        }

        $.ajax({
            url : 'proses_registrasi.php',
            type: 'POST',
            data: {
                nama     : nama,
                username : username,
                password : password
            },

            success:function(response){
                if(response === 'success'){
                    Swal.fire({
                        icon: 'success',
                        text: 'Register berhasil!',
                        timer: 2000
                    }).then(() => {
                        window.location = 'login.php';
                    }); 
                }else if(response.includes('username_exist')){
                      Swal.fire({ icon: 'error', text: 'Username sudah dipakai!' });
                }
            },
            error:function(e){
                   Swal.fire({ icon: 'error', text: 'Register gagal!' });
            }
        })


    })


})