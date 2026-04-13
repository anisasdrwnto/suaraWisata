<?php
require 'koneksi.php';
header('Content-Type: application/json');

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action == 'read') {

    $result = mysqli_query($connection, "SELECT * FROM role ORDER BY id_role ASC");
    $data   = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(['status' => 'success', 'data' => $data]);

} else if ($action == 'getById') {

    $id     = mysqli_real_escape_string($connection, $_GET['id']);
    $result = mysqli_query($connection, "SELECT * FROM role WHERE id_role = '$id'");
    $data   = mysqli_fetch_assoc($result);
    echo json_encode(['status' => 'success', 'data' => $data]);

} else if ($action == 'create') {

    $code_role = mysqli_real_escape_string($connection, $_POST['code_role']);
    $nama_role  = mysqli_real_escape_string($connection, $_POST['nama_role']);
   

    $data = array(
        'action'         => $action,
        'code_role'      => $code_role,
        'nama_role'      => $nama_role
    );

    $sql = "INSERT INTO role (code_role, nama_role, isActive)
            VALUES ('$code_role', '$nama_role', 1)";

    if (mysqli_query($connection, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Role berhasil ditambahkan']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($connection)]);
    }

} else if ($action == 'update') {

    $id_role     = mysqli_real_escape_string($connection, $_POST['id_role']);
    $code_role   = mysqli_real_escape_string($connection, $_POST['code_role']);
    $nama_role = mysqli_real_escape_string($connection, $_POST['nama_role']);
   
    $data = array(
        'action'         => $action,
        'id_role'        => $id_role,
        'code_role'      => $code_role,
        'nama_role'      => $nama_role,
    );

    $sql = "UPDATE role SET
                code_role      = '$code_role',
                nama_role      = '$nama_role'
            WHERE id_role      = '$id_role'";

    if (mysqli_query($connection, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Role berhasil diperbarui']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($connection)]);
    }

} else if ($action == 'delete') {

    $id = mysqli_real_escape_string($connection, $_POST['id']);

    $data = array(
        'action'     => $action,
        'id_role'    => $id
    );

    $sql = "DELETE FROM role WHERE id_role = '$id'";

    if (mysqli_query($connection, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Role berhasil dihapus']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($connection)]);
    }

}

mysqli_close($connection);
?>