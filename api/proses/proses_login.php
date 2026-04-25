<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/api/koneksi.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

try {
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
        echo 'User tidak ditemukan';
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo "DB Error: " . $e->getMessage();
}
?>