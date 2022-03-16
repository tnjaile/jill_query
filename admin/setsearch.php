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

/*-----------引入檔案區--------------*/
use Xmf\Request;
use XoopsModules\Tadtools\Utility;
// use XoopsModules\Tadtools\Jeditable;
$xoopsOption['template_main'] = 'jill_query_adm_setsearch.tpl';
include_once "header.php";
include_once "../function.php";
$isAdmin = true;
/*-----------功能函數區--------------*/
function list_searchcol($qsn = "")
{
    global $xoopsDB, $xoopsTpl, $isAdmin;
    $queryArr = get_jill_query($qsn);

    if (empty($queryArr)) {
        redirect_header("main.php", 3, _MA_JILLQUERY_EMPTYQSN);
    }
    //jquery表單即點即編
    // $jeditable = new Jeditable();

    $myts = \MyTextSanitizer::getInstance();
    $sql  = "select * from `" . $xoopsDB->prefix("jill_query_col") . "`
          where `qsn`='$qsn' && `qcsnSearch`=1 order by `qcSort`";
    //die($sql);
    $result = $xoopsDB->query($sql) or Utility::web_error($sql);
    $total  = $xoopsDB->getRowsNum($result);
    if (empty($total)) {
        redirect_header("setcol.php?qsn={$qsn}", 3, _MA_JILLQUERY_SETCOL);
    } elseif ($total == "1") {
        redirect_header(XOOPS_URL . "/modules/jill_query/index.php?qsn={$qsn}", 3, _MA_JILLQUERY_SETSEARCH_NON);
    }
    $all_content = array();
    $i           = 0;
    while ($all = $xoopsDB->fetchArray($result)) {
        //以下會產生這些變數： qcsn,qsn,qc_title,qcsnSearch,search_operator,isShow,qcSort
        foreach ($all as $k => $v) {
            $$k = $v;
        }

        $qcsnSearch = $qcsnSearch == 1 ? "<img src='" . XOOPS_URL . "/modules/jill_query/images/yes.gif' id='{$qcsn}_qcsnSearch' onClick=\"change_enable($qcsn,'qcsnSearch');\" style='cursor: pointer;'>" : "<img src='" . XOOPS_URL . "/modules/jill_query/images/no.gif' id='{$qcsn}_qcsnSearch' onClick=\"change_enable($qcsn,'qcsnSearch');\" style='cursor: pointer;'>";

        //過濾讀出的變數值
        $qc_title            = $myts->htmlSpecialChars($qc_title);
        $search_operator     = $myts->htmlSpecialChars($search_operator);
        $def_search_operator = (empty($search_operator) || $search_operator == "and") ? "and" : "or";

        // $jeditable->setTextCol("#qc_title{$qcsn}", 'setcol.php', '100%', '11pt', "{'qcsn':$qcsn,'op' : 'save_qc_title'}", _TAD_EDIT . _MA_JILLBOOKIN_JBT_TITLE);
        $all_content[$i]['qc_title']        = $qc_title;
        $all_content[$i]['search_operator'] = $search_operator;
        $i++;
    }
    //die(var_dump($all_content));

    // $xoopsTpl->assign('jill_query_col_jquery_ui', Utility::get_jquery(true));
    $xoopsTpl->assign('qsn', $qsn);
    $xoopsTpl->assign('title', $queryArr['title']);
    $xoopsTpl->assign('ispublic', $queryArr['ispublic']);
    $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    $xoopsTpl->assign('isAdmin', $isAdmin);
    $xoopsTpl->assign('def_search_operator', $def_search_operator);
    $xoopsTpl->assign('all_col', $all_content);
    $xoopsTpl->assign('now_op', 'list_searchcol');
}
function update_searchcol($qsn = "")
{
    global $xoopsDB, $isAdmin, $xoopsUser;
    if (!$isAdmin) {
        redirect_header($_SERVER['PHP_SELF'], 3, _TAD_PERMISSION_DENIED);
    }

    $myts = \MyTextSanitizer::getInstance();

    $search_operator = ($_POST['ispublic'] == 2) ? 'and' : $myts->addSlashes($_POST['search_operator']);

    $sql = "update `" . $xoopsDB->prefix("jill_query_col") . "` set
       `search_operator` = '{$search_operator}'
    where `qsn` = '$qsn' && `qcsnSearch`='1' ";
    $xoopsDB->queryF($sql) or Utility::web_error($sql);
    return $qsn;
}
/*-----------執行動作判斷區----------*/
$op   = Request::getString('op');
$qsn  = Request::getInt('qsn');
$qcsn = Request::getInt('qcsn');
switch ($op) {
/*---判斷動作請貼在下方---*/

//更新資料
    case "update_searchcol":
        update_searchcol($qsn);
        header("location: {$_SERVER['PHP_SELF']}?qsn=$qsn");
        exit;

    default:
        if (empty($qsn)) {
            redirect_header("main.php", 3, _MA_JILLQUERY_EMPTYQSN);
        } else {
            list_searchcol($qsn);
        }
        break;

        /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign("isAdmin", true);
include_once 'footer.php';
