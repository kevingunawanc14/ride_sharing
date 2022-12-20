<?php
require_once '../includes/connect.php';

$counter = $_POST['dataCounter'];

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


// select yang berdasarkan counter saat ini
$sql = 'SELECT * FROM live_update WHERE counter_update = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$counter]);

$rowLokasi = $checksql->fetch();

$valueResponse = array();

array_push($valueResponse, array(


    "lokasiUpdate" => "{$rowLokasi['lokasi']}",


));

echo json_encode($valueResponse);
