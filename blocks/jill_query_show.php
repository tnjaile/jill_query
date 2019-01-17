<?php

/**
 * A module
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
 * @package    A
 * @since      a
 * @author     a
 * @version    $Id $
 **/
include_once XOOPS_ROOT_PATH . "/modules/jill_query/function_block.php";
//區塊主函式 (jill_query_show)
function jill_query_show($options)
{
    global $xoopsDB, $xoTheme;
    //die($options[0] . "asd");
    if (empty($options)) {
        return;
    }
    $query_arr = get_jill_query($options[0]);

    //die(var_dump($query_arr));
    $myts = MyTextSanitizer::getInstance();
    $sql  = "select * from `" . $xoopsDB->prefix("jill_query_col") . "`
          where `qsn`='{$options[0]}' && `qcsnSearch`=1 order by `qcSort`";
    //die($sql);
    $result           = $xoopsDB->query($sql) or web_error($sql);
    $block['content'] = array();
    $i                = 0;
    while ($all = $xoopsDB->fetchArray($result)) {
        //以下會產生這些變數： qcsn,qsn,qc_title,qcsnSearch,search_operator,isShow,qcSort
        foreach ($all as $k => $v) {
            $$k = $v;
        }
        //過濾讀出的變數值
        $qc_title                                = $myts->htmlSpecialChars($qc_title);
        $block['content'][$i]['qcsn']            = $qcsn;
        $block['content'][$i]['qc_title']        = $qc_title;
        $block['content'][$i]['qcsnSearch']      = $qcsnSearch;
        $block['content'][$i]['search_operator'] = $search_operator;
        $block['content'][$i]['isShow']          = $isShow;
        $block['content'][$i]['qcSort']          = $qcSort;
        $i++;
    }
    //die(var_dump($block));
    $block['query_arr'] = $query_arr;
    $block['qsn']       = $options[0];
    return $block;
}

//區塊編輯函式 (jill_query_show_edit)
function jill_query_show_edit($options)
{
    $default_qsn = (empty($options[0])) ? "" : $options[0];

    $option = get_jill_query_menu_options($default_qsn);

    //die(var_dump($opt_arr));
    $form = "
  <table>
  	<tr>
      <th>
        <!--選擇查詢事件 -->
        " . _MB_JILL_QUERY__OPT0 . "
      </th>
      <td>
        <select name='options[0]'>
            <option value=''>" . _MB_JILL_QUERY__OPT0 . "</option>
			   {$option}
        </select>
      </td>
    </tr>
  </table>
  ";
    return $form;
}

//取得jill_query分類選單的選項（單層選單）
function get_jill_query_menu_options($default_qsn = "")
{
    global $xoopsDB;

    $sql = "select `qsn`, `title`
    from `" . $xoopsDB->prefix("jill_query") . "` where `isEnable`='1' order by `qsn` desc ";
    $result = $xoopsDB->query($sql) or web_error($sql);

    $option = '';
    while (list($qsn, $title) = $xoopsDB->fetchRow($result)) {
        $selected = ($qsn == $default_qsn) ? 'selected = "selected"' : '';
        $option .= "<option value='{$qsn}' $selected>{$title}</option>";
    }
    return $option;
}
