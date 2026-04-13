<?php
require 'koneksi.php';
header('Content-Type: application/json');

session_start();

// Hanya ADMIN_MASTER yang boleh akses
if (!isset($_SESSION['ROLE']) || $_SESSION['ROLE'] !== 'ADMIN_MASTER') {
    echo json_encode(['status' => 'error', 'message' => 'Akses ditolak']);
    exit;
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

// Generate ID user otomatis
function generateIdUser($connection) {
    $result = mysqli_query($connection, "SELECT id_users FROM users ORDER BY id_users DESC LIMIT 1");
    if ($row = mysqli_fetch_assoc($result)) {
        $lastNum = (int) substr($row['id_users'], 3);
        $newNum  = $lastNum + 1;
    } else {
        $newNum = 1;
    }
    return 'USR' . str_pad($newNum, 4, '0', STR_PAD_LEFT);
}

if ($action == 'read') {

    $result = mysqli_query($connection, "SELECT id_users, nama, username, ROLE FROM users ORDER BY id_users ASC");
    $data   = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(['status' => 'success', 'data' => $data]);

} else if ($action == 'getById') {

    $id     = mysqli_real_escape_string($connection, $_GET['id']);
    $result = mysqli_query($connection, "SELECT id_users, nama, username, ROLE FROM users WHERE id_users = '$id'");
    $data   = mysqli_fetch_assoc($result);
    echo json_encode(['status' => 'success', 'data' => $data]);

} else if ($action == 'create') {

    $id_users = generateIdUser($connection);
    $nama     = mysqli_real_escape_string($connection, $_POST['nama']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = mysqli_real_escape_string($connection, $_POST['role']);

    // Cek username sudah ada atau belum
    $cek = mysqli_query($connection, "SELECT id_users FROM users WHERE username = '$username'");
    if (mysqli_num_rows($cek) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Username sudah digunakan!']);
        exit;
    }

    $sql = "INSERT INTO users (id_users, nama, username, password, ROLE)
            VALUES ('$id_users', '$nama', '$username', '$password', '$role')";

    if (mysqli_query($connection, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'User berhasil ditambahkan']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($connection)]);
    }

} else if ($action == 'update') {

    $id_users = mysqli_real_escape_string($connection, $_POST['id_users']);
    $nama     = mysqli_real_escape_string($connection, $_POST['nama']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $role     = mysqli_real_escape_string($connection, $_POST['role']);
    $password = $_POST['password'] ?? '';

    // Cek username sudah dipakai user lain
    $cek = mysqli_query($connection, "SELECT id_users FROM users WHERE username = '$username' AND id_users != '$id_users'");
    if (mysqli_num_rows($cek) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Username sudah digunakan user lain!']);
        exit;
    }

    // Jika password diisi, update password juga
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET nama = '$nama', username = '$username', password = '$hashedPassword', ROLE = '$role' WHERE id_users = '$id_users'";
    } else {
        $sql = "UPDATE users SET nama = '$nama', username = '$username', ROLE = '$role' WHERE id_users = '$id_users'";
    }

    if (mysqli_query($connection, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'User berhasil diperbarui']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($connection)]);
    }

} else if ($action == 'delete') {

    $id = mysqli_real_escape_string($connection, $_POST['id_users']);

    // Tidak boleh hapus diri sendiri
    if ($id === $_SESSION['id_users']) {
        echo json_encode(['status' => 'error', 'message' => 'Tidak bisa menghapus akun sendiri!']);
        exit;
    }

    $sql = "DELETE FROM users WHERE id_users = '$id'";

    if (mysqli_query($connection, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'User berhasil dihapus']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($connection)]);
    }

}

mysqli_close($connection);
?>