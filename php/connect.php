<?php

try {
	$options = array(
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	);

	$connect = new PDO('mysql:host=localhost;dbname=desk;charset=utf8', 'rrc', '0000', $options);
} catch (pdoException $e) {
	die($e->getMessage());
}
