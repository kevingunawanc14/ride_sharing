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

// sql insert ke tabel permutasi array
$sql = 'INSERT INTO `permutasi_array`(`id`, `indexArray`, `total`, `id_driver`) 
VALUES (NULL, ?, ?, ?)';
$checksql = $pdo->prepare($sql);
$checksql->execute([$arr[0]['lokasiStartDriver'], $indexArray, $total,$idDriverUserIni]);


