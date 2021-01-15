<?php


session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connect.php';


$login = $_POST['login'];
$password = $_POST['password'];

if (isset($_POST['auth_submit'])) {
    $sql = "SELECT * FROM users WHERE login='$login' AND password='$password';";
	$query = $connect->prepare($sql);
    $query->execute();
    
    if ($row = $query->fetch(PDO::FETCH_OBJ)) {
        $_SESSION['full_name'] = $row->full_name;
    }


    header('Location: ../profile.php');


} else {
    $_SESSION['message'] = 'Не верный логин или пароль!';
    header('Location: ../index.php');
        }



