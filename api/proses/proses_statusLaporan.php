<?php
require __DIR__ . '/../koneksi.php';
header('Content-Type: application/json');

$action   = $_POST['action'] ?? $_GET['action'] ?? '';
$id_users = $_POST['id_users'] ?? $_GET['id_users'] ?? '';

if (empty($id_users)) {
    echo json_encode(['status' => 'error', 'message' => 'id_users tidak ditemukan']);
    exit;
}

if ($action == 'read') {
    $stmt = $connection->prepare(
        "SELECT id_laporan, nama_pelapor, lokasi_wisata, isi_laporan, 
                status, respons_admin, tgl_respons 
         FROM laporan_wisata 
         WHERE id_users = ? 
         ORDER BY id_laporan ASC"
    );
    $stmt->execute([$id_users]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['status' => 'success', 'data' => $data]);
}
?>