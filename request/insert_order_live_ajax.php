<?php
require_once '../includes/connect.php';

//sql insert ke tabel order live
$sql = 'INSERT INTO `search_live`(`id`, `lokasi_berangkat`, `lokasi_tujuan`, `id_user`, `status`) 
VALUES (NULL, ?, ?, ?, ?)';
$checksql = $pdo->prepare($sql);
$checksql->execute([$lokasiStart, $lokasiEnd, $id, $status]);






exit ("order live almost ready");
?>