<?php
header('Content-Type: text/html; charset=utf-8');
include 'connect.php';

$date = @$_POST['date'];
$date = date("d.m.Y", strtotime($date));
$name = @$_POST['name'];
$note = @$_POST['note'];
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
$edit_note = @$_POST['edit_note'];
$edit_unit = @$_POST['edit_unit'];
$edit_executor = @$_POST['edit_executor'];
$edit_status = @$_POST['edit_status'];
$get_id = @$_GET['id'];


$sql = $connect->prepare("SELECT * FROM main ORDER BY id DESC;");
$sql->execute();
$result = $sql->fetchAll();

if (empty($note)) {
	
}




if (isset($_POST['add_submit'])) {
	$sql = "INSERT INTO main(`date`, `name`, `note`, `unit`, `executor`, `status`) VALUES(?,?,?,?,?,?);";
	$query = $connect->prepare($sql);
	$query->execute([$date, $name, $note, $unit, $executor, $status]);
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}


if (isset($_POST['edit_submit'])) {
	$sql = "UPDATE main SET date=?, name=?, note=?, unit=?, executor=?, status=? WHERE id=?;";
	$query = $connect->prepare($sql);
	$query->execute([$edit_date, $edit_name, $edit_note, $edit_unit, $edit_executor, $edit_status, $get_id]);
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}


if (isset($_POST['delete_submit'])) {
	$sql = "DELETE FROM main WHERE id=?;";
	$query = $connect->prepare($sql);
	$query->execute([$get_id]);
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}


if (isset($_GET['search_submit'])) {
	$sql = "SELECT * FROM main WHERE date LIKE '%$search%' 
	or name LIKE '%$search%' or unit LIKE '%$search%' or executor LIKE '%$search%' 
	or status LIKE '%$search%' ORDER BY id ASC;";
	$query = $connect->prepare($sql);
	$query->execute();
	$result = $query->fetchAll();
}

if (isset($_GET['find_submit'])) {
	$sql = "SELECT * FROM main WHERE date >= '$start_date' AND date <= '$end_date';";
	$query = $connect->prepare($sql);
	$query->execute();
	$result = $query->fetchAll();
}

if (isset($_GET['load_submit'])) {
	$sql = $connect->prepare("SELECT * FROM main;");
	$sql->execute();
	$result = $sql->fetchAll();
	header('Location: ./');
}

if (isset($_GET['export_submit'])) {

	$link = mysqli_connect('' . $db_host . '', '' . $db_user . '', '' . $db_password . '', '' . $db_name . '');
	$query = mysqli_query($link, "SELECT * FROM main ORDER by id;");

	require_once 'PHPExcel.php';


	$xls = new PHPExcel();

	$xls->setActiveSheetIndex(0);
	$sheet = $xls->getActiveSheet();
	$sheet->setTitle('Экспорт данных');


	$sheet->setCellValue("A1", "№");
	$sheet->setCellValue("B1", "Дата");
	$sheet->setCellValue("C1", "Наименование");
	$sheet->setCellValue("D1", "Примечание");
	$sheet->setCellValue("E1", "Подразделение");
	$sheet->setCellValue("F1", "Исполнитель");
	$sheet->setCellValue("G1", "Статус");


	$s = 1;

	while ($row = mysqli_fetch_array($query)) {
		$s++;
		$sheet->setCellValue("A$s", $row['id'], PHPExcel_Cell_DataType::TYPE_STRING);
		$sheet->setCellValue("B$s", $row['date'], PHPExcel_Cell_DataType::TYPE_STRING);
		$sheet->setCellValue("C$s", $row['name'], PHPExcel_Cell_DataType::TYPE_STRING);
		$sheet->setCellValue("D$s", $row['note'], PHPExcel_Cell_DataType::TYPE_STRING);
		$sheet->setCellValue("E$s", $row['unit'], PHPExcel_Cell_DataType::TYPE_STRING);
		$sheet->setCellValue("F$s", $row['executor'], PHPExcel_Cell_DataType::TYPE_STRING);
		$sheet->setCellValue("G$s", $row['status'], PHPExcel_Cell_DataType::TYPE_STRING);
	}

	$sheet->getPageSetup()->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
	$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	$sheet->getPageMargins()->setTop(1);
	$sheet->getPageMargins()->setRight(0.75);
	$sheet->getPageMargins()->setLeft(0.75);
	$sheet->getPageMargins()->setBottom(1);
	$sheet->getHeaderFooter()->setOddHeader("Экспорт данных");
	$sheet->getHeaderFooter()->setOddFooter('&L&B Экспорт данных &R Страница &P из &N');

	$sheet->getColumnDimension("A")->setWidth(5);
	$sheet->getColumnDimension("B")->setWidth(10);
	$sheet->getColumnDimension("C")->setWidth(40);
	$sheet->getColumnDimension("D")->setWidth(60);
	$sheet->getColumnDimension("E")->setWidth(25);
	$sheet->getColumnDimension("F")->setWidth(20);
	$sheet->getColumnDimension("G")->setWidth(15);

	$sheet->getStyle("C1:C$s", $row['name'])->getAlignment()->setWrapText(true);
	$sheet->getStyle("D1:D$s", $row['note'])->getAlignment()->setWrapText(true);
	$sheet->getStyle("E1:E$s", $row['note'])->getAlignment()->setWrapText(true);
	$sheet->getRowDimension("1")->setRowHeight(25);

	$sheet->getStyle("A1")->getFont()->setSize(8);
	$sheet->getStyle("A1")->getFont()->setBold(true);
	$sheet->getStyle("A1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle("A1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$sheet->getStyle("B1")->getFont()->setSize(8);
	$sheet->getStyle("B1")->getFont()->setBold(true);
	$sheet->getStyle("B1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle("B1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$sheet->getStyle("C1")->getFont()->setSize(8);
	$sheet->getStyle("C1")->getFont()->setBold(true);
	$sheet->getStyle("C1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle("C1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$sheet->getStyle("D1")->getFont()->setSize(8);
	$sheet->getStyle("D1")->getFont()->setBold(true);
	$sheet->getStyle("D1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle("D1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$sheet->getStyle("E1")->getFont()->setSize(8);
	$sheet->getStyle("E1")->getFont()->setBold(true);
	$sheet->getStyle("E1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle("E1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$sheet->getStyle("F1")->getFont()->setSize(8);
	$sheet->getStyle("F1")->getFont()->setBold(true);
	$sheet->getStyle("F1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle("F1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$sheet->getStyle("G1")->getFont()->setSize(8);
	$sheet->getStyle("G1")->getFont()->setBold(true);
	$sheet->getStyle("G1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle("G1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

	$border = array(
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('rgb' => '000000')
			)
		)
	);

	$sheet->getStyle("A1:G$s")->applyFromArray($border);
	$objWriter = PHPExcel_IOFactory::createWriter($xls, 'Excel2007');
	$objWriter->save("Выборка данных.xlsx");

	header('Location: ./Выборка данных.xlsx');
}
