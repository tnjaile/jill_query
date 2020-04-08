<?php
/**
 * Jill Query module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package    Jill Query
 * @since      2.5
 * @author     jill lee(tnjaile@gmail.com)
 * @version    $Id $
 **/
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
$isAdmin                      = true;
$xoopsOption['template_main'] = 'jill_query_adm_import.tpl';
include_once "header.php";
include_once "../function.php";

/*-----------功能函數區--------------*/
function import_excel()
{
    global $xoopsDB, $xoopsUser;

    if (!$_FILES['excel']['name']) {
        redirect_header("import.php", 3, _MD_JILLQUERY_NOFILE);
    }

    $myts = \MyTextSanitizer::getInstance();

    // require_once XOOPS_ROOT_PATH . '/modules/tadtools/vendor/phpoffice/phpexcel/Classes/PHPExcel.php';
    require_once XOOPS_ROOT_PATH . '/modules/tadtools/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';

    if (preg_match('/\.(xlsx)$/i', $_FILES['excel']['name'])) {
        $reader = PHPExcel_IOFactory::createReader('Excel2007');
        $title  = str_replace('.xlsx', '', $_FILES['excel']['name']);
    } else {
        $reader = PHPExcel_IOFactory::createReader('Excel5');
        $title  = str_replace('.xls', '', $_FILES['excel']['name']);
    }

    $PHPExcel      = $reader->load($_FILES['excel']['tmp_name']); // 檔案名稱
    $sheet         = $PHPExcel->getSheet(0); // 讀取第一個工作表(編號從 0 開始)
    $highestRow    = $sheet->getHighestRow(); // 取得總列數
    $highestColumn = $sheet->getHighestColumn(); // 取得總欄數
    $colNumber     = PHPExcel_Cell::columnIndexFromString($highestColumn);

    if ($highestRow <= 1) {
        redirect_header("import.php", 3, _MD_JILLQUERY_NODATA);
    }
    if ($colNumber <= 1) {
        redirect_header("import.php", 3, _MD_JILLQUERY_NOCOL);
    }

    $title = $myts->addSlashes($title);

    $uid         = ($xoopsUser) ? $xoopsUser->uid() : "";
    $editorEmail = ($xoopsUser) ? $xoopsUser->email() : "";

    $sql = "insert into `" . $xoopsDB->prefix("jill_query") . "` (
        `title`,
        `editorEmail`,
        `isEnable`,
        `uid`
    ) values(
        '{$title}',
        '{$editorEmail}',
        '1',
        '{$uid}'
    )";
    $xoopsDB->queryF($sql) or Utility::web_error($sql);
    //取得最後新增資料的流水編號
    $qsn      = $xoopsDB->getInsertId();
    $qcsn_arr = array();
    $now      = date('Y-m-d H:i:s', xoops_getUserTimestamp(time()));
    //從第二列開始插入，整理資料格式
    for ($row = 1; $row <= $highestRow; $row++) {
        if ($row == 1) {
            for ($col = 0; $col < $colNumber; $col++) {
                $qc_title = $sheet->getCellByColumnAndRow($col, $row);

                $qc_title = $myts->addSlashes($qc_title);

                if (substr($qc_title, 0, 1) == "*") {
                    $qc_title   = substr($qc_title, 1);
                    $qcsnSearch = 1;
                } else {
                    $qcsnSearch = 0;
                }

                $sql = "insert into `" . $xoopsDB->prefix("jill_query_col") . "`
                (`qsn` , `qc_title` , `qcsnSearch`,`search_operator`,`isShow`,`qcSort`)
                values('{$qsn}' , '{$qc_title}' , '{$qcsnSearch}','or','1','{$col}')";
                $xoopsDB->queryF($sql) or Utility::web_error($sql);

                //取得最後新增資料的流水編號
                $qcsn = $xoopsDB->getInsertId();

                $qcsn_arr[$col] = $qcsn;
            }
        } else {
            $cells = array();
            for ($col = 0; $col < $colNumber; $col++) {
                $v = $sheet->getCellByColumnAndRow($col, $row);
                //格式檢查
                $value       = get_value_of_cell($v);
                $cells[$col] = $value;
            }

            //濾掉空行
            $all_cells = implode('', $cells);
            if (empty($all_cells)) {
                continue;
            }

            $sql = "insert into `" . $xoopsDB->prefix("jill_query_sn") . "` (`qsn`,`createDate`,`qrSort`,`uid`) values('{$qsn}','{$now}',$row-1,'{$uid}')";
            $xoopsDB->queryF($sql) or Utility::web_error($sql);
            //取得最後新增資料的流水編號
            $ssn = $xoopsDB->getInsertId();

            foreach ($cells as $col => $val) {
                $val = $myts->addSlashes($val);
                $sql = "insert into `" . $xoopsDB->prefix("jill_query_col_value") . "` (`ssn`, `qcsn`, `fillValue`) values('{$ssn}',{$qcsn_arr[$col]} ,'{$val}' )";
                $xoopsDB->queryF($sql) or Utility::web_error($sql);
            }
        }
    }

    return $qsn;
}

/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = system_CleanVars($_REQUEST, 'op', '', 'string');

switch ($op) {
/*---判斷動作請貼在下方---*/

//更新資料
    case "import_excel":
        $qsn = import_excel();
        header("location: setcol.php?qsn={$qsn}");
        exit;

    default:

        break;

        /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign("isAdmin", true);
$xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/css/xoops_adm3.css');
include_once 'footer.php';
