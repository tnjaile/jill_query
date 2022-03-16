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
use Xmf\Request;
use XoopsModules\Tadtools\Jeditable;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
$isAdmin                      = true;
$xoopsOption['template_main'] = 'jill_query_adm_setcol.tpl';
include_once "header.php";
include_once "../function.php";

/*-----------功能函數區--------------*/
function list_col($qsn = "")
{
    global $xoopsDB, $xoopsTpl, $isAdmin;
    $queryArr = get_jill_query($qsn);

    if (empty($queryArr)) {
        redirect_header("main.php", 3, _MA_JILLQUERY_EMPTYQSN);
    }

    $myts = \MyTextSanitizer::getInstance();
    $sql  = "select * from `" . $xoopsDB->prefix("jill_query_col") . "`
          where `qsn`='$qsn' order by `qcSort`";
    $result      = $xoopsDB->query($sql) or Utility::web_error($sql);
    $total       = $xoopsDB->getRowsNum($result);
    $all_content = array();
    $i           = 0;
    while ($all = $xoopsDB->fetchArray($result)) {
        //以下會產生這些變數： qcsn,qsn,qc_title,qcsnSearch,search_operator,isShow,qcSort
        foreach ($all as $k => $v) {
            $$k = $v;
        }
        //將是/否選項轉換為圖示
        $isShow = $isShow == 1 ? "<img src='" . XOOPS_URL . "/modules/jill_query/images/yes.gif' id='{$qcsn}_isShow' onClick=\"change_enable($qcsn,'isShow');\" style='cursor: pointer;'>" : "<img src='" . XOOPS_URL . "/modules/jill_query/images/no.gif' id='{$qcsn}_isShow' onClick=\"change_enable($qcsn,'isShow');\" style='cursor: pointer;'>";

        if ($qcsnSearch == 1) {

            if ($queryArr['ispublic'] == 2 && $qc_title == 'email') {
                $qcsnSearch = "<img src='" . XOOPS_URL . "/modules/jill_query/images/yes.gif' id='{$qcsn}_qcsnSearch' style='cursor: pointer;'>";

                $isLike = "<img src='" . XOOPS_URL . "/modules/jill_query/images/no.gif' id='{$qcsn}_isLike' style='cursor: pointer;'>";

            } else {
                $qcsnSearch = "<img src='" . XOOPS_URL . "/modules/jill_query/images/yes.gif' id='{$qcsn}_qcsnSearch' onClick=\"change_enable($qcsn,'qcsnSearch');\" style='cursor: pointer;'>";

                $isLike = $isLike == 1 ? "<img src='" . XOOPS_URL . "/modules/jill_query/images/yes.gif' id='{$qcsn}_isLike' onClick=\"change_enable($qcsn,'isLike');\" style='cursor: pointer;'>" : "<img src='" . XOOPS_URL . "/modules/jill_query/images/no.gif' id='{$qcsn}_isLike' onClick=\"change_enable($qcsn,'isLike');\" style='cursor: pointer;'>";
            }

        } else {
            $qcsnSearch = "<img src='" . XOOPS_URL . "/modules/jill_query/images/no.gif' id='{$qcsn}_qcsnSearch' onClick=\"change_enable($qcsn,'qcsnSearch');\" style='cursor: pointer;'>";
            $isLike     = "<img src='" . XOOPS_URL . "/modules/jill_query/images/no.gif' id='{$qcsn}_isLike' style='cursor: pointer;'>";
        }

        //過濾讀出的變數值
        $qc_title        = $myts->htmlSpecialChars($qc_title);
        $search_operator = $myts->htmlSpecialChars($search_operator);

        $all_content[$i]['qcsn']          = $qcsn;
        $all_content[$i]['qsn']           = $qsn;
        $all_content[$i]['title']         = $queryArr['title'];
        $all_content[$i]['qc_title']      = $qc_title;
        $all_content[$i]['qc_title_link'] = "<a href='{$_SERVER['PHP_SELF']}?qcsn={$qcsn}'>{$qc_title}</a>";
        $all_content[$i]['qcsnSearch']    = $qcsnSearch;
        //$all_content[$i]['search_operator'] = $search_operator;
        $all_content[$i]['isShow'] = $isShow;
        $all_content[$i]['isLike'] = $isLike;
        $all_content[$i]['qcSort'] = $qcSort;

        $qcinfo                      = get_jill_query_col_value_qcsn($qcsn);
        $all_content[$i]['show_del'] = (empty($qcinfo) && $queryArr['ispublic'] != 2) ? 1 : "";
        $i++;
    }
    // die(var_dump($all_content));
    //刪除確認的JS
    $sweet_alert_obj            = new SweetAlert();
    $delete_jill_query_col_func = $sweet_alert_obj->render('delete_jill_query_col_func',
        "{$_SERVER['PHP_SELF']}?op=delete_jill_query_col&qsn=$qsn&qcsn=", "qcsn");
    $xoopsTpl->assign('delete_jill_query_col_func', $delete_jill_query_col_func);

    //jquery表單即點即編
    $jeditable = new Jeditable();
    $jeditable->setTextCol(".qc_title", 'save_qc_title.php', '80%', '1.5em', "", _TAD_EDIT . _MA_JILLQUERY_QC_TITLE);
    $jeditable->render();

    $xoopsTpl->assign('jill_query_col_jquery_ui', Utility::get_jquery(true));
    $xoopsTpl->assign('qsn', $qsn);
    $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    $xoopsTpl->assign('isAdmin', $isAdmin);
    $xoopsTpl->assign('all_content', $all_content);
    $xoopsTpl->assign('now_op', 'list_col');
    $xoopsTpl->assign('queryArr', $queryArr);
}

//新增資料到jill_booking_time中
function insert_col($qsn = "")
{
    global $xoopsDB;

    $myts              = \MyTextSanitizer::getInstance();
    $_POST['qc_title'] = $myts->addSlashes($_POST['qc_title']);
    $qcsnSearch        = intval($_POST['qcsnSearch']);
    $isShow            = intval($_POST['isShow']);
    $isLike            = intval($_POST['isLike']);
    $qcSort            = jill_query_col_max_sort($qsn);
    $search_operator   = jill_query_col_search_operator($qsn);
    $search_operator   = (empty($search_operator)) ? "or" : $search_operator;
    //qsn,qc_title,qcsnSearch,search_operator,isShow,qcSort
    $sql = "insert into `" . $xoopsDB->prefix("jill_query_col") . "`
  (`qsn` , `qc_title` , `qcsnSearch`,`search_operator`,`isShow`,`qcSort`,`isLike`)
  values('{$qsn}' , '{$_POST['qc_title']}' , '{$qcsnSearch}','{$search_operator}','{$isShow}','{$qcSort}','{$isLike}')";
    $xoopsDB->query($sql) or Utility::web_error($sql);

    //取得最後新增資料的流水編號
    $qcsn = $xoopsDB->getInsertId();
    return $qsn;
}

//刪除jill_query_col某筆資料資料
function delete_jill_query_col($qcsn = '')
{
    global $xoopsDB, $isAdmin;
    if (!$isAdmin) {
        redirect_header($_SERVER['PHP_SELF'], 3, _TAD_PERMISSION_DENIED);
    }
    if (empty($qcsn)) {
        return;
    }

    $sql = "delete from `" . $xoopsDB->prefix("jill_query_col") . "`
    where `qcsn` = '{$qcsn}'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql);

}

//自動取得jill_query_col欄的最新排序
function jill_query_col_max_sort($qsn = "")
{
    global $xoopsDB;
    $sql        = "select max(`qcSort`) from `" . $xoopsDB->prefix("jill_query_col") . "` where `qsn`=$qsn";
    $result     = $xoopsDB->query($sql) or Utility::web_error($sql);
    list($sort) = $xoopsDB->fetchRow($result);
    return ++$sort;
}

//取得jill_query_col_value所有資料陣列
function get_jill_query_col_value_qcsn($qcsn = "")
{
    global $xoopsDB;
    if (empty($qcsn)) {
        return;
    }

    $sql = "select * from `" . $xoopsDB->prefix("jill_query_col_value") . "` where `qcsn`='{$qcsn}'";
    //die($sql);
    $result   = $xoopsDB->query($sql) or Utility::web_error($sql);
    $data_arr = array();
    while ($data = $xoopsDB->fetchArray($result)) {
        $ssn            = $data['ssn'];
        $data_arr[$ssn] = $data;
    }

    return $data_arr;
}

/*-----------執行動作判斷區----------*/
$op   = Request::getString('op');
$qsn  = Request::getInt('qsn');
$qcsn = Request::getInt('qcsn');
switch ($op) {
/*---判斷動作請貼在下方---*/

//新增資料
    case "insert_col":
        $qsn = insert_col($qsn);
        header("location: {$_SERVER['PHP_SELF']}?qsn=$qsn");
        exit;

    case "delete_jill_query_col":
        delete_jill_query_col($qcsn);
        header("location: {$_SERVER['PHP_SELF']}?qsn=$qsn");
        exit;

    default:
        if (empty($qsn)) {
            redirect_header("main.php", 3, _MA_JILLQUERY_EMPTYQSN);
        } else {
            list_col($qsn);
        }
        break;

        /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign("isAdmin", true);
include_once 'footer.php';
