<?php
include $_SERVER['DOCUMENT_ROOT'] . '/api/koneksi.php';

$nama     = $_POST['nama']     ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$role     = 'USR';
$hash     = password_hash($password, PASSWORD_DEFAULT);

try {
    // 1. Cek username sudah ada
    $stmt = $connection->prepare("SELECT id_users FROM users WHERE username = ?");
    $stmt->execute([$username]);
    
    if ($stmt->rowCount() > 0) {
        echo 'username_exist';
        exit;
    }

    // 2. Generate id_users otomatis
    $stmt = $connection->prepare("SELECT id_users FROM users WHERE id_users LIKE 'USR%' ORDER BY id_users DESC LIMIT 1");
    $stmt->execute();
    $last = $stmt->fetchColumn();

    if ($last) {
        $num = (int) substr($last, 3) + 1;
    } else {
        $num = 1;
    }

    $id_users = 'USR' . str_pad($num, 4, '0', STR_PAD_LEFT);

    // 3. Insert user baru
    $stmt = $connection->prepare("INSERT INTO users (id_users, nama, username, password, role) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$id_users, $nama, $username, $hash, $role])) {
        echo 'success';
    } else {
        echo 'failed';
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo "DB Error: " . $e->getMessage();
}
?>