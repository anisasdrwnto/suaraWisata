<?php
require __DIR__ . '/../koneksi.php';
header('Content-Type: application/json');

// Ganti session dengan $_GET karena session tidak jalan di Vercel
$action   = $_POST['action'] ?? $_GET['action'] ?? '';
$id_users = $_POST['id_users'] ?? $_GET['id_users'] ?? '';

if (empty($id_users)) {
    echo json_encode(['status' => 'error', 'message' => 'id_users tidak ditemukan']);
    exit;
}

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