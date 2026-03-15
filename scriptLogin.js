$(document).ready(function () {
    $("#btnLogin").click(function () {

        //ambil nilai inputan
        var username = $("#idUsername").val();
        var password = $("#idPassword").val();

        //simpan ke penyimpanan local
        var saveusername = localStorage.getItem("idUsername");
        var savepassword = localStorage.getItem("idPassword");
       
        localStorage.setItem("idUsername", username);
        localStorage.setItem("idPassword", password);

        if(username === "" && password === ""){
            alert("Username dan password perlu diisi");
        }else if(username === saveusername && password === savepassword) {
            alert("Login berhasil");
            window.location.href = "index.html";
        } else {
            alert("Username atau password salah");
        }

    })


})