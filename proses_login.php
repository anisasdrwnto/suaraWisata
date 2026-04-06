<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL Injection Prevention (Prepared Statement)
    $stmt = $connection->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Simpan data ke session SETELAH $user ada
        $_SESSION['username'] = $user['username'];
        $_SESSION['nama']     = $user['nama'];   // simpan nama di sini
        header("Location: dashboard.php");

    } else {
        echo "<script>
                alert('Username atau password salah');
                window.location.href = 'login.php';
              </script>";
    }
}
?>