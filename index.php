<?php
header('Content-Type: text/html; charset=utf-8');
include 'php/requests.php';
?>
<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css">
	<title>База заявок АХП | Республиканский Реабилитационный Центр МЗ ДНР</title>
</head>

<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col mt-1">
				<nav class="menu shadow">
					<button class="btn btn-primary mb-1 ml-auto myBtn addBtn" data-toggle="modal" data-target="#Modal">Добавить</button>
					<form action="" method="GET">
						<div class="form-group ">
							<button name="search_submit" type="submit" class="btn btn-primary noBtn">Найти</button>
							<input type="search" class="form-control search" name="search" value="" placeholder="Поиск...">
							<button name="load_submit" type="submit" class="btn btn-primary loadBtn myBtn">Обновить</button>
							<button name="export_submit" class="btn btn-primary expBtn myBtn" type="submit">Экспорт в Excel</button>
							<button name="find_submit" type="submit" class="btn btn-primary ml-auto searchBtn myBtn">Найти</button>
							<input name="start_date" class="dates" type="date" value="<?php echo date('Y-m-d'); ?>">
							<input name="end_date" class="dates" type="date" value="<?php echo date('Y-m-d'); ?>">

						</div>
					</form>
				</nav>

				<table class="table shadow">
					<thead class="thead-dark">
						<tr>
							<th>№</th>
							<th>Дата</th>
							<th>Наименование</th>
							<th>Примечание</th>
							<th>Подразделение</th>
							<th>Исполнитель</th>
							<th>Статус</th>
							<th>Действие</th>
						</tr>
						<?php foreach ($result as $value) { ?>
							<tr>
								<td><?= $value['id'] ?></td>
								<td><?= $value['date'] ?></td>
								<td><?= $value['name'] ?></td>
								<td><a href="?note=<?= $value['id'] ?>" class="myLink" <?php if (empty($value['note'])){echo 'style="display: none;"';} ?> id="noteLink" data-toggle="modal" data-placement="top" data-target="#noteModal<?= $value['id'] ?>">Открыть</a></td>
								<td><?= $value['unit'] ?></td>
								<td><?= $value['executor'] ?></td>
								<td><?= $value['status'] ?></td>
								<td>
									<a href="?edit=<?= $value['id'] ?>" class="btn btn-primary btn-sm myBtn" data-toggle="modal" data-placement="top" data-target="#editModal<?= $value['id'] ?>"><i class="fa fa-edit"></i></a>
									<a href="?delete=<?= $value['id'] ?>" class="btn btn-danger btn-sm" data-toggle="modal" data-placement="top" data-target="#deleteModal<?= $value['id'] ?>"><i class="fa fa-trash"></i></a>
									<?php require 'php/modal.php'; ?>
								</td>
							</tr>
						<?php } ?>
					</thead>
				</table>

			</div>
		</div>
	</div>
	
	<!-- ---------------------------------------------------------Форма Добавить запись -------------------------------------------------------------------------->

	<div class="modal fade" tabindex="-1" role="dialog" id="Modal">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content shadow">
				<div class="modal-header">
					<h5 class="modal-title">Добавить запись</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="" method="post">
						<div class="form-group">
							<input type="date" class="form-control mydate" name="date" value="<?php echo date('Y-m-d'); ?>">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="name" value="" placeholder="Наименование">
						</div>
						<div class="form-group">
							<select class="form-control" name="unit">
								<option value="" selected>Выберите подразделение</option>
								<option value="Главный врач">Главный врач</option>
								<option value="Приемная">Приемная</option>
								<option value="Зам. по медицинской части">Зам. по медицинской части</option>
								<option value="Зам. по реабилитации">Зам. по реабилитации</option>
								<option value="Зам. по экономике">Зам. по экономике</option>
								<option value="Зам. по АХП">Зам. по АХП</option>
								<option value="Главный бухгалтер">Главный бухгалтер</option>
								<option value="Орг. метод. отдел">Орг. метод. отдел</option>
								<option value="Экономический отдел">Экономический отдел</option>
								<option value="Бухгалтерия">Бухгалтерия</option>
								<option value="Расчетный отдел">Расчетный отдел</option>
								<option value="Отдел кадров">Отдел кадров</option>
								<option value="Юрист">Юрист</option>
								<option value="Стат. отдел">Стат. отдел</option>
								<option value="Нейрохирургия 1">Нейрохирургия 1</option>
								<option value="Нейрохирургия 2">Нейрохирургия 2</option>
								<option value="Травматология 1">Травматология 1</option>
								<option value="Травматология 2">Травматология 2</option>
								<option value="Неврология">Неврология</option>
								<option value="Интенсивная терапия">Интенсивная терапия</option>
								<option value="ФТО">ФТО</option>
								<option value="Госпиталь">Госпиталь</option>
								<option value="Лаборатория">Лаборатория</option>
								<option value="Санпропускник">Санпропускник</option>
								<option value="Аптека">Аптека</option>
								<option value="АХП">АХП</option>
							</select>
						</div>
						<div class="form-group">
							<select class="form-control" name="executor">
								<option value="" selected>Выберите исполнителя</option>
								<option value="Хрипливцев И.">Хрипливцев И.</option>
								<option value="Шелудько В.">Шелудько В.</option>
							</select>
						</div>
						<div class="form-group">
							<select class="form-control" name="status">
								<option value="" selected>Выберите статус</option>
								<option value="В работе">В работе</option>
								<option value="Выполнено">Выполнено</option>
							</select>
						</div>
						<div class="form-group">
							<textarea class="form-control" name="note" placeholder="Примечание"></textarea>
						</div>
				</div>
				<div class="modal-footer">
					<button type="submit" name="add_submit" class="btn btn-primary">Добавить</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
				</div>
				</form>
			</div>
		</div>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="js/light.js"></script>
</body>

</html>