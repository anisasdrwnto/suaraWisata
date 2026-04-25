<?php

$host     = 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com';
$username = '2uskH12345.root';  // Ganti dengan prefix asli kamu
$password = 'your_password';    // Ganti dengan password asli
$dbname   = 'suara_wisata';
$port     = 4000;

// 1. Init koneksi
$connection = mysqli_init();

// 2. Set SSL dulu SEBELUM real_connect
mysqli_ssl_set($connection, NULL, NULL, NULL, NULL, NULL);

// 3. Baru connect
$real_connect = mysqli_real_connect(
    $connection,
    $host,
    $username,
    $password,
    $dbname,
    $port,
    NULL,
    MYSQLI_CLIENT_SSL
);

// 4. Cek koneksi
if (!$real_connect) {
    die("Koneksi ke TiDB Cloud gagal: " . mysqli_connect_error());
}
?>