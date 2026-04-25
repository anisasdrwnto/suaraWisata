<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/api/koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $connection->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    if (password_verify($password, $row['password'])) {
        $_SESSION['id_users'] = $row['id_users'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role']     = $row['role'];
        echo $row['role'];
    } else {
        echo 'Username atau Password Salah';
    }
} else {
    echo 'Koneksi terputus, silahkan dicoba lagi';
}
?>