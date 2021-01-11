<?php

$f_json1 = 'data/connect.json';
$json1 = file_get_contents("$f_json1");
$obj1 = json_decode($json1, true);
$db_host = $obj1['ip'];

$f_json2 = 'data/connect.json';
$json2 = file_get_contents("$f_json2");
$obj2 = json_decode($json2, true);
$db_user = $obj2['user'];

$f_json3 = 'data/connect.json';
$json3 = file_get_contents("$f_json3");
$obj3 = json_decode($json3, true);
$db_password = $obj3['password'];

$f_json4 = 'data/connect.json';
$json4 = file_get_contents("$f_json4");
$obj4 = json_decode($json4, true);
$db_name = $obj4['name'];

try {
	$connect = new PDO('mysql:charset=utf8;dbname=' . $db_name . '; host=' . $db_host . '', '' . $db_user . '', '' . $db_password . '');
} catch (pdoException $e) {
	die($e->getMessage());
}
