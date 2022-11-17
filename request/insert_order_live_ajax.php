<?php
require_once '../includes/connect.php';

$username = $_POST["username"];

//sql ambil id_user
$sql = 'SELECT * FROM user WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$username]);

$row = $checksql->fetch();

$idUser = $row['id'];

// sql ambil id_driver
$sql = 'SELECT * FROM user WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$_SESSION['username']]);

$row = $checksql->fetch();

$idDriver = $row['id'];
$kapasitasMobil = $row['kapasitas'];

$kapasitasMobil=$kapasitasMobil-1;


//sql insert ke tabel order live
$sql = 'INSERT INTO `order_live`(`id`, `id_user`, `id_driver`, `kapasitas`) 
VALUES (NULL, ?, ?, ?)';
$checksql = $pdo->prepare($sql);
$checksql->execute([$idUser, $idDriver, $kapasitasMobil]);


// update kapasitas mobile



exit ("order live almost ready");
?>