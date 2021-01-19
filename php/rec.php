<?php


session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connect.php';


$login = @$_POST['login'];
$new_password = @$_POST['new_password'];

$check_user = $connect->query("SELECT id FROM users WHERE login='$login' LIMIT 1;");
$count = $check_user->rowCount();

if ($count === 1) {

    $new_password = md5($new_password);

    $sql = $connect->query("UPDATE users SET password='$new_password' WHERE login='$login';");
    $_SESSION['message'] = 'Пароль восстановлен!';
    header('Location: ../');
} else {
    $_SESSION['message'] = 'Такой логин не найден!';
    header('Location: ../recovery.php');
}
