<?php
$host   = 'gateway01.ap-southeast-1.prod.alicloud.tidbcloud.com';
$user   = '28bs2jCJxPBCHff.root';
$pass   = 'xGUugfYqG11ci1bk';
$dbname = 'suara_wisata';
$port   = 4000;

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $connection = new PDO($dsn, $user, $pass, [
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
        PDO::ATTR_ERRMODE                      => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT                      => 8,
        PDO::MYSQL_ATTR_INIT_COMMAND           => "SET NAMES utf8mb4"
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    die(json_encode(["error" => $e->getMessage()]));
}
?>