<?php
require_once '../includes/connect.php';

$username = $_POST["username"];
$password = $_POST["password"]; 





// cek panjang password max 20
if(strlen($password) > 20){
    exit("Password Terlalu Panjang Max 20 Karakater");
}

//cek panjang username max 20
if(strlen($username) > 20){
    exit("Username Terlalu Panjang Max 20 Karakater");
}



// cek username
$sql = 'SELECT * FROM user';
$checksql = $pdo->prepare($sql);
$checksql->execute();


while ($row = $checksql->fetch()) {

    
    if ($row['nama'] ==  $username) {

        exit("Maaf Username Tersebut Sudah Terpakai");

    }

}






// add username,password ke database
$sql = 'INSERT INTO `user`(`id`, `nama`, `password`, `rank`, `rating`) VALUES (NULL, ?, ?, ?, ?)';
$checksql = $pdo->prepare($sql);
$checksql->execute([$username, $password, "COW 1", 0]);



exit ("Akun Berhasil Di Buat Silakan Login");



?>