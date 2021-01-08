<?php

$f_json = 'data\ip.json';
$json = file_get_contents("$f_json");
$obj = json_decode($json, true);
$db_host = $obj['ip'];
$db_user = "rrc";
$db_password = "0000";
$db_base = "desk";

try {
	$pdo = new PDO('mysql:dbname=' . $db_base . '; host=' . $db_host . '', '' . $db_user . '', '' . $db_password . '');
} catch (PDOException $e) {
	die($e->getMessage());
}
