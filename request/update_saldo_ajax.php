<?php

require_once '../includes/connect.php';


$biaya = $_POST["biaya"];

// ambil data saldo terbaru setelah diupdate
$sql = 'SELECT * FROM USER WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$_SESSION['username']]);

$row = $checksql->fetch();

$saldoUser = $saldoUser - $biaya;
$saldoDriver = $saldoDriver + $biaya;

// update saldo user
$sql = 'UPDATE user  SET saldo = ? WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$saldoUser,$_SESSION["username"]]);


// update saldo driver
$sql = 'UPDATE user  SET saldo = ? WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$saldoDriver,$idDriver]);