<?php
require 'koneksi.php';
header('Content-Type: application/json');

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

} else if ($action == 'create') {

    session_start();
    $id_users = $_SESSION['id_users'];
    $nama   = mysqli_real_escape_string($connection, $_POST['nama_pelapor']);
    $alamat = mysqli_real_escape_string($connection, $_POST['alamat_pelapor']);
    $lokasi = mysqli_real_escape_string($connection, $_POST['lokasi_wisata']);
    $isi    = mysqli_real_escape_string($connection, $_POST['isi_laporan']);

    $data = array(
        'action'         => $action,
        'nama_pelapor'   => $nama,
        'alamat_pelapor' => $alamat,
        'lokasi_wisata'  => $lokasi,
        'isi_laporan'    => $isi
    );

    $sql = "INSERT INTO laporan_wisata (nama_pelapor, alamat_pelapor, lokasi_wisata, isi_laporan, id_users)
            VALUES ('$nama', '$alamat', '$lokasi', '$isi', '$id_users')";

    if (mysqli_query($connection, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Laporan berhasil ditambahkan']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($connection)]);
    }

} else if ($action == 'update') {

    $id     = mysqli_real_escape_string($connection, $_POST['id_laporan']);
    $nama   = mysqli_real_escape_string($connection, $_POST['nama_pelapor']);
    $alamat = mysqli_real_escape_string($connection, $_POST['alamat_pelapor']);
    $lokasi = mysqli_real_escape_string($connection, $_POST['lokasi_wisata']);
    $isi    = mysqli_real_escape_string($connection, $_POST['isi_laporan']);

    $data = array(
        'action'         => $action,
        'id_laporan'     => $id,
        'nama_pelapor'   => $nama,
        'alamat_pelapor' => $alamat,
        'lokasi_wisata'  => $lokasi,
        'isi_laporan'    => $isi
    );

    $sql = "UPDATE laporan_wisata SET
                nama_pelapor   = '$nama',
                alamat_pelapor = '$alamat',
                lokasi_wisata  = '$lokasi',
                isi_laporan    = '$isi'
            WHERE id_laporan   = '$id'";

    if (mysqli_query($connection, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Laporan berhasil diperbarui']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($connection)]);
    }

} else if ($action == 'delete') {

    $id = mysqli_real_escape_string($connection, $_POST['id']);

    $data = array(
        'action'     => $action,
        'id_laporan' => $id
    );

    $sql = "DELETE FROM laporan_wisata WHERE id_laporan = '$id'";

    if (mysqli_query($connection, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Laporan berhasil dihapus']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($connection)]);
    }

}

mysqli_close($connection);
?>