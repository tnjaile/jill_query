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
//區塊主函式 (jill_query_public)
function jill_query_public($options)
{
    global $xoopsDB, $xoTheme;
    //die($options[0] . "asd");
    if (empty($options)) {
        return;
    }
    $show_nums      = empty($options[1]) ? 20 : $options[1];
    $query_arr      = get_jill_query($options[0]);
    $title_arr      = get_jill_query_allcol_qsn($options[0]);
    $title_show_arr = filter_by_value($title_arr, 'isShow', '1');
    $qcsn_arr       = array_keys($title_show_arr);

    $myts = MyTextSanitizer::getInstance();
    $sql  = "select ssn, qrSort  from `" . $xoopsDB->prefix("jill_query_sn") . "`
    where `qsn`='{$options[0]}' order by `qrSort` limit 0,{$show_nums} ";

    $result           = $xoopsDB->query($sql) or web_error($sql);
    $block['content'] = array();
    while (list($ssn, $qrSort) = $xoopsDB->fetchRow($result)) {
        foreach ($title_show_arr as $qcsn => $qc_arr) {
            $block['content'][$ssn]['col_data'][$qcsn] = get_jill_query_col_fillValue_qsn($ssn, $qcsn);
        }
        $block['content'][$ssn]['qrSort'] = $qrSort;
    }
    $block['title_arr'] = $title_show_arr;
    //die(var_dump($block));
    $block['query_arr'] = $query_arr;
    $block['qsn']       = $options[0];
    return $block;
}

//區塊編輯函式 (jill_query_public_edit)
function jill_query_public_edit($options)
{
    $default_qsn = (empty($options[0])) ? "" : $options[0];

    $option = get_public_menu_options($default_qsn);

    //die(var_dump($opt_arr));
    $form = "
  <table>
  	<tr>
      <th>
        <!--選擇公開事件 -->
        " . _MB_JILL_QUERY_PUBLIC_OPT0 . "
      </th>
      <td>
        <select name='options[0]'>
            <option value=''>" . _MB_JILL_QUERY__OPT0 . "</option>
			   {$option}
        </select>
      </td>
    </tr>
    <tr>
      <th>
        <!--秀幾筆 -->
        " . _MB_JILL_QUERY_PUBLIC_OPT1 . "
      </th>
      <td>
        <input type='text' name='options[1]' value='{$options[1]}'>
      </td>
    </tr>
  </table>
  ";
    return $form;
}
