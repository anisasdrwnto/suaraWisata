<?php

session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/api/koneksi.php';;

$username = $_POST['username'];
$password = $_POST['password'];


// $result = mysqli_query($connection, "SELECT * FROM users WHERE username = '$username'");
$statement = $connection->prepare("SELECT * FROM users WHERE username = ?");
$statement->bind_param("s", $username);
$statement->execute();
$result = $statement->get_result();
if($row = $result->fetch_assoc()){
    if(password_verify($password, $row['password'])){
        $_SESSION['id_users'] = $row['id_users'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role']     = $row['role'];
       
        echo $row['role'];
    }else{
        echo 'Username atau Password Salah';
    }
}else{
    echo 'Koneksi terputus,silahkan dicoba lagi';
}

?>