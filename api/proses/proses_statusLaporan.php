<?php
require '../koneksi.php';
header('Content-Type: application/json');

session_start();

if (!isset($_SESSION['id_users'])) {
    echo json_encode(['status' => 'error', 'message' => 'Session tidak ditemukan']);
    exit;
}

$action   = $_POST['action'] ?? $_GET['action'] ?? '';
$id_users = $_SESSION['id_users'];

if ($action == 'read') {

    $id_users_esc = mysqli_real_escape_string($connection, $id_users);
    $result       = mysqli_query($connection, 
        "SELECT id_laporan, nama_pelapor, lokasi_wisata, isi_laporan, 
                status, respons_admin, tgl_respons 
         FROM laporan_wisata 
         WHERE id_users = '$id_users_esc' 
         ORDER BY id_laporan ASC"
    );
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(['status' => 'success', 'data' => $data]);

}

mysqli_close($connection);
?>