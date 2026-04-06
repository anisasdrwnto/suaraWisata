<?php 
include 'koneksi.php';

if(isset($_POST['register'])){
    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    //Enkripsi password untuk keamanan
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    //Cek apakah username sudah ada
    $cekUsername = mysqli_query($connection, "SELECT username FROM users WHERE username = '$username'");

    if(mysqli_num_rows($cekUsername) > 0){
        echo "Username sudah digunakan! <a href='register.php'>Kembali</a>";
    }else{
        //Insert data ke database
        $query = "INSERT INTO users (nama, username, password) VALUES ('$nama', '$username', '$password')";
        if(mysqli_query($connection, $query)){
            ?>
            <script>
                alert('Registrasi berhasil!');
                window.location.href = 'login.php';
            </script>
            <?php
            exit;
        }else{
            echo "Error: " . mysqli_error($connection);
        }
    }
}

?>