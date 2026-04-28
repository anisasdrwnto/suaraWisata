<?php
header('Content-Type: application/json');

require __DIR__ . '/koneksi.php';

try {
    $stmt = $connection->prepare("
        SELECT nama_pelapor, info_lokasi, isi_laporan
        FROM laporan_wisata
        ORDER BY id_laporan ASC
    ");

    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);

} catch (Exception $e) {
    echo json_encode([
        "error" => $e->getMessage()
    ]);
}
?>