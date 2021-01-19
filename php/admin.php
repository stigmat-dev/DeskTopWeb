<?php
header('Content-Type: text/html; charset=utf-8');
include 'connect.php';

if (isset($_GET['id'])) {
    $get_id = $_GET['id'];
}

$sql = $connect->prepare("SELECT * FROM users ORDER BY id ASC;");
$sql->execute();
$result = $sql->fetchAll();


if (isset($_POST['ban_submit'])) {
    $sql = "UPDATE `users` SET `ban` = '1' WHERE id=?;";
    $query = $connect->prepare($sql);
    $query->execute([$get_id]);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

if (isset($_POST['unban_submit'])) {
    $sql = "UPDATE `users` SET `ban` = '0' WHERE id=?;";
    $query = $connect->prepare($sql);
    $query->execute([$get_id]);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

if (isset($_POST['delete_submit'])) {
    $sql = "DELETE FROM users WHERE id=?;";
    $query = $connect->prepare($sql);
    $query->execute([$get_id]);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
