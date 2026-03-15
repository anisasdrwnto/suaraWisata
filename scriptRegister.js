$(document).ready(function () {
    $("#btnRegister").click(function () {

        //ambil nilai inputan
        var nama = $("#idNama").val();
        var username = $("#idUsername").val();
        var password = $("#idPassword").val();

        //simpan ke local
        localStorage.setItem("nama", nama);
        localStorage.setItem("username", username);
        localStorage.setItem("password", password);
        
        //notifikasi alert
        alert("Registrasi berhasil");


    })


})