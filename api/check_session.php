<?php
session_start();

//Membuat response file JSON
header("Content-Type: application/json");
//memastikan bahwa tidak menytimpan cache response
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

//mengecek apakah ada data usernamenya atau tidak,lalu kirim dalam format JSON true/false
//kalau true--> tetap di dashboard,kalau false redirect ke index.php
echo json_encode([
    'loggedIn' => isset($_SESSION['username'])
]);
?>