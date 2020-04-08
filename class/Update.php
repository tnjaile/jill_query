<?php
namespace XoopsModules\Jill_query;

/*
Update Class Definition

You may not change or alter any portion of this comment or credits of
supporting developers from this source code or any supporting source code
which is considered copyrighted (c) material of the original comment or credit
authors.

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @license      http://www.fsf.org/copyleft/gpl.html GNU public license
 * @copyright    https://xoops.org 2001-2017 &copy; XOOPS Project
 * @author       Mamba <mambax7@gmail.com>
 */

/**
 * Class Update
 */
class Update
{

    public static function del_interface()
    {
        if (file_exists(XOOPS_ROOT_PATH . '/modules/jill_query/interface_menu.php')) {
            unlink(XOOPS_ROOT_PATH . '/modules/jill_query/interface_menu.php');
        }
    }

    //檢查某欄位是否存在
    public static function chk_chk6()
    {
        global $xoopsDB;
        $sql    = "select `read_group` from " . $xoopsDB->prefix("jill_query");
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return true;
        }

        return false;
    }
    //執行更新
    public static function go_update6()
    {
        global $xoopsDB;
        $sql = "ALTER TABLE " . $xoopsDB->prefix("jill_query") . " ADD `read_group` varchar(255) DEFAULT '[\"3\"]' COLLATE 'utf8_general_ci' NOT NULL COMMENT '可讀取群組'";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL, 3, $xoopsDB->error());
        return true;
    }
    //檢查某欄位是否存在
    public static function chk_chk1()
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
    public static function chk_chk5()
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
    public static function go_update5()
    {
        global $xoopsDB;

        $sql = "ALTER TABLE " . $xoopsDB->prefix("jill_query_col") . " ADD `isLike` enum('0','1') NOT NULL DEFAULT '0' COMMENT '啟用關鍵字查詢' ";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL, 3, $xoopsDB->error());
        return true;
    }
    //檢查某欄位是否存在
    public static function chk_chk2()
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
    public static function chk_chk3()
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
    public static function chk_chk4()
    {
        global $xoopsDB;
        $sql    = "show columns from " . $xoopsDB->prefix("jill_query") . " where Field='editorEmail' && Type='varchar(255)' ";
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    //執行更新
    public static function go_update1()
    {
        global $xoopsDB;
        $sql = "ALTER TABLE " . $xoopsDB->prefix("jill_query") . " ADD `passwd` varchar(255) COLLATE 'utf8_general_ci' NOT NULL COMMENT '密碼'";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL, 3, $xoopsDB->error());
        return true;
    }

    //執行更新
    public static function go_update2()
    {
        global $xoopsDB;
        $sql = "ALTER TABLE " . $xoopsDB->prefix("jill_query") . " ADD `ispublic` enum('0','1')  COLLATE 'utf8_general_ci' NOT NULL COMMENT '是否公開' ";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL, 3, $xoopsDB->error());
        return true;
    }

    //執行更新
    public static function go_update3()
    {
        global $xoopsDB, $xoopsUser;
        $uid = $xoopsUser->uid();
        $sql = "ALTER TABLE " . $xoopsDB->prefix("jill_query_sn") . " ADD `uid` mediumint(8) unsigned NOT NULL default $uid COMMENT '匯入者帳號' ";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL, 3, $xoopsDB->error());
        return true;
    }

    //修正editorEmail 欄位，改為text
    public static function go_update4()
    {
        global $xoopsDB;
        $sql = "ALTER TABLE " . $xoopsDB->prefix("jill_query") . " CHANGE `editorEmail` `editorEmail` text NOT NULL COMMENT '承辦人Email' AFTER `directions` ";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL, 3, $xoopsDB->error());
        return true;
    }

}
