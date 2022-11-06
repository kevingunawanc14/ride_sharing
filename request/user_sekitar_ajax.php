<?php
require_once '../includes/connect.php';

//sql get status user buat tau ini user yang mana
$sql = 'SELECT * FROM user WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$_SESSION['username']]);

$row = $checksql->fetch();

$id = $row['id'];
$status = $row['status'];

// echo $id;

// ambil data lokasi berangkat user sesuai id
$sql = 'SELECT * FROM search_live WHERE id_user = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$id]);



$rowLokasi = $checksql->fetch();

$valueResponse = array();

array_push($valueResponse, array(


    "lokasiStartUserIni" => "{$rowLokasi['lokasi_berangkat']}",

    "lokasiEndUserIni" => "{$rowLokasi['lokasi_tujuan']}"


));




// ambil semua data lokasi berangkat
$sql = 'SELECT * FROM search_live WHERE id_user != ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$id]);




while ($rowLokasi = $checksql->fetch()) {
    // echo $row['lokasi_berangkat'];
    array_push($valueResponse, array(


        "lokasiStart" => "{$rowLokasi['lokasi_berangkat']}",
        "lokasiEnd" => "{$rowLokasi['lokasi_tujuan']}",


    ));

}


echo json_encode($valueResponse);





?>
