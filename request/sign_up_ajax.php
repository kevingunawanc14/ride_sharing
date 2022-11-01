<?php
require_once '../includes/connect.php';

$username = $_POST['username'];
$password = $_POST['password'];
$alamat = $_POST['alamat'];
$umur = $_POST['umur'];
$status = $_POST['status'];
$kapasitas = $_POST['kapasitas'];
$saldo = 50000;

if ($status == 1) {
    // insert ke user
    $sql = 'INSERT INTO `user`(`id`, `username`, `password`, `umur`, `alamat`, `saldo`, `status` , `kapasitas`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)';
    $checksql = $pdo->prepare($sql);
    $checksql->execute([$username, $password, $umur, $alamat, $saldo, $status, $kapasitas]);
} else {
    // insert ke user
    $sql = 'INSERT INTO `user`(`id`, `username`, `password`, `umur`, `alamat`, `saldo`, `status`, `kapasitas`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)';
    $checksql = $pdo->prepare($sql);
    $checksql->execute([$username, $password,  $umur, $alamat, $saldo, $status, $kapasitas]);
}





exit("Pembuatan Akun Berhasil");
