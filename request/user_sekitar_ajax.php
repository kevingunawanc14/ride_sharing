<?php
require_once '../includes/connect.php';

$lokasi_awal = $_POST["lokasi_awal"];
$lokasi_tujuan = "x";

//sql get status user
$sql = 'SELECT * FROM USER WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$_SESSION['username']]);

$row = $checksql->fetch();

// echo $row['status'];
$id = $row['id'];
$status = $row['status'];

// echo $id;
// echo $status;

//sql insert
// $sql = 'INSERT INTO `search_live`(`id`, `lokasi_berangkat`, `lokasi_tujuan`, `id_user`, `status`) 
// VALUES (NULL, ?, ?, ?, ?)';
// $checksql = $pdo->prepare($sql);
// $checksql->execute([$lokasi_awal, $lokasi_tujuan, $id, $status]);


// ambil semua data lokasi berangkat
$sql = 'SELECT * FROM search_live ';
$checksql = $pdo->prepare($sql);
$checksql->execute();


$valueResponse = array();

while ($rowLokasi = $checksql->fetch()) {
    // echo $row['lokasi_berangkat'];
    array_push($valueResponse, array(


        "lokasi_berangkat" => "{$rowLokasi['lokasi_berangkat']}"



    ));

}



echo json_encode($valueResponse);
