<?php
session_start();

//hapus semua variabel di dalam session
session_unset();
//menghancurkan session
session_destroy();


//hapus cookie session
if (ini_get("session.use_cookies")) { //cek apakah session pakai cookie
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, //hapuscookie
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

//redirect balik ke index.php
header("Location: index.php");
exit;
?>