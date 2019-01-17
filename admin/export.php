<?php
include_once "header.php";
include_once '../function.php';
//引入 PHPExcel 物件庫
require_once XOOPS_ROOT_PATH . '/modules/tadtools/PHPExcel.php';
//引入 PHPExcel_IOFactory 物件庫
require_once XOOPS_ROOT_PATH . '/modules/tadtools/PHPExcel/IOFactory.php';

$qsn = (empty($_GET['qsn'])) ? '' : intval($_GET['qsn']);
// if (!get_undertaker($qsn)) {
//     redirect_header(XOOPS_URL . "/index.php", 3, _MD_JILLQUERY_ILLEGAL);
// }
$query_arr = get_jill_query($qsn);
$col_arr   = get_jill_query_allcol_qsn($qsn);

$objPHPExcel = new PHPExcel(); //實體化Excel
$objPHPExcel->setActiveSheetIndex(0); //設定預設顯示的工作表
$objActSheet = $objPHPExcel->getActiveSheet(); //指定預設工作表為 $objActSheet
$objActSheet->setTitle("datas");
$objPHPExcel->createSheet(); //建立新的工作表

$columnNumber = 1;
foreach ($col_arr as $qcsn => $title_arr) {
    $Letter     = getColumnLetter($columnNumber) . "1";
    $title      = $title_arr['qc_title'];
    $qcsn_arr[] = $qcsn;
    $objActSheet->getColumnDimension($Letter)->setAutoSize(true);
    $objActSheet->setCellValue($Letter, $title);
    $columnNumber++;
}
$count_ssn = count_jill_query_sn($qsn);
//die(var_dump($qcsn_arr));
$i = 2;
for ($ssn = 1; $ssn <= $count_ssn; $ssn++) {
    $columnNumber = 1;
    foreach ($qcsn_arr as $qcsn) {
        $Letter = getColumnLetter($columnNumber) . $i;

        $sql = "select `fillValue` from `" . $xoopsDB->prefix("jill_query_col_value") . "`
        where `qcsn` = '{$qcsn}' && `ssn`= '{$ssn}'  ";
        $result          = $xoopsDB->query($sql) or web_error($sql);
        list($fillValue) = $xoopsDB->fetchRow($result);
        $objActSheet->setCellValue($Letter, $fillValue);
        $columnNumber++;
    }
    $i++;
}
//匯出
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=' . $query_arr['title'] . '.xls');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
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
