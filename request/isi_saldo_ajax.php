<?php

require_once '../includes/connect.php';


$jumlahUang = $_POST["saldo"];
$uangUserSekarang = $_POST["saldoSekarang"];

$saldoTerbaru = $jumlahUang + $uangUserSekarang;



// update saldo user
$sql = 'UPDATE user  SET saldo = ? WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$saldoTerbaru,$_SESSION["username"]]);

// ambil data saldo terbaru setelah diupdate
$sql = 'SELECT * FROM USER WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$_SESSION['username']]);

$row = $checksql->fetch();




$valueResponseSaldo = array();


array_push($valueResponseSaldo, array(

    "saldoUpdate" => "{$row['saldo']}"

));


$idUser = $row['id'];


// insert ke histori_isisaldo
$tanggal = date("Y-m-d");
$sql = $sql = 'INSERT INTO `histori_isisaldo`(`id`, `tanggal`, `jumlah_uang`, `id_user`) VALUES (NULL, ?, ?, ?)';
$checksql = $pdo->prepare($sql);
$checksql->execute([$tanggal,$jumlahUang,$row['id']]);

// select semua histori isi_saldo user
$sql = 'SELECT * FROM histori_isisaldo WHERE id_user = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$idUser]);

$valueResponseHistoriIsiSaldo = array();


while ($rowHistori = $checksql->fetch()) {
    array_push($valueResponseSaldo, array(

        "kode" => "{$rowHistori['id']}",

        "tanggal" => "{$rowHistori['tanggal']}",

        "jumlah_uang" => "{$rowHistori['jumlah_uang']}"


    ));
}





echo json_encode($valueResponseSaldo);
