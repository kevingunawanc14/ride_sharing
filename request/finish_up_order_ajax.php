<?php
require_once '../includes/connect.php';

$biaya =  $_POST["biaya"];
$lokasiAsal =  $_POST["lokasiAsal"];
$lokasiTujuan =  $_POST["lokasiTujuan"];

// ambil data saldo terbaru setelah diupdate
$sql = 'SELECT * FROM USER WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$_SESSION['username']]);

$row = $checksql->fetch();

$idUser = $row['id'];

// insert ke histori_isisaldo
$tanggal = date("Y-m-d");
$sql = $sql = 'INSERT INTO `transaksi`(`id`, `tanggal`, `biaya`, `id_user`) VALUES (NULL, ?, ?, ?)';
$checksql = $pdo->prepare($sql);
$checksql->execute([$tanggal,$biaya,$idUser]);

// insert ke histori_isisaldo
$tanggal = date("Y-m-d");
$sql = $sql = 'INSERT INTO `history`(`id`, `biaya`, `lokasi_berangkat`, `lokasi_tujuan`, `id_user`) VALUES (NULL, ?, ?, ?, ?)';
$checksql = $pdo->prepare($sql);
$checksql->execute([$biaya,$lokasiAsal,$lokasiTujuan,$idUser]);

echo $biaya;
echo $lokasiAsal;
echo $lokasiTujuan;
