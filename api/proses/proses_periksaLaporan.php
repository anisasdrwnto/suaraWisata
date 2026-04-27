<?php
require '../koneksi.php';
header('Content-Type: application/json');

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action == 'read') {
    $stmt = $connection->query("SELECT * FROM laporan_wisata ORDER BY id_laporan ASC");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['status' => 'success', 'data' => $data]);

} else if ($action == 'getById') {
    $id   = $_GET['id'] ?? '';
    $stmt = $connection->prepare("SELECT * FROM laporan_wisata WHERE id_laporan = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode(['status' => 'success', 'data' => $data]);

} else if ($action == 'respons') {
    $id_laporan    = $_POST['id_laporan']    ?? '';
    $status        = $_POST['status']        ?? '';
    $respons_admin = $_POST['respons_admin'] ?? '';
    $tgl_respons   = date('Y-m-d H:i:s');

    $stmt = $connection->prepare(
        "UPDATE laporan_wisata SET
            status        = ?,
            respons_admin = ?,
            tgl_respons   = ?
         WHERE id_laporan = ?"
    );

    if ($stmt->execute([$status, $respons_admin, $tgl_respons, $id_laporan])) {
        echo json_encode(['status' => 'success', 'message' => 'Respons berhasil disimpan']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan respons']);
    }
}
?>