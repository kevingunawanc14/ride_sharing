<?php
require_once '../includes/connect.php';

//sql get status user buat tau ini user yang mana
$sql = 'SELECT * FROM user WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$_SESSION['username']]);

$row = $checksql->fetch();

$id = $row['id'];

// check driver yang mana dari suatu user
$sql = 'SELECT * FROM search_live WHERE id_user = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$id]);

$row = $checksql->fetch();

// ambil id driver user ini
$idDriverUserIni = $row['id_driver'];

// $data = $_POST['arr[]'];
$arr = json_decode($_POST['data'], true);


print_r($arr);

// echo $arr[0]['lokasiStartDriver'];
$counter = 0;

// insert ke lokasi start driver
for ($x = 0; $x <= 0; $x++) {
    // sql insert ke tabel order live
    $sql = 'INSERT INTO `live_update`(`id`, `lokasi`, `counter_update`, `id_driver`) 
    VALUES (NULL, ?, ?, ?)';
    $checksql = $pdo->prepare($sql);
    $checksql->execute([$arr[$x]['lokasiStartDriver'], $counter, $idDriverUserIni]);
    $counter+=1;
}

// insert ke lokasi start user
for ($x = 1; $x < count($arr); $x++) {
    // sql insert ke tabel order live
    $sql = 'INSERT INTO `live_update`(`id`, `lokasi`,  `counter_update`, `id_driver`) 
    VALUES (NULL, ?, ?, ?)';
    $checksql = $pdo->prepare($sql);
    $checksql->execute([$arr[$x]['lokasiStartUser'], $counter, $idDriverUserIni]);
    $counter+=1;

}

// insert ke lokasi tujuan user
for ($x = 1; $x < count($arr); $x++) {
    // sql insert ke tabel order live
    $sql = 'INSERT INTO `live_update`(`id`, `lokasi`, `counter_update`, `id_driver`) 
    VALUES (NULL, ?, ?, ?)';
    $checksql = $pdo->prepare($sql);
    $checksql->execute([$arr[$x]['lokasiEndUser'], $counter, $idDriverUserIni]);
    $counter+=1;

}

// insert ke lokasi tujuan driver
for ($x = 0; $x <= 0; $x++) {
    // sql insert ke tabel order live
    $sql = 'INSERT INTO `live_update`(`id`, `lokasi`,  `counter_update`, `id_driver`) 
    VALUES (NULL, ?, ?, ?)';
    $checksql = $pdo->prepare($sql);
    $checksql->execute([$arr[$x]['lokasiEndDriver'], $counter, $idDriverUserIni]);
    $counter+=1;

}
