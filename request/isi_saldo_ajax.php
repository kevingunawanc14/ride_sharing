<?php

require_once '../includes/connect.php';



$jumlahUang = $_POST["saldo"];
$uangUserSekarang = $_POST["saldoSekarang"];
$saldoTerbaru = $jumlahUang + $uangUserSekarang;

$sql = 'UPDATE user  SET saldo = ? WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$saldoTerbaru,$_SESSION["username"]]);

$sql = 'SELECT * FROM USER WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$_SESSION['username']]);

$row = $checksql->fetch();
// echo date("Y-m-d");


$tanggal = date("Y-m-d");


$sql = $sql = 'INSERT INTO `histori_isisaldo`(`id`, `tanggal`, `jumlah_uang`, `id_user`) VALUES (NULL, ?, ?, ?)';
$checksql = $pdo->prepare($sql);
$checksql->execute([$tanggal,$jumlahUang,$row['id']]);

?>



