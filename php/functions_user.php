<?php
header('Content-Type: text/html; charset=utf-8');
include 'connect.php';
session_start();

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
$id = $_SESSION['user_id'];


$sql = $connect->prepare("SELECT * FROM main WHERE id_user = '$id' ORDER BY id DESC;");
$sql->execute();
$result = $sql->fetchAll();
$main = $sql->fetch(PDO::FETCH_ASSOC);


if (isset($_POST['add_submit'])) {
    $sql = "INSERT INTO main(`date`, `name`, `note`, `unit`, `executor`, `status`, `id_user`) VALUES(?,?,?,?,?,?,?);";
    $query = $connect->prepare($sql);
    $query->execute([$date, $name, $note, $unit, $executor, $status, $id]);

    //-------------------Отправка письма---------------------------

    $admin_email = 'rrc.aspoz@gmail.com';

    $form_subject = "Новая заявка от " . $_SESSION['full_name'];

    $project_name = 'АСПОЗ ‎СИСТЕМАТИКА';

    $html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
                <html lang="ru">
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                        <title>' . $form_subject . '</title>
                    </head>
                    <body>';

    $c = true;
    $plain_text = '';
    $table = '';

    foreach ($_POST as $key => $value) {
        if (is_array($value)) $value = implode(", ", $value);

        if ($value != "" && $key != "project_name" && $key != "admin_email" && $key != "form_subject") {

            // text/html 
            $table .= (($c = !$c) ? '<tr>' : '<tr style="background-color: #E6E6FA;">') . '
            <td style="padding: 10px; border: #E6E6FA 1px solid;"><b>' . $key . '</b></td>
            <td style="padding: 10px; border: #E6E6FA 1px solid;">' . $value . '</td>
        </tr>';

            // text/plain 
            $plain_text .= $key . ": " . $value . "\r\n";
        }
    }

    $html .= '<table width="100%">
        <tr style="text-align: center;">
            <td style="background-color: #4682B4; color: white; padding: 0 10px; width: 100%; border: #e9e9e9 1px solid;" colspan="2">
                <h2>' . $form_subject . '</h2>
            </td>
        </tr>
        ' . $table . '
    </table>
</body>
</html>';

    function adopt($text)
    {
        return '=?UTF-8?B?' . Base64_encode($text) . '?=';
    }

    $boundary = "--" . md5(uniqid(time())); // генерируем разделитель 

    $headers = array(
        'MIME-Version' => '1.0',
        'Date' => date("d.m.Y", strtotime($date)),
        'From' => $project_name,
        'Reply-To' => $project_name,
        'X-Mailer' => 'PHP/' . phpversion(),
        'Content-Type' => 'multipart/alternative; boundary="' . $boundary . '"',
    );

    // Текстовая версия письма 
    $message_plain_text .= "--$boundary" . "\n";

    $message_plain_text .= 'Content-Type: text/plain; charset=utf-8' . "\n";
    $message_plain_text .= 'Content-Transfer-Encoding: 8bit' . "\n\n";
    $message_plain_text .= $form_subject . "\r\n" . $plain_text . "\n";

    // HTML-версия письма 
    $message_html .= "--$boundary" . "\n";

    $message_html .= 'Content-Type: text/html; charset=utf-8' . "\n";
    $message_html .= 'Content-Transfer-Encoding: 8bit' . "\n\n";
    $message_html .= $html . "\n";

    $multipart_alternative = $message_plain_text . $message_html . "--$boundary--" . "\n";

    if (!mail($admin_email, adopt($form_subject), $multipart_alternative, $headers, $project_name)) {
        $error = error_get_last()['message'];
        print_r($error);
    }
    //-------------------------------------------------------------
    header('Location: php/back.php');
}


if (isset($_POST['edit_submit'])) {
    $sql = "UPDATE main SET  name=?, note=? WHERE id=?;";
    $query = $connect->prepare($sql);
    $query->execute([$edit_name, $edit_note, $get_id]);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}


if (isset($_POST['delete_submit'])) {
    $sql = "DELETE FROM main WHERE id=?;";
    $query = $connect->prepare($sql);
    $query->execute([$get_id]);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}


if (isset($_GET['search_submit'])) {
    $sql = "SELECT * FROM main WHERE date LIKE '%$search%' AND id_user = '$id' 
	or name LIKE '%$search%' AND id_user = '$id' or unit LIKE '%$search%' AND id_user = '$id' or executor LIKE '%$search%' AND id_user = '$id' 
	or status LIKE '%$search%' AND id_user = '$id' ORDER BY id ASC;";
    $query = $connect->prepare($sql);
    $query->execute();
    $result = $query->fetchAll();
}

if (isset($_GET['find_submit'])) {
    $sql = "SELECT * FROM main WHERE date >= '$start_date' AND date <= '$end_date' AND id_user = '$id';";
    $query = $connect->prepare($sql);
    $query->execute();
    $result = $query->fetchAll();
}

if (isset($_GET['load_submit'])) {
    $sql = $connect->prepare("SELECT * FROM main WHERE id_user = '$id' ORDER BY id DESC;");
    $sql->execute();
    $result = $sql->fetchAll();
    header('Location: ./profile.php');
}

if (isset($_GET['exit_submit'])) {
    header('Location: ../');
}

if (isset($_GET['export_submit'])) {

    $sql = $connect->prepare("SELECT * FROM main WHERE id_user = '$id';");
    $sql->execute();

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

    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
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
