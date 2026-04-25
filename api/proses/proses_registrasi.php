<?php
include $_SERVER['DOCUMENT_ROOT'] . '/api/koneksi.php';

$nama     = $_POST['nama']     ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$role     = 'USR';
$hash     = password_hash($password, PASSWORD_DEFAULT);

try {
    // Cek username sudah ada
    $stmt = $connection->prepare("SELECT id_users FROM users WHERE username = ?");
    $stmt->execute([$username]);
    
    if ($stmt->rowCount() > 0) {
        echo 'username_exist';
        exit;
    }

    // Insert user baru
    $stmt = $connection->prepare("INSERT INTO users (nama, username, password, role) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$nama, $username, $hash, $role])) {
        echo 'success';
    } else {
        echo 'failed';
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo "DB Error: " . $e->getMessage();
}
?>