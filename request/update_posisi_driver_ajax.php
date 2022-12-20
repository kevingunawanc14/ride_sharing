<?php
require_once '../includes/connect.php';

//sql get status user buat tau ini user yang mana
$sql = 'SELECT * FROM user WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$_SESSION['username']]);

$row = $checksql->fetch();

$id = $row['id'];


$sql = 'SELECT * FROM search_live WHERE id_user = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$id]);

$row = $checksql->fetch();

// ambil id driver user ini
$idDriverUserIni = $row['id_driver'];

// echo $idDriverUserIni;

$valueResponse = array();

// ambil lokasi berangkat driver dahulu karena start dari posisi driver
$sql = 'SELECT * FROM search_live WHERE id_user = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$idDriverUserIni]);

while ($row = $checksql->fetch()) {
    array_push($valueResponse, array(

        "lokasiStartDriver" => "{$row['lokasi_berangkat']}",
        "lokasiEndDriver" => "{$row['lokasi_tujuan']}"

    ));
}

// ambil lokasi berangkat user lain
$sql = 'SELECT * FROM search_live WHERE id_driver = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$idDriverUserIni]);

while ($row = $checksql->fetch()) {
    // echo $row['lokasi_berangkat'];
    array_push($valueResponse, array(

        "lokasiStartUser" => "{$row['lokasi_berangkat']}",
        "lokasiEndUser" => "{$row['lokasi_tujuan']}"

    ));
}

echo json_encode($valueResponse);
