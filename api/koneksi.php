<?php

$servername = "localhost";
$database   = "suarawisata";
$username   = "root";
$password   = "";


//Create connection
$connection = mysqli_connect($servername, $username, $password, $database);

//Cek koneksi
if(!$connection){
    echo("Koneksi gagal: " . mysqli_connect_error());
}


?>