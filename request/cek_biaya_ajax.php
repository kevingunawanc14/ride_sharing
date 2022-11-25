<?php
require_once '../includes/connect.php';

$biaya = $_POST["biaya"];

// sql check saldo user
$sql = 'SELECT * FROM USER WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$_SESSION['username']]);

$row = $checksql->fetch();

$valueResponse = array();

if($row['saldo'] < $biaya){
    array_push($valueResponse, array(

        "status" => "false",
        "saldoKurang" => $row['saldo']-$biaya
    
    
    ));
    // exit("false");
}else{
    array_push($valueResponse, array(


      
        "status" => "true"
    
    
    ));
    // exit("true");
}

echo json_encode($valueResponse);

// exit ("Cek Biaya Berhasil");

?>