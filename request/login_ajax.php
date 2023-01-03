<?php
require_once '../includes/connect.php';



$password = $_POST['password'];
$username = $_POST['username'];


// cek username
$sql = 'SELECT * FROM user WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$_POST['username']]);

$cekUsername= false;
$cekPassword= false;

while ($row = $checksql->fetch()) {

    $_SESSION["status"]=$row["status"];
    
    if ($row['username'] ==  $username) {
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

echo $_SESSION["status"];

// exit ("Login Berhasil");
?>