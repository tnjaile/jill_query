<?php
include_once '../../mainfile.php';
include_once 'function.php';
//引入 PHPExcel 物件庫
require_once XOOPS_ROOT_PATH . '/modules/tadtools/vendor/phpoffice/phpexcel/Classes/PHPExcel.php';
//引入 PHPExcel_IOFactory 物件庫
require_once XOOPS_ROOT_PATH . '/modules/tadtools/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';

$objPHPExcel = new PHPExcel(); //實體化Excel
$objPHPExcel->setActiveSheetIndex(0); //設定預設顯示的工作表
$objActSheet = $objPHPExcel->getActiveSheet(); //指定預設工作表為 $objActSheet
$objActSheet->setTitle("users");
$objPHPExcel->createSheet(); //建立新的工作表

$objActSheet->setCellValue('A1', '姓名')
    ->setCellValue('B1', 'email');
$sql = "select name,email from " . $xoopsDB->prefix("users") . " order by uid";
//die($sql);
$result = $xoopsDB->query($sql) or Utility::web_error($sql);

$j = 2;
while (list($name, $email) = $xoopsDB->fetchRow($result)) {
    $objActSheet->setCellValue("A{$j}", $name)
        ->setCellValue("B{$j}", $email);
    $j++;
}

//匯出
ob_clean();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=users.xlsx');
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
