<?php
header('Content-Type: application/json');

require __DIR__ . '/koneksi.php';

if (!$conn) {
    die(json_encode(["error" => "Koneksi database gagal"]));
}

$query = "SELECT nama_pelapor, isi_laporan 
          FROM laporan_wisata
          ORDER BY id_laporan ASC";

$result = mysqli_query($conn, $query);

if (!$result) {
    die(json_encode(["error" => mysqli_error($conn)]));
}

$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>