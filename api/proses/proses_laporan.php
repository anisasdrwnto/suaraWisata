<?php
require __DIR__ . '/../koneksi.php';
header('Content-Type: application/json');

$action = $_POST['action'] ?? $_GET['action'] ?? '';

// Mulai session sekali di atas
$id_users = $_POST['id_users'] ?? $_GET['id_users'] ?? '';

if ($action == 'read') {

    $result = mysqli_query($connection, "SELECT * FROM laporan_wisata WHERE id_users = '$id_users' ORDER BY id_laporan ASC");
    $data   = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(['status' => 'success', 'data' => $data]);

} else if ($action == 'getById') {
    $id     = mysqli_real_escape_string($connection, $_GET['id']);
    // Tambah AND id_users agar tidak bisa akses data orang lain
    $result = mysqli_query($connection, "SELECT * FROM laporan_wisata WHERE id_laporan = '$id' AND id_users = '$id_users'");
    $data   = mysqli_fetch_assoc($result);
    echo json_encode(['status' => 'success', 'data' => $data]);
} else if ($action == 'create') {

    // Generate ID otomatis
    $result  = mysqli_query($connection, "SELECT id_laporan FROM laporan_wisata ORDER BY id_laporan DESC LIMIT 1");
    $lastRow = mysqli_fetch_assoc($result);
    
    if ($lastRow) {
        $lastNum = (int) substr($lastRow['id_laporan'], 3); // 'LPR0001' → 1
        $newNum  = $lastNum + 1;
    } else {
        $newNum = 1;
    }
    
    $newId = 'LPR' . str_pad($newNum, 4, '0', STR_PAD_LEFT); // → LPR0001

    $nama       = mysqli_real_escape_string($connection, $_POST['nama_pelapor'] ?? '');
    $no_telp    = mysqli_real_escape_string($connection, $_POST['nomer_telp'] ?? '');
    $email      = mysqli_real_escape_string($connection, $_POST['email'] ?? '');
    $lokasi     = mysqli_real_escape_string($connection, $_POST['lokasi_wisata'] ?? '');
    $infoLokasi = mysqli_real_escape_string($connection, $_POST['info_lokasi'] ?? '');
    $isi        = mysqli_real_escape_string($connection, $_POST['isi_laporan'] ?? '');

    $sql = "INSERT INTO laporan_wisata 
            (id_laporan, nama_pelapor, nomer_telp, email, lokasi_wisata, info_lokasi, isi_laporan, id_users)
            VALUES ('$newId', '$nama', '$no_telp', '$email', '$lokasi', '$infoLokasi', '$isi', '$id_users')";

    if (mysqli_query($connection, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Laporan berhasil ditambahkan']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($connection)]);
    }
}
else if ($action == 'update') {

    $id         = mysqli_real_escape_string($connection, $_POST['id_laporan']);
    $nama       = mysqli_real_escape_string($connection, $_POST['nama_pelapor']);
    $no_telp    = mysqli_real_escape_string($connection, $_POST['nomer_telp'] ?? '');
    $email      = mysqli_real_escape_string($connection, $_POST['email']);
    $lokasi     = mysqli_real_escape_string($connection, $_POST['lokasi_wisata']);
    $infoLokasi = mysqli_real_escape_string($connection, $_POST['info_lokasi']);
    $isi        = mysqli_real_escape_string($connection, $_POST['isi_laporan']);

    $sql = "UPDATE laporan_wisata SET
                nama_pelapor  = '$nama',
                nomer_telp    = '$no_telp',
                email         = '$email',
                lokasi_wisata = '$lokasi',
                info_lokasi   = '$infoLokasi',
                isi_laporan   = '$isi'
            WHERE id_laporan  = '$id'
            AND id_users      = '$id_users'";
            // ↑ Tambah AND id_users agar tidak bisa update data orang lain

    if (mysqli_query($connection, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Laporan berhasil diperbarui']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($connection)]);
    }

} else if ($action == 'delete') {

    $id = mysqli_real_escape_string($connection, $_POST['id']);

    $sql = "DELETE FROM laporan_wisata WHERE id_laporan = '$id' AND id_users = '$id_users'";
    // ↑ Tambah AND id_users agar tidak bisa hapus data orang lain

    if (mysqli_query($connection, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Laporan berhasil dihapus']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($connection)]);
    }

}

mysqli_close($connection);
?>