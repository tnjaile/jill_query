<?php
/**
 *
 * @authors Your Name (you@example.org)
 * @date    2017-01-16 15:48:14
 * @version $Id$
 */
if (!function_exists("get_jill_query")) {
    //以流水號取得某筆jill_query資料
    function get_jill_query($qsn = '')
    {
        global $xoopsDB;

        if (empty($qsn)) {
            return;
        }

        $sql = "select * from `" . $xoopsDB->prefix("jill_query") . "`
    	where `qsn` = '{$qsn}'";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql);
        $data   = $xoopsDB->fetchArray($result);
        return $data;
    }
}
if (!function_exists("count_jill_query_col_qsn")) {
    //以流水號取得某事件編號欄位jill_query_col共幾欄
    function count_jill_query_col_qsn($qsn = '')
    {
        global $xoopsDB;

        if (empty($qsn)) {
            return;
        }
        $sql = "select count(*) from `" . $xoopsDB->prefix("jill_query_col") . "`
    where `qsn` = '{$qsn}'";
        $result      = $xoopsDB->query($sql) or Utility::web_error($sql);
        list($count) = $xoopsDB->fetchRow($result);
        return $count;
    }
}
if (!function_exists("get_jill_query_allcol_qsn")) {
    //以流水號取得某筆jill_query_col資料
    function get_jill_query_allcol_qsn($qsn = '')
    {
        global $xoopsDB;

        if (empty($qsn)) {
            return;
        }

        $sql = "select * from `" . $xoopsDB->prefix("jill_query_col") . "`
    where `qsn` = '{$qsn}' order by `qcSort`";
        $result   = $xoopsDB->query($sql) or Utility::web_error($sql);
        $data_arr = array();
        while ($data = $xoopsDB->fetchArray($result)) {
            $qcsn            = $data['qcsn'];
            $data_arr[$qcsn] = $data;
        }
        return $data_arr;
    }
}
if (!function_exists("get_jill_query_col_fillValue_qsn")) {
    //以qsn取得所有jill_query_col的qscn
    function get_jill_query_col_fillValue_qsn($ssn = '', $qcsn = '')
    {
        global $xoopsDB;

        if (empty($ssn) || empty($qcsn)) {
            return;
        }

        $sql = "select fillValue from `" . $xoopsDB->prefix("jill_query_col_value") . "`
        where `ssn` = '{$ssn}' && `qcsn`='{$qcsn}' ";
        $result          = $xoopsDB->query($sql) or Utility::web_error($sql);
        list($fillValue) = $xoopsDB->fetchRow($result);

        if (substr(trim($fillValue), 0, 4) == "http") {

            $fillValue = "<a href='{$fillValue}' target='_blank'>{$fillValue}</a>";
        }
        return $fillValue;
    }
}

if (!function_exists("get_public_menu_options")) {
    //取得jill_query公開查詢事件選單的選項（單層選單）
    function get_public_menu_options($default_qsn = "")
    {
        global $xoopsDB;

        $sql = "select `qsn`, `title`
    from `" . $xoopsDB->prefix("jill_query") . "` where `isEnable`='1' && `ispublic`='1' order by `qsn` desc ";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql);

        $option = '';
        while (list($qsn, $title) = $xoopsDB->fetchRow($result)) {
            $selected = ($qsn == $default_qsn) ? 'selected = "selected"' : '';
            $option .= "<option value='{$qsn}' $selected>{$title}</option>";
        }
        return $option;
    }
}

if (!function_exists("filter_by_value")) {
    /*
     * 過濾多維陣列
     */
    function filter_by_value($array, $index, $value)
    {
        if (is_array($array) && count($array) > 0) {
            foreach (array_keys($array) as $key) {
                $temp[$key] = $array[$key][$index];

                if ($temp[$key] == $value) {
                    $newarray[$key] = $array[$key];
                }
            }
        }
        return $newarray;
    }
}
