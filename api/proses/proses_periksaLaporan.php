<?php
require '../koneksi.php';
header('Content-Type: application/json');
 
session_start();
 
// Hanya ADMIN dan ADMIN_MASTER yang boleh akses
if (!isset($_SESSION['ROLE']) || ($_SESSION['ROLE'] !== 'ADMIN' && $_SESSION['ROLE'] !== 'ADMIN_MASTER')) {
    echo json_encode(['status' => 'error', 'message' => 'Akses ditolak']);
    exit;
}
 
$action = $_POST['action'] ?? $_GET['action'] ?? '';
 
if ($action == 'read') {
    $result = mysqli_query($connection, "SELECT * FROM laporan_wisata ORDER BY id_laporan ASC");
    $data   = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(['status' => 'success', 'data' => $data]);
 
} else if ($action == 'getById') {
 
    $id     = mysqli_real_escape_string($connection, $_GET['id']);
    $result = mysqli_query($connection, "SELECT * FROM laporan_wisata WHERE id_laporan = '$id'");
    $data   = mysqli_fetch_assoc($result);
    echo json_encode(['status' => 'success', 'data' => $data]);
 
} else if ($action == 'respons') {
 
    $id_laporan    = mysqli_real_escape_string($connection, $_POST['id_laporan']);
    $status        = mysqli_real_escape_string($connection, $_POST['status']);
    $respons_admin = mysqli_real_escape_string($connection, $_POST['respons_admin']);
    $id_admin      = $_SESSION['id_users'];
    $tgl_respons   = date('Y-m-d H:i:s');
 
    $sql = "UPDATE laporan_wisata SET
                status        = '$status',
                respons_admin = '$respons_admin',
                tgl_respons   = '$tgl_respons',
                id_admin      = '$id_admin'
            WHERE id_laporan  = '$id_laporan'";
 
    if (mysqli_query($connection, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Respons berhasil disimpan']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($connection)]);
    }
 
}
 
mysqli_close($connection);
?>