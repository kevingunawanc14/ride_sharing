<?php
require_once '../includes/connect.php';

// get id user
$username = $_POST["username"];


// sql ambil id_driver
$sql = 'SELECT * FROM user WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$_SESSION['username']]);

$row = $checksql->fetch();

$idDriver = $row['id'];

// cek putaran
$sql = 'SELECT * FROM order_live WHERE id_driver';
$checksql = $pdo->prepare($sql);
$checksql->execute([$idDriver]);

$counter = 0;

while ($row = $checksql->fetch()) {
    $counter += 1;
    // echo "a";
}

if ($counter == 0) {
    // artinya pick up user pertama kali

    // sql ambil id_user
    $sql = 'SELECT * FROM user WHERE username = ?';
    $checksql = $pdo->prepare($sql);
    $checksql->execute([$username]);

    $row = $checksql->fetch();

    $idUser =    $row['id'];

    // sql ambil id_driver
    $sql = 'SELECT * FROM user WHERE username = ?';
    $checksql = $pdo->prepare($sql);
    $checksql->execute([$_SESSION['username']]);

    $row = $checksql->fetch();

    $idDriver = $row['id'];
    $kapasitasMobil = $row['kapasitas'];

    // echo $idUser.$idDriver.$kapasitasMobil;

    //sql insert ke tabel order live
    $sql = 'INSERT INTO `order_live`(`id`, `id_user`, `id_driver`, `kapasitas`) 
    VALUES (NULL, ?, ?, ?)';
    $checksql = $pdo->prepare($sql);
    $checksql->execute([$idUser, $idDriver, $kapasitasMobil]);

    // 5
} else {
    echo "aaa";
    // sql ambil id_driver
    $sql = 'SELECT * FROM user WHERE username = ?';
    $checksql = $pdo->prepare($sql);
    $checksql->execute([$_SESSION['username']]);

    $row = $checksql->fetch();

    $idDriver = $row['id'];

    $sql = 'SELECT * FROM order_live WHERE id_driver = ?';
    $checksql = $pdo->prepare($sql);
    $checksql->execute([$idDriver]);

    $row = $checksql->fetch();

    $kapasitasMobil = $row['kapasitas'];
    $kapasitasMobil -= 1;
    echo $kapasitasMobil;
    // 4

    
    // sql ambil id_user
    $sql = 'SELECT * FROM user WHERE username = ?';
    $checksql = $pdo->prepare($sql);
    $checksql->execute([$username]);

    $row = $checksql->fetch();

    $idUser =    $row['id'];

    //sql insert ke tabel order live
    $sql = 'INSERT INTO `order_live`(`id`, `id_user`, `id_driver`, `kapasitas`) 
    VALUES (NULL, ?, ?, ?)';
    $checksql = $pdo->prepare($sql);
    $checksql->execute([$idUser, $idDriver, $kapasitasMobil]);

    // update 
    $sql = 'UPDATE order_live  SET kapasitas = ? WHERE id_driver = ?';
    $checksql = $pdo->prepare($sql);
    $checksql->execute([$kapasitasMobil,$idDriver]);
}



exit("order live almost ready");
