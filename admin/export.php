<?php
use XoopsModules\Tadtools\Utility;
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

// die(var_dump($col_arr));
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
$ssn_arr = get_jill_query_allsn_qsn($qsn);
// die(var_dump($ssn_arr));
$i = 2;
foreach ($ssn_arr as $ssn) {
    $columnNumber = 1;
    foreach ($qcsn_arr as $qcsn) {
        $Letter = getColumnLetter($columnNumber) . $i;

        $sql = "select `fillValue` from `" . $xoopsDB->prefix("jill_query_col_value") . "`
        where `qcsn` = '{$qcsn}' && `ssn`= '{$ssn}'  ";
        // die($sql);
        $result          = $xoopsDB->query($sql) or Utility::web_error($sql);
        list($fillValue) = $xoopsDB->fetchRow($result);
        $objActSheet->setCellValue($Letter, $fillValue);
        $columnNumber++;
    }
    $i++;
}

//匯出
ob_clean();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $query_arr['title'] . '.xlsx"');
header('Cache-Control: max-age=0');
// 避免excel下載錯誤訊息(若數據大時加上)
// for ($i = 0; $i < ob_get_level(); $i++) {
//     ob_end_flush();
// }
// ob_implicit_flush(1);

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
