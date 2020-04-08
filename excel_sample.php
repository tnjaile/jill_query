<?php
include_once '../../mainfile.php';
include_once 'function.php';
//引入 PHPExcel 物件庫
require_once XOOPS_ROOT_PATH . '/modules/tadtools/vendor/phpoffice/phpexcel/Classes/PHPExcel.php';
//引入 PHPExcel_IOFactory 物件庫
require_once XOOPS_ROOT_PATH . '/modules/tadtools/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';

$qsn       = (empty($_GET['qsn'])) ? '' : intval($_GET['qsn']);
$query_arr = get_jill_query($qsn);
$col_arr   = get_jill_query_allcol_qsn($qsn);

$objPHPExcel = new PHPExcel(); //實體化Excel
$objPHPExcel->setActiveSheetIndex(0); //設定預設顯示的工作表
$objActSheet = $objPHPExcel->getActiveSheet(); //指定預設工作表為 $objActSheet
$objActSheet->setTitle("sample");
$objPHPExcel->createSheet(); //建立新的工作表

$columnNumber = 1;
foreach ($col_arr as $qcsn => $title_arr) {
    $Letter = getColumnLetter($columnNumber) . "1";
    $title  = $title_arr['qc_title'];
    $objActSheet->getColumnDimension($Letter)->setAutoSize(true);
    $objActSheet->setCellValue($Letter, $title);
    $columnNumber++;
}

//匯出
ob_clean();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=' . $query_arr['title'] . '.xlsx');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->setPreCalculateFormulas(false);
$objWriter->save('php://output');
exit;

//***************************函數************************//
function getColumnLetter($columnNumber)
{
    if ($columnNumber > 26) {
        $columnLetter = Chr(intval(($columnNumber - 1) / 26) + 64) . Chr((($columnNumber - 1) % 26) + 65);
    } else {
        $columnLetter = Chr($columnNumber + 64);
    }

    return $columnLetter;
}
