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

//引入TadTools的函式庫
xoops_loadLanguage('main', 'tadtools');
include_once XOOPS_ROOT_PATH . "/modules/jill_query/function_block.php";
/********************* 自訂函數 *********************/
//標籤下拉選單
function tag_menu()
{
    global $xoopsDB;

    $sql    = 'SELECT tag_sn,tag FROM ' . $xoopsDB->prefix('jill_query_tags') . " WHERE `enable`='1'";
    $result = $xoopsDB->query($sql);
    $option = [];

    while (list($tag_sn, $tag) = $xoopsDB->fetchRow($result)) {
        $option[$tag_sn] = $tag;
    }

    return $option;
}
//以流水號取得某筆jill_query_col資料
function get_jill_query_col($qcsn = '')
{
    global $xoopsDB;

    if (empty($qcsn)) {
        return;
    }

    $sql = "select * from `" . $xoopsDB->prefix("jill_query_col") . "`
    where `qcsn` = '{$qcsn}'";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql);
    $data   = $xoopsDB->fetchArray($result);
    return $data;
}

//以qsn取得所有jill_query_col的qscn
function get_jill_query_allsn_qsn($qsn = '')
{
    global $xoopsDB, $xoopsTpl, $xoopsUser;

    if (empty($qsn)) {
        return;
    }
    $uid = $xoopsUser->uid();
    // $sql = "select ssn,qrSort from `" . $xoopsDB->prefix("jill_query_sn") . "`
    // where `qsn` = '{$qsn}' order by `qrSort` ";
    $sql = "select ssn,qrSort from `" . $xoopsDB->prefix("jill_query_sn") . "`
    where `qsn` = '{$qsn}' && `uid`='{$uid}' order by `qrSort` ";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql);
    // die($sql);
    $ssn_arr = array();
    while (list($ssn, $qrSort) = $xoopsDB->fetchRow($result)) {
        $ssn_arr[$qrSort] = $ssn;
    }

    return $ssn_arr;
}

//以流水號取得某事件編號資料筆數jill_query_sn資料
function count_jill_query_sn($qsn = '')
{
    global $xoopsDB;

    if (empty($qsn)) {
        return;
    }

    $sql = "select count(*) from `" . $xoopsDB->prefix("jill_query_sn") . "`
    where `qsn` = '{$qsn}'";
    //die($sql);
    $result      = $xoopsDB->query($sql) or Utility::web_error($sql);
    list($count) = $xoopsDB->fetchRow($result);
    return $count;
}

//自動取得jill_query_col的運算符
function jill_query_col_search_operator($qsn = "")
{
    global $xoopsDB;
    $sql                   = "select DISTINCT search_operator from `" . $xoopsDB->prefix("jill_query_col") . "` where `qsn`=$qsn && (`search_operator` !='') ";
    $result                = $xoopsDB->query($sql) or Utility::web_error($sql);
    list($search_operator) = $xoopsDB->fetchRow($result);
    return $search_operator;
}

//刪除jill_query_col_value及jill_query_sn編號$qsn資料
function delete_data($qsn = "")
{
    global $xoopsDB, $isAdmin, $xoopsUser;

    if (!get_undertaker($qsn)) {
        redirect_header($_SERVER['PHP_SELF'], 3, _TAD_PERMISSION_DENIED);
    }

    if (empty($qsn)) {
        return;
    }
    $uid     = $xoopsUser->uid();
    $ssn_arr = get_jill_query_allsn_qsn($qsn);
    foreach ($ssn_arr as $ssn) {
        $sql = "delete from `" . $xoopsDB->prefix("jill_query_col_value") . "`
        where `ssn`='{$ssn}' ";
        $xoopsDB->queryF($sql) or Utility::web_error($sql);
    }

    $sql = "delete from `" . $xoopsDB->prefix("jill_query_sn") . "`
        where `qsn`='{$qsn}' && `uid`='{$uid}' ";
    $xoopsDB->queryF($sql) or Utility::web_error($sql);

    $sql = "select ssn from `" . $xoopsDB->prefix("jill_query_sn") . "`
    where `qsn` = '{$qsn}'  order by `ssn` ";
    //die($sql);
    $result = $xoopsDB->query($sql) or Utility::web_error($sql);
    $i      = 1;
    while (list($ssn) = $xoopsDB->fetchRow($result)) {
        $sql = "update `" . $xoopsDB->prefix("jill_query_sn") . "` set qrSort='{$i}' where `ssn`='{$ssn}' ";
        $xoopsDB->queryF($sql) or Utility::web_error($sql);
        $i++;
    }

}
/********************* XOOPS檢查身分函數 *********************/
//判斷承辦人
function get_undertaker($qsn)
{
    global $xoopsUser, $xoopsDB, $isAdmin;
    if (!$xoopsUser) {
        return;
    }
    $uemail = $xoopsUser->email();
    // $sql    = "select `editorEmail` from `" . $xoopsDB->prefix("jill_query") . "` where qsn='$qsn' and `editorEmail` LIKE '%{$uemail}%' &&  `isEnable`='1' ";
    $sql = "select `editorEmail` from `" . $xoopsDB->prefix("jill_query") . "` where qsn='$qsn'  &&  `isEnable`='1' ";
    //die($sql);
    $result            = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, Utility::web_error($sql));
    list($editorEmail) = $xoopsDB->fetchRow($result);
    //避免填入空白
    $editorEmail = str_replace(" ", "", $editorEmail);
    $editor_arr  = explode(";", $editorEmail);
    //die(var_dump($editor_arr));
    if (in_array($uemail, $editor_arr) or $isAdmin) {
        return true;
    } else {
        return false;
    }
}

//針對excel各種數據類型
function get_value_of_cell($cell = "")
{
    if (is_null($cell)) {
        $value = $cell->setIterateOnlyExistingCells(true);
    } else {
        if (strstr($cell->getValue(), '=')) {
            $value = $cell->getCalculatedValue();
        } else if ($cell->getValue() instanceof PHPExcel_RichText) {
            $value = $cell->getValue()->getPlainText();
        } else if (PHPExcel_Shared_Date::isDateTime($cell)) {
            //$value = $cell->getFormattedValue();
            $value = PHPExcel_Shared_Date::ExcelToPHPObject($cell->getValue())->format('Y-m-d');
        } else {
            $value = $cell->getValue();
        }
    }

    return $value;
}

//抓取群組名
function get_groupname($group_id)
{
    $group_handler = xoops_gethandler('group');
    $groupname     = $group_handler->get($group_id)->name();
    return $groupname;
}

//抓取所有群組(除訪客外)
function get_all_groups($filterOutKeys = array())
{

    $member_handler = xoops_gethandler('member');
    $group_list     = $member_handler->getGroupList();
    // $filterOutKeys  = array(3);
    $group_list = array_diff_key($group_list, array_flip($filterOutKeys));
    // die(var_dump($group_list));
    return $group_list;
}

//檢查是否具有權限
function group_perm($haystack_groups)
{
    global $xoopsUser, $isAdmin;
    $haystack_groups = json_decode($haystack_groups, true);
    if ($xoopsUser) {
        if ($isAdmin) {
            return true;
            exit;
        }

        $needle_groups = array_unique($xoopsUser->groups());

        foreach ($needle_groups as $key => $group) {
            if (in_array($group, $haystack_groups)) {
                return true;
            }
        }
    } else {
        // 訪客可讀取
        if (in_array(3, $haystack_groups)) {
            return true;
        }
    }
    return false;
}
