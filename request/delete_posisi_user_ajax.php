<?php
require_once '../includes/connect.php';

//sql get status user buat tau ini user yang mana
$sql = 'SELECT * FROM USER WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$_SESSION['username']]);

$row = $checksql->fetch();
$id = $row['id'];

// delete  data lokasi user setelah cancel
$sql = 'DELETE FROM search_live WHERE id_user= ? ';
$checksql = $pdo->prepare($sql);
$checksql->execute([$id]);





?>
