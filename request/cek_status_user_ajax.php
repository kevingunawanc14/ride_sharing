<?php
require_once '../includes/connect.php';

//sql get status user buat tau ini user yang mana
$sql = 'SELECT * FROM USER WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$_SESSION['username']]);

$row = $checksql->fetch();

$id = $row['id'];

// sql check status sudah dipick up atau belum
$sql = 'SELECT * FROM search_live WHERE id_user = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$id]);

$row = $checksql->fetch();

$valueResponse = array();


array_push($valueResponse, array(


    "status" => "{$row['id_driver']}"


));


echo json_encode($valueResponse);

// exit ("Cek Biaya Berhasil");

?>

