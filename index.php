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
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
include "header.php";
$xoopsOption['template_main'] = 'jill_query_index.tpl';
include_once XOOPS_ROOT_PATH . "/header.php";

/*-----------功能函數區--------------*/
//查詢
function search($qsn = '')
{
    global $xoopsDB, $xoopsTpl;
    // die('aa');
    if (empty($qsn)) {
        return;
    }

    $query_arr = get_jill_query($qsn);

    if (empty($query_arr)) {
        redirect_header("index.php", 3, _MD_JILLQUERY_EMPTYQSN);
    }

    if (empty($query_arr['isEnable'])) {
        redirect_header("index.php", 3, _MD_JILLQUERY_CLOSED);
        exit;

    }

    // 是否有權限
    if (!group_perm($query_arr['read_group'])) {
        redirect_header("index.php", 3, _MD_JILLQUERY_ILLEGAL);
    }

    add_jill_query_counter($qsn);
    $myts = \MyTextSanitizer::getInstance();
    $sql  = "select * from `" . $xoopsDB->prefix("jill_query_col") . "`
          where `qsn`='$qsn' && `qcsnSearch`=1 order by `qcSort`";
    //die($sql);
    $result = $xoopsDB->query($sql) or Utility::web_error($sql);
    $total  = $xoopsDB->getRowsNum($result);
    if (empty($total)) {
        redirect_header("index.php", 3, _MD_JILLQUERY_EMPTY_SEARCH);
    }

    $all_content = array();
    $i           = 0;
    while ($all = $xoopsDB->fetchArray($result)) {
        //以下會產生這些變數： qcsn,qsn,qc_title,qcsnSearch,search_operator,isShow,qcSort
        foreach ($all as $k => $v) {
            $$k = $v;
        }
        //過濾讀出的變數值
        $qc_title                           = $myts->htmlSpecialChars($qc_title);
        $all_content[$i]['qcsn']            = $qcsn;
        $all_content[$i]['qc_title']        = $qc_title;
        $all_content[$i]['qcsnSearch']      = $qcsnSearch;
        $all_content[$i]['search_operator'] = $search_operator;
        $all_content[$i]['isShow']          = $isShow;
        $all_content[$i]['qcSort']          = $qcSort;
        $all_content[$i]['isLike']          = $isLike;
        $i++;
    }
    //套用formValidator驗證機制
    $formValidator      = new FormValidator("#myForm", true);
    $formValidator_code = $formValidator->render();
    $xoopsTpl->assign('formValidator_code', $formValidator_code);

    $xoopsTpl->assign('qsn', $qsn);
    $xoopsTpl->assign('title', $query_arr['title']);
    $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    $xoopsTpl->assign('all_col', $all_content);
    $xoopsTpl->assign('query_arr', $query_arr);
    $xoopsTpl->assign('iseditAdm', get_undertaker($qsn));
}

//列出所有jill_query資料
function list_jill_query()
{
    global $xoopsDB, $xoopsTpl, $isAdmin;

    $myts = \MyTextSanitizer::getInstance();
    // 取得所有標籤名
    $tag_opt = tag_menu();
    if (isset($_GET['tag_sn'])) {
        $_GET['tag_sn'] = Request::getInt('tag_sn');
        $xoopsTpl->assign('tag_sn', $_GET['tag_sn']);
    }

    $and_tag = empty($_GET['tag_sn']) ? "" : "&& tag_sn='{$_GET['tag_sn']}'";
    $sql     = "select * from `" . $xoopsDB->prefix("jill_query") . "` where isEnable='1' $and_tag order by qsn desc ";
    $PageBar = Utility::getPageBar($sql, 20, 10);
    $bar     = $PageBar['bar'];
    $sql     = $PageBar['sql'];
    $total   = $PageBar['total'];

    $result = $xoopsDB->query($sql) or Utility::web_error($sql);

    $all_content = array();
    $i           = 0;

    while ($all = $xoopsDB->fetchArray($result)) {
        //以下會產生這些變數： $qsn, $title, $directions, $editorEmail, $isEnable, $counter, $uid
        foreach ($all as $k => $v) {
            $$k = $v;
        }
        // 過濾權限
        // 是否有權限
        if (!group_perm($read_group)) {
            continue;
        }
        //將是/否選項轉換為圖示
        $isEnable = $isEnable == 1 ? '<img src="' . XOOPS_URL . '/modules/jill_query/images/yes.gif" alt="' . _YES . '" title="' . _YES . '">' : '<img src="' . XOOPS_URL . '/modules/jill_query/images/no.gif" alt="' . _NO . '" title="' . _NO . '">';

        //將 uid 編號轉換成使用者姓名（或帳號）
        $uid_name = XoopsUser::getUnameFromId($uid, 1);
        if (empty($uid_name)) {
            $uid_name = XoopsUser::getUnameFromId($uid, 0);
        }

        //過濾讀出的變數值
        $title       = $myts->htmlSpecialChars($title);
        $directions  = $myts->displayTarea($directions, 1, 1, 0, 1, 0);
        $editorEmail = $myts->htmlSpecialChars($editorEmail);

        $all_content[$i]['qsn']         = $qsn;
        $all_content[$i]['title']       = $title;
        $all_content[$i]['directions']  = $directions;
        $all_content[$i]['editorEmail'] = $editorEmail;
        $all_content[$i]['isEnable']    = $isEnable;
        $all_content[$i]['counter']     = $counter;
        $all_content[$i]['uid']         = $uid;
        $all_content[$i]['uid_name']    = $uid_name;
        //承辦人
        $all_content[$i]['iseditAdm'] = get_undertaker($qsn);

        $i++;
    }
    $xoopsTpl->assign('tag_opt', $tag_opt);
    $xoopsTpl->assign('bar', $bar);
    $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    $xoopsTpl->assign('isAdmin', $isAdmin);
    $xoopsTpl->assign('all_content', $all_content);
    $xoopsTpl->assign('now_op', 'list_jill_query');
}

//秀查詢結果
function show_result($qsn = "")
{
    global $xoopsDB, $xoopsTpl;

    if (empty($_POST['fillValue'])) {
        return;
    }

    // die("ads" . var_dump($_POST['fillValue']));
    $query_arr = get_jill_query($qsn);

    if (empty($query_arr['isEnable'])) {
        redirect_header($_SERVER["HTTP_REFERER"], 3, _MD_JILLQUERY_CLOSED);
        exit;

    }

    if (isset($_POST['passwd']) && $_POST['passwd'] != $query_arr['passwd']) {
        redirect_header($_SERVER["HTTP_REFERER"], 3, _MD_JILLQUERY_PASSWDERROR);
        exit;

    }

    // 是否有權限
    if (!group_perm($query_arr['read_group'])) {
        redirect_header("index.php", 3, _MD_JILLQUERY_ILLEGAL);
        exit;
    }

    $title_arr = get_jill_query_allcol_qsn($qsn);
    // die(var_dump($title_arr));
    $all_content = array();
    //過濾要秀出來的標題
    if (is_array($title_arr)) {
        $title_show_arr  = filter_by_value($title_arr, 'isShow', '1');
        $qcsn_arr        = array_keys($title_arr);
        $myts            = \MyTextSanitizer::getInstance();
        $search_operator = current($_POST['search_operator']);
        if ($search_operator == "and") {
            foreach ($_POST['fillValue'] as $qcsn => $fillValue) {
                $fillValue = $myts->addSlashes($fillValue);

                if (empty($fillValue)) {
                    redirect_header("{$_SERVER['PHP_SELF']}?op=search&qsn={$qsn}", 3, _MD_JILLQUERY_EMPTYVALUE);
                    exit;
                }
                $ssn_arr[] = get_jill_query_col_value_ssn($qcsn, $fillValue);
            }
            //取交集
            if (sizeof($ssn_arr) > 0) {
                $ssn_arr = call_user_func_array('array_intersect', $ssn_arr);
            }
            //製造資料表

        } else {

            foreach ($_POST['fillValue'] as $qcsn => $fillValue) {
                if (empty($fillValue)) {
                    continue;
                }
                $ssn_arr[] = get_jill_query_col_value_ssn($qcsn, $fillValue);
            }
            //取聯集
            if (isset($ssn_arr) && sizeof($ssn_arr) > 0) {
                $ssn_arr = array_unique(call_user_func_array('array_merge', $ssn_arr));
            }
        }
        if (isset($ssn_arr)) {
            // die(var_dump($ssn_arr));
            foreach ($ssn_arr as $key => $ssn) {
                foreach ($title_show_arr as $qcsn => $qc_arr) {
                    $all_content[$ssn][] = get_jill_query_col_fillValue_qsn($ssn, $qcsn);
                }
            }
            $total = sizeof($ssn_arr);
            $xoopsTpl->assign('total', sprintf(_MD_JILLQUERY_TOTAL, $total));
        }

        //die(var_dump($all_content));
        $xoopsTpl->assign('title_show_arr', $title_show_arr);

    }

    $xoopsTpl->assign('query_arr', $query_arr);
    $xoopsTpl->assign('all_content', $all_content);
    $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    $xoopsTpl->assign('qsn', $qsn);
    $xoopsTpl->assign('now_op', 'show_result');

    search($qsn);
}

//取得jill_query_col_value的ssn
function get_jill_query_col_value_ssn($qcsn = "", $fillValue = "")
{
    global $xoopsDB;

    if (empty($qcsn) || empty($fillValue)) {
        return;
    }
    //先抓是否啟用關鍵字
    $sql = "select `isLike` from `" . $xoopsDB->prefix("jill_query_col") . "`
    where `qcsn`='{$qcsn}' ";
    //die($sql);
    $result       = $xoopsDB->query($sql) or Utility::web_error($sql);
    list($isLike) = $xoopsDB->fetchRow($result);
    $isLike_str   = (empty($isLike)) ? " a.`fillValue` = '{$fillValue}' " : " a.`fillValue` like '%{$fillValue}%'";
    $sql          = "select a.`ssn` from `" . $xoopsDB->prefix("jill_query_col_value") . "` as a
		join `" . $xoopsDB->prefix("jill_query_sn") . "` as b on a.`ssn`=b.`ssn`
    where a.`qcsn`='{$qcsn}' && $isLike_str ";
    // die($sql);
    $result  = $xoopsDB->query($sql) or Utility::web_error($sql);
    $ssn_arr = array();
    $i       = 0;
    while (list($ssn) = $xoopsDB->fetchRow($result)) {
        $ssn_arr[$i] = $ssn;
        $i++;
    }

    return $ssn_arr;
}

//新增jill_query計數器
function add_jill_query_counter($qsn = '')
{
    global $xoopsDB;

    if (empty($qsn)) {
        return;
    }

    $sql = "update `" . $xoopsDB->prefix("jill_query") . "`
    set `counter` = `counter` + 1
    where `qsn` = '{$qsn}'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql);
}
//公開查詢
function public_query($qsn)
{
    global $xoopsDB, $xoopsTpl;

    if (empty($qsn)) {
        return;
    }

    $query_arr = get_jill_query($qsn);
    if (empty($query_arr['ispublic'])) {
        redirect_header("{$_SERVER['PHP_SELF']}", 3, _MD_JILLQUERY_PUBLICERROR);
        exit;
    }

    // 是否有權限
    if (!group_perm($query_arr['read_group'])) {
        redirect_header("index.php", 3, _MD_JILLQUERY_ILLEGAL);
    }

    $option = get_public_menu_options($qsn);

    $title_arr = get_jill_query_allcol_qsn($qsn);
    if (is_array($title_arr)) {
        $title_show_arr = filter_by_value($title_arr, 'isShow', '1');
        $qcsn_arr       = array_keys($title_arr);
    }

    $myts = \MyTextSanitizer::getInstance();
    $sql  = "select ssn, qrSort  from `" . $xoopsDB->prefix("jill_query_sn") . "`
    where `qsn`='{$qsn}' order by `qrSort` ";
    //Utility::getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
    $PageBar = Utility::getPageBar($sql, 20, 10);
    $bar     = $PageBar['bar'];
    $sql     = $PageBar['sql'];
    $total   = $PageBar['total'];

    $result = $xoopsDB->query($sql) or Utility::web_error($sql);

    $all_content = array();
    while (list($ssn, $qrSort) = $xoopsDB->fetchRow($result)) {
        foreach ($title_show_arr as $qcsn => $qc_arr) {
            $all_content[$ssn]['col_data'][$qcsn] = get_jill_query_col_fillValue_qsn($ssn, $qcsn);

        }
        $all_content[$ssn]['qrSort'] = $qrSort;
    }
    $xoopsTpl->assign('title_arr', $title_show_arr);
    $xoopsTpl->assign('query_arr', $query_arr);
    $xoopsTpl->assign('all_content', $all_content);
    $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    $xoopsTpl->assign('qsn', $qsn);
    $xoopsTpl->assign('now_op', 'public_query');
    $xoopsTpl->assign('option_menu', $option);
    $xoopsTpl->assign('bar', $bar);
}
/*-----------執行動作判斷區----------*/
$op  = Request::getString('op');
$qsn = Request::getInt('qsn');

switch ($op) {
/*---判斷動作請貼在下方---*/
    case 'public_query':
        $public_qsn = (empty($_POST['public_qsn'])) ? $qsn : system_CleanVars($_REQUEST, 'public_qsn', '', 'int');
        public_query($public_qsn);
        break;
    case 'show_result':
        show_result($qsn);
        break;
// case 'search':
    //     search($qsn);
    //     break;
    default:
        if (empty($qsn)) {
            list_jill_query();
        } else {
            // $query_arr = get_jill_query($qsn);
            search($qsn);
        }
        break;

        /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign("toolbar", Utility::toolbar_bootstrap($interface_menu));
$xoopsTpl->assign("isAdmin", $isAdmin);
include_once XOOPS_ROOT_PATH . '/footer.php';
