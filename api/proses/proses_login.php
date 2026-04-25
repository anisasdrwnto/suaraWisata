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

            $roleMap = [
                'admin_master' => 'ADMIN_MASTER',
                'admin'        => 'ADMIN',
                'user'         => 'USR',
            ];

            echo $roleMap[$row['role']] ?? 'UNKNOWN';
        } else {
            echo 'WRONG_PASSWORD';
        }
    } else {
        echo 'USER_NOT_FOUND';
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo "DB_ERROR: " . $e->getMessage();
}
?>