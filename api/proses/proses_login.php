<?php
session_start();
header('Content-Type: application/json');

// Tolak request selain POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Method tidak diizinkan']);
    exit;
}

require_once '../api/koneksi.php'; // Sesuaikan path

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Validasi input kosong
if (empty($username) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Username dan password harus diisi']);
    exit;
}

// Gunakan prepared statement, JANGAN string concat langsung
$stmt = $conn->prepare("SELECT id, username, password, role FROM tb_users WHERE username = ? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verifikasi password hash (PASTIKAN saat register pakai password_hash())
    if (password_verify($password, $user['password'])) {
        // Regenerate session ID biar aman dari session fixation
        session_regenerate_id(true);

        $_SESSION['id']       = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role']     = $user['role'];

        echo json_encode([
            'status' => 'success',
            'role'   => $user['role']
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Username atau Password salah!']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Username atau Password salah!']);
}

$stmt->close();
$conn->close();
exit;