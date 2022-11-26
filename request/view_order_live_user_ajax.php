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

$status = $row['id_driver'];

// echo $status;
// select semua data di search live yang mempunyai id_driver sama
// tetapi pertama-tama kita select drivernya dulu

if ($status == 0) {
    // echo "belum di pick up";
    // $sql = 'SELECT * FROM search_live WHERE id_user = ?';
    // $checksql = $pdo->prepare($sql);
    // $checksql->execute([$status]);

    // $row = $checksql->fetch();
   

} else {
    // echo "sudah di pick up 232";
    $sql = 'SELECT * FROM search_live WHERE id_user = ?';
    $checksql = $pdo->prepare($sql);
    $checksql->execute([$status]);

    
    $row = $checksql->fetch();

    $valueResponse = array();
    

    array_push($valueResponse, array(

        "lokasiStartDriverIni" => "{$row['lokasi_berangkat']}",
        "lokasiEndDriverIni" => "{$row['lokasi_tujuan']}"

    ));

    // ambil data lokasi berangkat,tujuan user yang ikut driver ini 
    $sql = 'SELECT * FROM search_live WHERE id_driver = ?';
    $checksql = $pdo->prepare($sql);
    $checksql->execute([$status]);


  while ($row = $checksql->fetch()) {
    // echo $row['lokasi_berangkat'];
    array_push($valueResponse, array(

        "lokasiStartUser" => "{$row['lokasi_berangkat']}",
        "lokasiEndUser" => "{$row['lokasi_tujuan']}"

    ));

   }

echo json_encode($valueResponse);

}
