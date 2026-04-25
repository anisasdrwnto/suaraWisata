<?php

$host     = 'gateway01.ap-southeast-1.prod.alicloud.tidbcloud.com';
$username = '28bs2jCJxPBCHff.root';  // Ganti dengan prefix asli kamu
$password = 'xGUugfYqG11ci1bk';    // Ganti dengan password asli
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