<?php
require_once '../includes/connect.php';

$password = $_POST['password'];
$username = $_POST['username'];


// cek username
$sql = 'SELECT * FROM user';
$checksql = $pdo->prepare($sql);
$checksql->execute();

$cekUsername= false;
$cekPassword= false;

while ($row = $checksql->fetch()) {

    
    if ($row['nama'] ==  $username) {
        $cekUsername =  true;

    }

    if ($row['password'] ==  $password) {

        $cekPassword =  true;


    }
}

if($cekUsername == false || $cekPassword == false){
    exit("Maaf Username / Password Anda Salah");
}





$_SESSION["username"] = $username;

exit ("Login Berhasil");


?>