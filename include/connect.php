<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ride_sharing";

//Create Connection
$conn = "mysql:host=$servername;dbname=$dbname;charset=UTF8";

try {
	$pdo = new PDO($conn, $username, $password);

	if ($pdo) {
		echo "";
	}
} catch (PDOException $e) {
	echo $e->getMessage();
}



?>