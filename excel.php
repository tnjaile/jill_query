<?php
/**
 * Jill Query module
 *
 * @copyright  The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package    Jill Query
 * @since      2.5
 * @author     jill lee(tnjaile@gmail.com)
 * @version    $Id $
 **/

/*-----------引入檔案區--------------*/
use Xmf\Request;
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\Jeditable;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\Utility;

include "header.php";
include_once 'function_block.php';
$op  = Request::getString('op');
$qsn = Request::getInt('qsn');
$ssn = Request::getInt('ssn');

if (!get_undertaker($qsn)) {
    redirect_header("index.php", 3, _MD_JILLQUERY_ILLEGAL);
}
$iseditAdm = get_undertaker($qsn);

$xoopsOption['template_main'] = 'jill_query_excel.tpl';
include_once XOOPS_ROOT_PATH . "/header.php";

/*-----------功能函數區--------------*/
//列出匯入資料
function list_data($qsn = '')
{
    global $xoopsDB, $xoopsTpl, $xoopsUser, $isAdmin, $iseditAdm;

    // // array(4) { ["qcsn"]=> string(1) "3" ["keyword"]=> string(9) "李佳玲" ["send"]=> string(12) "立即查詢" ["qsn"]=> string(1) "1" }
    $uid = $xoopsUser->uid();

    if (isset($_POST['next_op']) && $_POST['next_op'] == 'show_search') {
        $keyword = Request::getString('keyword');
        $qcsn    = Request::getInt('qcsn');

        $where = (empty($isAdmin)) ? " && b.`uid`='{$uid}'" : "";
        $sql   = "select a.`ssn`,b.qrSort from `" . $xoopsDB->prefix("jill_query_col_value") . "` as a
		join `" . $xoopsDB->prefix("jill_query_sn") . "` as b on a.`ssn`=b.`ssn`
        where a.`qcsn`='{$qcsn}' && a.`fillValue` like '%{$keyword}%' $where";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql);
        $total  = $xoopsDB->getRowsNum($result);
        $xoopsTpl->assign('next_op', 'show_search');

    } else {

        $where = (empty($isAdmin)) ? "where `qsn`='{$qsn}' && `uid`='{$uid}'" : "where `qsn`='{$qsn}'";
        $sql   = "select ssn, qrSort  from `" . $xoopsDB->prefix("jill_query_sn") . "`
        $where order by `qrSort` ";

        //Utility::getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $PageBar = Utility::getPageBar($sql, 20, 10);
        $bar     = $PageBar['bar'];
        $sql     = $PageBar['sql'];
        $total   = $PageBar['total'];

        $result = $xoopsDB->query($sql) or Utility::web_error($sql);
        $xoopsTpl->assign('bar', $bar);

    }

    $all_content = array();
    while (list($ssn, $qrSort) = $xoopsDB->fetchRow($result)) {

        $sql = "select a.qcsn, a.fillValue  from `" . $xoopsDB->prefix("jill_query_col_value") . "` as a
        join `" . $xoopsDB->prefix("jill_query_col") . "` as b on a.qcsn=b.qcsn
        where a.`ssn`='{$ssn}'  order by b.`qcSort` ";
        $result2 = $xoopsDB->query($sql) or Utility::web_error($sql);
        while (list($qcsn, $fillValue) = $xoopsDB->fetchRow($result2)) {
            $all_content[$ssn]['col_data'][$qcsn] = $fillValue;
            $all_content[$ssn]['qrSort']          = $qrSort;
        }
    }

    //刪除確認的JS
    $sweet_alert_obj                  = new SweetAlert();
    $delete_jill_query_col_value_func = $sweet_alert_obj->render('delete_jill_query_col_value_func',
        "{$_SERVER['PHP_SELF']}?op=delete_jill_query_col_value&qsn=$qsn&ssn=", "ssn");
    $xoopsTpl->assign('delete_jill_query_col_value_func', $delete_jill_query_col_value_func);

    //套用formValidator驗證機制
    $formValidator      = new FormValidator("#searchform", true);
    $formValidator_code = $formValidator->render();
    $xoopsTpl->assign('formValidator_code', $formValidator_code);

    // die(var_dump(get_jill_query_allcol_qsn($qsn)));
    $xoopsTpl->assign('title_arr', get_jill_query_allcol_qsn($qsn));
    $xoopsTpl->assign('query_arr', get_jill_query($qsn));
    $xoopsTpl->assign('all_content', $all_content);
    $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    $xoopsTpl->assign('qsn', $qsn);
    $xoopsTpl->assign('now_op', 'list_data');
    $xoopsTpl->assign('total', sprintf(_MD_JILLQUERY_TITLE, $total));

    $file      = "save_col_val.php?qsn=$qsn";
    $jeditable = new Jeditable();
    $jeditable->setTextCol(".jq_data", $file, '80%', '12pt');
    $jeditable->render();
}

//匯入 Excel 檔
function import_excel($qsn = "")
{
    global $xoopsDB, $xoopsUser;
    // return $qsn;

    if (empty($qsn) || !$_FILES['excel']['name']) {
        return;
    }
    $title_arr = get_jill_query_allcol_qsn($qsn);
    $qcsn_arr  = array_keys($title_arr);
    $count     = count_jill_query_col_qsn($qsn);

    require_once XOOPS_ROOT_PATH . '/modules/tadtools/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';
    if (preg_match('/\.(xlsx)$/i', $_FILES['excel']['name'])) {
        $reader = PHPExcel_IOFactory::createReader('Excel2007');
    } else {
        $reader = PHPExcel_IOFactory::createReader('Excel5');
    }

    $PHPExcel   = $reader->load($_FILES['excel']['tmp_name']); // 檔案名稱
    $sheet      = $PHPExcel->getSheet(0); // 讀取第一個工作表(編號從 0 開始)
    $highestRow = $sheet->getHighestRow(); // 取得總列數
    $myts       = \MyTextSanitizer::getInstance();

    if ($_POST['continue_no'] != "on") {
        delete_data($qsn);
    }

    $start = jill_query_max_qrSort($qsn);

    $uid = $xoopsUser->uid();

    //從第二列開始插入，整理資料格式
    for ($row = 2; $row <= $highestRow; $row++) {
        for ($col = 0; $col < $count; $col++) {
            $v = $sheet->getCellByColumnAndRow($col, $row);
            //格式檢查
            // if (PHPExcel_Shared_Date::isDateTime($v)) {
            //     $value = PHPExcel_Shared_Date::ExcelToPHPObject($v->getValue())->format('Y-m-d');
            // } else {
            //     $value = $v->getCalculatedValue();
            // }
            $value            = get_value_of_cell($v);
            $data[$row][$col] = $value;
        }

    }
    // die(var_dump($data));
    foreach ($data as $row => $cells) {
        //濾掉空行
        $all_cells = implode('', $cells);
        if (empty($all_cells)) {
            continue;
        }

        $now    = date('Y-m-d H:i:s', xoops_getUserTimestamp(time()));
        $qrSort = $start + $row - 1;
        $sql    = "insert into `" . $xoopsDB->prefix("jill_query_sn") . "` (`qsn`,`createDate`,`qrSort`,`uid`) values('{$qsn}','{$now}','{$qrSort}','{$uid}')";
        $xoopsDB->queryF($sql) or Utility::web_error($sql);
        //取得最後新增資料的流水編號
        $ssn = $xoopsDB->getInsertId();

        foreach ($cells as $col => $val) {
            $val = $myts->addSlashes($val);
            $sql = "insert into `" . $xoopsDB->prefix("jill_query_col_value") . "` (`ssn`, `qcsn`, `fillValue`) values('{$ssn}',{$qcsn_arr[$col]} ,'{$val}' )";
            $xoopsDB->queryF($sql) or Utility::web_error($sql);
        }

    }

    return $qsn;
}

//刪除jill_query_col_valuer及jill_query_sn編號$ssn資料
function delete_jill_query_col_value($ssn = "")
{
    global $xoopsDB;

    if (empty($ssn)) {
        return;
    }
    //查詢傳入$ssn的qrSort
    $sql = "select qsn,qrSort from `" . $xoopsDB->prefix("jill_query_sn") . "`
    where `ssn` = '{$ssn}'";
    $result                 = $xoopsDB->query($sql) or Utility::web_error($sql);
    list($qsn, $def_qrSort) = $xoopsDB->fetchRow($result);

    $sql = "delete from `" . $xoopsDB->prefix("jill_query_col_value") . "`
        where `ssn`='{$ssn}' ";
    $xoopsDB->queryF($sql) or Utility::web_error($sql);

    $sql = "delete from `" . $xoopsDB->prefix("jill_query_sn") . "`
        where `ssn`='{$ssn}' ";
    $xoopsDB->queryF($sql) or Utility::web_error($sql);
    //重新排列qrSort
    //UPDATE `xx_jill_query_sn` SET`qrSort` = `qrSort`-1 WHERE `qrSort` >'8';
    $sql = "update " . $xoopsDB->prefix("jill_query_sn") . " set `qrSort`=`qrSort`-1 where `qrSort`>'{$def_qrSort}' && `qsn`='{$qsn}' ";
    $xoopsDB->queryF($sql) or Utility::web_error($sql);
}

//自動取得jill_query_sn的最新排序
function jill_query_max_qrSort($qsn = "")
{
    global $xoopsDB;
    $sql        = "select max(`qrSort`) from `" . $xoopsDB->prefix("jill_query_sn") . "` where `qsn`=$qsn";
    $result     = $xoopsDB->query($sql) or Utility::web_error($sql);
    list($sort) = $xoopsDB->fetchRow($result);
    return $sort;
}

/*-----------執行動作判斷區----------*/

switch ($op) {
/*---判斷動作請貼在下方---*/
//匯入資料
    case 'import_excel':
        // die($qsn);
        import_excel($qsn);
        header("location: {$_SERVER['PHP_SELF']}?qsn=$qsn");
        break;

    //刪除資料
    case "delete_jill_query_col_value":
        delete_jill_query_col_value($ssn);
        header("location: {$_SERVER['PHP_SELF']}?qsn=$qsn");
        exit;
    default:
        if (empty($qsn)) {
            redirect_header("index.php", 3, _MD_JILLQUERY_EMPTYQSN);
        } else {
            list_data($qsn);
        }
        break;

        /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign("toolbar", Utility::toolbar_bootstrap($interface_menu));
$xoopsTpl->assign("isAdmin", $isAdmin);
$xoopsTpl->assign('iseditAdm', $iseditAdm);
include_once XOOPS_ROOT_PATH . '/footer.php';
