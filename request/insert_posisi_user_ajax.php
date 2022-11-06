<?php
require_once '../includes/connect.php';

$lokasiStart = $_POST["lokasiStart"];
$lokasiEnd = $_POST["lokasiEnd"];

//sql get status user buat tau ini user yang mana
$sql = 'SELECT * FROM USER WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$_SESSION['username']]);

$row = $checksql->fetch();

$id = $row['id'];
$status = $row['status'];

//sql insert ke tabel search live
$sql = 'INSERT INTO `search_live`(`id`, `lokasi_berangkat`, `lokasi_tujuan`, `id_user`, `status`) 
VALUES (NULL, ?, ?, ?, ?)';
$checksql = $pdo->prepare($sql);
$checksql->execute([$lokasiStart, $lokasiEnd, $id, $status]);



?>
