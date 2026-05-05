<?php
session_start(); 
include $_SERVER['DOCUMENT_ROOT'] . '/api/koneksi.php';
header('Content-Type: application/json');

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

try {
    $stmt = $connection->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['id_users'] = $row['id_users'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role']     = $row['role'];

        echo json_encode([
            'status' => 'success',
            'role'   => $row['role']  // kirim role saja untuk keperluan redirect
        ]);

    } elseif ($row) {
        echo json_encode(['status' => 'error', 'message' => 'WRONG_PASSWORD']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'USER_NOT_FOUND']);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'DB_ERROR']);
}
?>