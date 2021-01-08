<?php
include 'connect.php';

$date = @$_POST['date'];
$date = date("d.m.Y", strtotime($date));
$name = @$_POST['name'];
$unit = @$_POST['unit'];
$executor = @$_POST['executor'];
$status = @$_POST['status'];

$search = @$_GET['search'];
$search = trim(@$search);
$search = strip_tags(@$search);

$start_date = @$_GET['start_date'];
$end_date = @$_GET['end_date'];
$start_date = date("d.m.Y", strtotime($start_date));
$end_date = date("d.m.Y", strtotime($end_date));

$edit_date = @$_POST['edit_date'];
$edit_date = date("d.m.Y", strtotime($edit_date));
$edit_name = @$_POST['edit_name'];
$edit_unit = @$_POST['edit_unit'];
$edit_executor = @$_POST['edit_executor'];
$edit_status = @$_POST['edit_status'];
$get_id = @$_GET['id'];


$sql = $pdo->prepare("SELECT * FROM main");
$sql->execute();
$result = $sql->fetchAll();


if (isset($_POST['add_submit'])) {
	$sql = ("INSERT INTO main(`date`, `name`, `unit`, `executor`, `status`) VALUES(?,?,?,?,?);");
	$query = $pdo->prepare($sql);
	$query->execute([$date, $name, $unit, $executor, $status]);
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}


if (isset($_POST['edit_submit'])) {
	$sql = "UPDATE main SET date=?, name=?, unit=?, executor=?, status=? WHERE id=?;";
	$query = $pdo->prepare($sql);
	$query->execute([$edit_date, $edit_name, $edit_unit, $edit_executor, $edit_status, $get_id]);
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}


if (isset($_POST['delete_submit'])) {
	$sql = "DELETE FROM main WHERE id=?;";
	$query = $pdo->prepare($sql);
	$query->execute([$get_id]);
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}


if (isset($_GET['search_submit'])) {
	$sql = "SELECT * FROM main WHERE date LIKE '%$search%' 
	or name LIKE '%$search%' or unit LIKE '%$search%' or executor LIKE '%$search%' 
	or status LIKE '%$search%' ORDER BY id ASC;";
	$query = $pdo->prepare($sql);
	$query->execute();
	$result = $query->fetchAll();
}

if (isset($_GET['find_submit'])) {
	$sql = "SELECT * FROM main WHERE date > '$start_date' AND date < '$end_date';";
	$query = $pdo->prepare($sql);
	$query->execute();
	$result = $query->fetchAll();
}

if (isset($_GET['load_submit'])) {
	$sql = $pdo->prepare("SELECT * FROM main");
	$sql->execute();
	$result = $sql->fetchAll();
	header('Location: ./');
}
