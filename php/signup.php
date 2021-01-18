<?php

session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connect.php';


$full_name = $_POST['full_name'];
$login = $_POST['login'];
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];

if ($password === $password_confirm) {

    if (isset($_POST['reg_submit'])) {

        //$password = md5($password);


        if ($full_name === '') {
            $_SESSION['message'] = 'ФИО не может быть пустым!';
            header('Location: ../reg.php');
        } elseif ($login === '') {
            $_SESSION['message'] = 'Логин не может быть пустым!';
            header('Location: ../reg.php');
        } elseif ($password === '') {
            $_SESSION['message'] = 'Пароль не может быть пустым!';
            header('Location: ../reg.php');
        } else {
            $sql = "INSERT INTO users (id, full_name, login, password) VALUES (NULL, '$full_name', '$login', '$password');";
            $query = $connect->prepare($sql);
            $query->execute();
            $_SESSION['message'] = 'Регистрация прошла успешно!';
            header('Location: ../');
        }
    }
} else {
    $_SESSION['message'] = 'Пароли не совпадают!';
    header('Location: ../reg.php');
}
