<?php
require __DIR__ . '/koneksi.php';

$query = "SELECT nama_pelapor, isi_laporan 
          FROM laporan_wisata
          ORDER BY id_laporan ASC";

$result = mysqli_query($conn, $query);

$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>