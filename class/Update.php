<?php
namespace XoopsModules\Jill_query;

use XoopsModules\Tadtools\Utility;

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
    //檢查`ispublic` enum('0','1') NOT NULL COMMENT '是否公開'
    public static function chk_chk11()
    {
        global $xoopsDB;
        $sql = "show columns from " . $xoopsDB->prefix("jill_query") . " where Field='ispublic' && Type=\"enum('0','1')\"";
        // die($sql);
        $result = $xoopsDB->query($sql) or Utility::web_error($sql);
        if (empty($result->num_rows)) {
            return false;
        }
        return true;
    }
    //修正`ispublic` enum('0','1','2') NOT NULL COMMENT '是否公開'
    public static function go_update11()
    {
        global $xoopsDB;
        $sql = "ALTER TABLE " . $xoopsDB->prefix("jill_query") . " CHANGE `ispublic` `ispublic` enum('0','1','2') NOT NULL COMMENT '是否公開' AFTER `passwd` ";
        $xoopsDB->queryF($sql) or Utility::web_error($sql);
        return true;
    }
    //檢查tag_sn 欄位 smallint(5)是否存在
    public static function chk_chk10()
    {
        global $xoopsDB;
        $sql    = 'SELECT count(`tag_sn`) FROM ' . $xoopsDB->prefix('jill_query');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update10()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('jill_query') . " ADD `tag_sn` SMALLINT(5) UNSIGNED NOT NULL  COMMENT '標籤編號'  AFTER `read_group` ";
        $xoopsDB->queryF($sql);
    }

    //新增標籤
    public static function chk_chk9()
    {
        global $xoopsDB;
        $sql    = 'SELECT count(*) FROM ' . $xoopsDB->prefix('jill_query_tags');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update9()
    {
        global $xoopsDB;
        $sql = "CREATE TABLE " . $xoopsDB->prefix('jill_query_tags') . " (
            `tag_sn` smallint(5) UNSIGNED NOT NULL auto_increment COMMENT '標籤編號',
            `tag` varchar(255) NOT NULL default ''  COMMENT '標籤',
            `font_color` varchar(255) NOT NULL default '' COMMENT '文字顏色',
            `color` varchar(255) NOT NULL default '' COMMENT '顏色',
            `enable` enum('0','1') NOT NULL default '1' COMMENT '是否啟用',
            PRIMARY KEY  (`tag_sn`)
        )";
        $xoopsDB->queryF($sql);
    }

    //檢查qcsn 欄位為第一
    public static function chk_chk8()
    {
        global $xoopsDB;
        $sql                    = "SELECT ORDINAL_POSITION from information_schema.`COLUMNS` where `TABLE_NAME`='" . $xoopsDB->prefix("jill_query_col") . "' && `COLUMN_NAME`='qcsn' ";
        $result                 = $xoopsDB->query($sql) or Utility::web_error($sql);
        list($ORDINAL_POSITION) = $xoopsDB->fetchRow($result);
        if ($ORDINAL_POSITION == '1') {
            return false;
        }
        return true;
    }

    //修正qcsn 欄位為第一
    public static function go_update8()
    {
        global $xoopsDB;
        $sql = "ALTER TABLE " . $xoopsDB->prefix("jill_query_col") . " CHANGE `qcsn` `qcsn` int(10) unsigned NOT NULL COMMENT '編號' AUTO_INCREMENT FIRST,
        CHANGE `qsn` `qsn` int(10) unsigned NOT NULL COMMENT '編號' AFTER `qcsn` ";
        $xoopsDB->queryF($sql) or Utility::web_error($sql);
        return true;
    }
    //檢查qcsn 欄位 smallint(6)是否存在
    public static function chk_chk7()
    {
        global $xoopsDB;
        $sql    = "show columns from " . $xoopsDB->prefix("jill_query_col") . " where Field='qcsn' && Type='smallint(6) unsigned' ";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql);
        if (empty($result->num_rows)) {
            return false;
        }
        return true;
    }

    //修正qcsn 欄位 smallint(6)，改為int(10)
    public static function go_update7()
    {
        global $xoopsDB;
        $sql = "ALTER TABLE " . $xoopsDB->prefix("jill_query_col") . " CHANGE `qcsn` `qcsn` int(10) unsigned NOT NULL COMMENT '編號' AUTO_INCREMENT FIRST ";
        $xoopsDB->queryF($sql) or Utility::web_error($sql);

        $sql = "ALTER TABLE " . $xoopsDB->prefix("jill_query_col") . " CHANGE `qcSort` `qcSort` int(10) unsigned NOT NULL COMMENT '排序欄位' AFTER `isShow` ";
        $xoopsDB->queryF($sql) or Utility::web_error($sql);
        return true;
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
        $sql = "ALTER TABLE " . $xoopsDB->prefix("jill_query") . " ADD `read_group` varchar(255) DEFAULT '[\"2\",\"3\"]' COLLATE 'utf8_general_ci' NOT NULL COMMENT '可讀取群組'";
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

    public static function del_interface()
    {
        if (file_exists(XOOPS_ROOT_PATH . '/modules/jill_query/interface_menu.php')) {
            unlink(XOOPS_ROOT_PATH . '/modules/jill_query/interface_menu.php');
        }
    }
}
