<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method tidak diizinkan']);
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/api/koneksi.php';

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'INPUT_EMPTY']);
    exit;
}

try {
    // Sesuaikan nama kolom & tabel dengan database kamu
    $stmt = $connection->prepare("SELECT id_users, username, password, role FROM users WHERE username = ? LIMIT 1");
    $stmt->execute([$username]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($password, $row['password'])) {

        session_regenerate_id(true);

        $_SESSION['id_users'] = $row['id_users'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role']     = $row['role'];

        echo json_encode([
            'status' => 'success',
            'role'   => $row['role']
        ]);

    } else {
        // Pesan digabung biar attacker ga bisa tebak username valid/tidak
        echo json_encode(['status' => 'error', 'message' => 'Username atau password salah']);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'DB_ERROR']);
}
exit;