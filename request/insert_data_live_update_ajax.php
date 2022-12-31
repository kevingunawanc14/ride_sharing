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
$arrLokasiTujuan = json_decode($_POST['dataLokasiTujuan'], true);

$arrLokasiBerangkat = $_POST['dataLokasiStart'];

print_r($arrLokasiTujuan);

print_r($arrLokasiBerangkat);


// echo $arr[0]['lokasiStartDriver'];
$counter = 0;

// insert ke lokasi start driver
for ($x = 0; $x <= 0; $x++) {
    // sql insert ke tabel order live
    $sql = 'INSERT INTO `live_update`(`id`, `lokasi`, `counter_update`, `id_driver`) 
    VALUES (NULL, ?, ?, ?)';
    $checksql = $pdo->prepare($sql);
    $checksql->execute([$arrLokasiBerangkat, $counter, $idDriverUserIni]);
    $counter+=1;
}

// insert ke lokasi tujuan
for ($x = 0; $x < count($arrLokasiTujuan); $x++) {
    // sql insert ke tabel order live
    $sql = 'INSERT INTO `live_update`(`id`, `lokasi`,  `counter_update`, `id_driver`) 
    VALUES (NULL, ?, ?, ?)';
    $checksql = $pdo->prepare($sql);
    $checksql->execute([$arrLokasiTujuan[$x], $counter, $idDriverUserIni]);
    $counter+=1;

}


