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

function xoops_module_update_jill_query($module, $old_version)
{
    global $xoopsDB;

    if (chk_chk1()) {
        go_update1();
    }
    if (chk_chk2()) {
        go_update2();
    }
    if (chk_chk3()) {
        go_update3();
    }
    if (chk_chk4()) {
        go_update4();
    }
    if (chk_chk5()) {
        go_update5();
    }
    return true;
}
//檢查某欄位是否存在
function chk_chk1()
{
    global $xoopsDB;
    $sql    = "select `passwd` from " . $xoopsDB->prefix("jill_query");
    $result = $xoopsDB->query($sql);
    if (empty($result)) {
        return true;
    }

    return false;
}
//檢查某欄位是否存在
function chk_chk5()
{
    global $xoopsDB;
    $sql    = "select `isLike` from " . $xoopsDB->prefix("jill_query_col");
    $result = $xoopsDB->query($sql);
    if (empty($result)) {
        return true;
    }

    return false;
}
//執行更新
function go_update5()
{
    global $xoopsDB;

    $sql = "ALTER TABLE " . $xoopsDB->prefix("jill_query_col") . " ADD `isLike` enum('0','1') NOT NULL DEFAULT '0' COMMENT '啟用關鍵字查詢' ";
    $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL, 3, $xoopsDB->error());
    return true;
}
//檢查某欄位是否存在
function chk_chk2()
{
    global $xoopsDB;
    $sql    = "select `ispublic` from " . $xoopsDB->prefix("jill_query");
    $result = $xoopsDB->query($sql);
    if (empty($result)) {
        return true;
    }

    return false;
}

//檢查某欄位是否存在
function chk_chk3()
{
    global $xoopsDB;
    $sql    = "select `uid` from " . $xoopsDB->prefix("jill_query_sn");
    $result = $xoopsDB->query($sql);
    if (empty($result)) {
        return true;
    }

    return false;
}

//檢查editorEmail 欄位 varchar(255) 是否存在
function chk_chk4()
{
    global $xoopsDB;
    $sql    = "show columns from " . $xoopsDB->prefix("jill_query") . " where Field='editorEmail' && Type='varchar(255)' ";
    $result = $xoopsDB->query($sql);
    if (empty($result)) {
        return false;
    }

    return true;
}

// //執行更新
function go_update1()
{
    global $xoopsDB;
    $sql = "ALTER TABLE " . $xoopsDB->prefix("jill_query") . " ADD `passwd` varchar(255) COLLATE 'utf8_general_ci' NOT NULL COMMENT '密碼'";
    $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL, 3, $xoopsDB->error());

    return true;
}

//執行更新
function go_update2()
{
    global $xoopsDB;
    $sql = "ALTER TABLE " . $xoopsDB->prefix("jill_query") . " ADD `ispublic` enum('0','1')  COLLATE 'utf8_general_ci' NOT NULL COMMENT '是否公開' ";
    $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL, 3, $xoopsDB->error());

    return true;
}

//執行更新
function go_update3()
{
    global $xoopsDB, $xoopsUser;
    $uid = $xoopsUser->uid();
    $sql = "ALTER TABLE " . $xoopsDB->prefix("jill_query_sn") . " ADD `uid` mediumint(8) unsigned NOT NULL default $uid COMMENT '匯入者帳號' ";
    $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL, 3, $xoopsDB->error());
    return true;
}

//修正editorEmail 欄位，改為text
function go_update4()
{
    global $xoopsDB;
    $sql = "ALTER TABLE " . $xoopsDB->prefix("jill_query") . " CHANGE `editorEmail` `editorEmail` text NOT NULL COMMENT '承辦人Email' AFTER `directions` ";
    $xoopsDB->queryF($sql) or web_error($sql);
    return true;
}
// //建立目錄
// function mk_dir($dir = "")
// {
//     //若無目錄名稱秀出警告訊息
//     if (empty($dir)) {
//         return;
//     }

//     //若目錄不存在的話建立目錄
//     if (!is_dir($dir)) {
//         umask(000);
//         //若建立失敗秀出警告訊息
//         mkdir($dir, 0777);
//     }
// }

// //拷貝目錄
// function full_copy($source = "", $target = "")
// {
//     if (is_dir($source)) {
//         @mkdir($target);
//         $d = dir($source);
//         while (false !== ($entry = $d->read())) {
//             if ($entry == '.' || $entry == '..') {
//                 continue;
//             }

//             $Entry = $source . '/' . $entry;
//             if (is_dir($Entry)) {
//                 full_copy($Entry, $target . '/' . $entry);
//                 continue;
//             }
//             copy($Entry, $target . '/' . $entry);
//         }
//         $d->close();
//     } else {
//         copy($source, $target);
//     }
// }

// function rename_win($oldfile, $newfile)
// {
//     if (!rename($oldfile, $newfile)) {
//         if (copy($oldfile, $newfile)) {
//             unlink($oldfile);
//             return true;
//         }
//         return false;
//     }
//     return true;
// }

// function delete_directory($dirname)
// {
//     if (is_dir($dirname)) {
//         $dir_handle = opendir($dirname);
//     }

//     if (!$dir_handle) {
//         return false;
//     }

//     while ($file = readdir($dir_handle)) {
//         if ($file != "." && $file != "..") {
//             if (!is_dir($dirname . "/" . $file)) {
//                 unlink($dirname . "/" . $file);
//             } else {
//                 delete_directory($dirname . '/' . $file);
//             }

//         }
//     }
//     closedir($dir_handle);
//     rmdir($dirname);
//     return true;
// }
