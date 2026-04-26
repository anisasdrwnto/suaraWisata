<?php
require __DIR__ . '/../koneksi.php';
header('Content-Type: application/json');

$action   = $_POST['action'] ?? $_GET['action'] ?? '';
$id_users = $_POST['id_users'] ?? $_GET['id_users'] ?? '';

if ($action == 'read') {

    $stmt = $connection->prepare("SELECT * FROM laporan_wisata WHERE id_users = ? ORDER BY id_laporan ASC");
    $stmt->execute([$id_users]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['status' => 'success', 'data' => $data]);

} else if ($action == 'getById') {

    $id   = $_GET['id'] ?? '';
    $stmt = $connection->prepare("SELECT * FROM laporan_wisata WHERE id_laporan = ? AND id_users = ?");
    $stmt->execute([$id, $id_users]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode(['status' => 'success', 'data' => $data]);

} else if ($action == 'create') {

    // Generate ID otomatis
    $stmt    = $connection->query("SELECT id_laporan FROM laporan_wisata ORDER BY id_laporan DESC LIMIT 1");
    $lastRow = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($lastRow) {
        $lastNum = (int) substr($lastRow['id_laporan'], 3); // 'LPR0001' → 1
        $newNum  = $lastNum + 1;
    } else {
        $newNum = 1;
    }

    $newId      = 'LPR' . str_pad($newNum, 4, '0', STR_PAD_LEFT);
    $nama       = $_POST['nama_pelapor'] ?? '';
    $no_telp    = $_POST['nomer_telp']   ?? '';
    $email      = $_POST['email']        ?? '';
    $lokasi     = $_POST['lokasi_wisata'] ?? '';
    $infoLokasi = $_POST['info_lokasi']  ?? '';
    $isi        = $_POST['isi_laporan']  ?? '';

    $stmt = $connection->prepare(
        "INSERT INTO laporan_wisata 
         (id_laporan, nama_pelapor, nomer_telp, email, lokasi_wisata, info_lokasi, isi_laporan, id_users)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );

    if ($stmt->execute([$newId, $nama, $no_telp, $email, $lokasi, $infoLokasi, $isi, $id_users])) {
        echo json_encode(['status' => 'success', 'message' => 'Laporan berhasil ditambahkan']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan laporan']);
    }

} else if ($action == 'update') {

    $id         = $_POST['id_laporan']   ?? '';
    $nama       = $_POST['nama_pelapor'] ?? '';
    $no_telp    = $_POST['nomer_telp']   ?? '';
    $email      = $_POST['email']        ?? '';
    $lokasi     = $_POST['lokasi_wisata'] ?? '';
    $infoLokasi = $_POST['info_lokasi']  ?? '';
    $isi        = $_POST['isi_laporan']  ?? '';

    $stmt = $connection->prepare(
        "UPDATE laporan_wisata SET
            nama_pelapor  = ?,
            nomer_telp    = ?,
            email         = ?,
            lokasi_wisata = ?,
            info_lokasi   = ?,
            isi_laporan   = ?
         WHERE id_laporan = ?
         AND id_users     = ?"
    );

    if ($stmt->execute([$nama, $no_telp, $email, $lokasi, $infoLokasi, $isi, $id, $id_users])) {
        echo json_encode(['status' => 'success', 'message' => 'Laporan berhasil diperbarui']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui laporan']);
    }

} else if ($action == 'delete') {

    $id   = $_POST['id'] ?? '';
    $stmt = $connection->prepare("DELETE FROM laporan_wisata WHERE id_laporan = ? AND id_users = ?");

    if ($stmt->execute([$id, $id_users])) {
        echo json_encode(['status' => 'success', 'message' => 'Laporan berhasil dihapus']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus laporan']);
    }

}
?>