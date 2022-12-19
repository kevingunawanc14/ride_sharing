<?php
require_once '../includes/connect.php';

// pilih semua data disearch live yang statusnya = 1 / sebagai driver 
$sql = 'SELECT * FROM search_live WHERE status = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([1]);




$valueResponse = array();


while ($rowLokasi = $checksql->fetch()) {
    // echo $row['lokasi_berangkat'];
    array_push($valueResponse, array(


        "lokasiStartDriver" => "{$rowLokasi['lokasi_berangkat']}",
        "lokasiEndDriver" => "{$rowLokasi['lokasi_tujuan']}",


    ));

}


echo json_encode($valueResponse);





?>
