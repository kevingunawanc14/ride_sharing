<?php
require_once '../includes/connect.php';

//sql get status user buat tau ini user yang mana
$sql = 'SELECT * FROM user WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$_SESSION['username']]);

$row = $checksql->fetch();

$id = $row['id'];

// pilih data user ini disearchlive untuk nanti dicompare jarak berangkat user dengan driver, jarak tujuan user dengan driver dengan data driver dit4 lain
$sql = 'SELECT * FROM search_live WHERE id_user = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$id]);


$rowLokasi = $checksql->fetch();

$valueResponse = array();

array_push($valueResponse, array(


    "lokasiStartUser" => "{$rowLokasi['lokasi_berangkat']}",
    "lokasiEndUser" => "{$rowLokasi['lokasi_tujuan']}",


));


// pilih semua data disearch live yang statusnya = 1 / sebagai driver 
$sql = 'SELECT * FROM search_live WHERE status = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([1]);


while ($rowLokasi = $checksql->fetch()) {
    // echo $row['lokasi_berangkat'];
    array_push($valueResponse, array(


        "lokasiStartDriver" => "{$rowLokasi['lokasi_berangkat']}",
        "lokasiEndDriver" => "{$rowLokasi['lokasi_tujuan']}",


    ));

}


echo json_encode($valueResponse);





?>
