$(document).ready(function () {
    $("#btnRegister").click(function (e) {
        e.preventDefault();
        //ambil nilai inputan
        var nama     = $("#idNama").val();
        var username = $("#idUsername").val();
        var password = $("#idPassword").val();
        var retypepas = $("#idRetypePass").val();
        // if(nama === "" || username === "" || password === ""){
        //     Swal.fire({ icon: 'error', text: 'Semua inputan wajib diisi!' });
        //     return;
        let isValid = 1;
        if(nama === ""){
            $('#idNama').addClass('is-invalid');
            $('#errorNama').html('Nama pengguna harus diisi');
            isValid = 0;
        }

        if(username === ""){
            $('#idUsername').addClass('is-invalid');
            $('#errorUsername').html('Username harus diisi');
            isValid = 0;
        }

        if(password === ""){
            $('#idPassword').addClass('is-invalid');
            $('#errorPassword').html('Password harus diisi');
            isValid = 0;
        }else if(password.length < 8){
            $('#idPassword').addClass('is-invalid');
            $('#errorPassword').html('Password harus berisi 8 karakter');
            isValid = 0;
        }else if(!/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^a-zA-Z0-9])/.test(password)){
            $('#idPassword').addClass('is-invalid');
            $('#errorPassword').html('Password harus mengandung huruf besar, huruf kecil, angka, dan karakter spesial');
            isValid = 0;
        }

        if(retypepas === ""){
            $('#idRetypePass').addClass('is-invalid');
            $('#errorRetypePass').html('Retype password harus diisi');
            isValid = 0;
        }else if(retypepas !== password){
            $('#idRetypePass').addClass('is-invalid');
            $('#errorRetypePass').html('Retype password tidak sesuai');
            isValid = 0;
        }

        $('#idNama').on('input', function(){
            if($(this).val() !== ''){
                $(this).removeClass('is-invalid');
                $('#errorNama').html('');
            }
        })

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

        $('#idRetypePass').on('input', function(){
            if($(this).val() !== ''){
                $(this).removeClass('is-invalid');
                $('#errorRetypePass').html('');
            }
        })

        if(isValid == 0) return;

        $.ajax({
            url : 'proses/proses_registrasi.php',
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