<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host     = 'gateway01.ap-southeast-1.prod.alicloud.tidbcloud.com';
$username = '28bs2jCJxPBCHff.root';
$password = 'xGUugfYqG11ci1bk';
$dbname   = 'suara_wisata';
$port     = 4000;

$connection = mysqli_init();
mysqli_ssl_set($connection, NULL, NULL, NULL, NULL, NULL);

$result = mysqli_real_connect(
    $connection,
    $host,
    $username,
    $password,
    $dbname,
    $port,
    NULL,
    MYSQLI_CLIENT_SSL
);

if (!$result) {
    echo "GAGAL: " . mysqli_connect_errno() . " - " . mysqli_connect_error();
} else {
    echo "KONEKSI BERHASIL! ✅";
    mysqli_close($connection);
}
?>