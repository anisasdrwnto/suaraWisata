<?php 
include '../koneksi.php';


    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role     = 'USR';

    $hash     = password_hash($password, PASSWORD_DEFAULT);

    $statement = $connection->prepare("SELECT id_users FROM users WHERE username = ?");
    $statement->bind_param("s", $username);
    $statement->execute();
    $statement->store_result();

    if($statement->num_rows > 0){
        echo 'username_exist';
        exit;
    }else{
        $statement = $connection->prepare("INSERT INTO users (nama, username, password, role) VALUES (?, ?, ?, ?)");
        $statement->bind_param("ssss", $nama, $username, $hash, $role);
        if($statement->execute()){
            echo 'success';
        }else{
            echo 'failed'. $statement->error;
        }
    }
   


?>