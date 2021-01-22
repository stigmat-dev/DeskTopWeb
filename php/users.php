<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'admin.php';
?>
<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
	<link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="../css/style.css">
	<title>Пользователи | <?= $_SESSION['full_name']; ?></title>
</head>

<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col mt-1">
				<nav class="menu shadow">
					<form action="" method="GET">
						<div class="form-group ">

							<a href="base.php" class="btn btn-primary expBtn myBtn" title="Назад"><i class="fas fa-sign-out-alt"></i></a>

							<label class="greeting">
								<h5>Ваши подданные, <?= $_SESSION['full_name']; ?>. Что будем с ними делать?</h5>
							</label>
						</div>
					</form>
				</nav>

				<table class="table shadow">
					<thead class="thead-dark">
						<tr>
							<th>№</th>
							<th>ФИО</th>
							<th>Логин</th>
							<th>Пароль</th>
							<th>Бан</th>
							<th>Действие</th>
						</tr>
						<?php foreach ($result as $value) { ?>
							<tr>
								<td><?= $value['id'] ?></td>
								<td><?= $value['full_name'] ?></td>
								<td><?= $value['login'] ?></td>
								<td><?= $value['password'] ?></td>
								<td><?php if ($value['ban'] === '0') {
										echo 'Не бан';
									} else {
										echo 'Бан';
									}
									?>
								</td>
								<td>
									<form class="myAuth" action="?id=<?= $value['id'] ?>" method="POST">
										<button title="Забанить" type="submit" name="ban_submit" class="btn btn-primary btn-sm myBtn"><i class="fas fa-ban"></i></button>
										<button title="Разбанить" type="submit" name="unban_submit" class="btn btn-primary btn-sm myBtn"><i class="far fa-thumbs-up"></i></button>
										<a href="?delete=<?= $value['id'] ?>" title="Удалить пользователя" class="btn btn-danger btn-sm" data-toggle="modal" data-placement="top" data-target="#deleteModal<?= $value['id'] ?>"><i class="far fa-trash-alt"></i></a>
									</form>

									<?php require 'modal.php'; ?>
								</td>
							</tr>
						<?php } ?>
					</thead>
				</table>

			</div>
		</div>
	</div>


	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="js/script.js"></script>
</body>

</html>