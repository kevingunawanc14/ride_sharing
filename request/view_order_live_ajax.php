<?php
require_once '../includes/connect.php';

//sql get status user buat tau ini user yang mana
$sql = 'SELECT * FROM user WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$_SESSION['username']]);

$row = $checksql->fetch();

$id = $row['id'];
$status = $row['status'];


// ambil data lokasi berangkat,tujuan driver sesuai session
$sql = 'SELECT * FROM search_live WHERE id_user = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$id]);



$rowLokasi = $checksql->fetch();

$valueResponse = array();

array_push($valueResponse, array(


    "lokasiStartDriverIni" => "{$rowLokasi['lokasi_berangkat']}",

    "lokasiEndDriverIni" => "{$rowLokasi['lokasi_tujuan']}"


));



// ambil data lokasi berangkat,tujuan user yang ikut driver ini 
$sql = 'SELECT * FROM search_live WHERE id_driver = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$id]);


while ($rowLokasi = $checksql->fetch()) {
    // echo $row['lokasi_berangkat'];
    array_push($valueResponse, array(

        "lokasiStartUser" => "{$rowLokasi['lokasi_berangkat']}",
        "lokasiEndUser" => "{$rowLokasi['lokasi_tujuan']}",

    ));

}


echo json_encode($valueResponse);







?>