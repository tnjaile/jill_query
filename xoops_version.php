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

$modversion = array();

//---模組基本資訊---//
$modversion['name']        = _MI_JILLQUERY_NAME;
$modversion['version']     = '2.5';
$modversion['description'] = _MI_JILLQUERY_DESC;
$modversion['author']      = _MI_JILLQUERY_AUTHOR;
$modversion['credits']     = _MI_JILLQUERY_CREDITS;
$modversion['help']        = 'page=help';
$modversion['license']     = 'GNU GPL 2.0';
$modversion['image']       = "images/logo.png";
$modversion['dirname']     = basename(__DIR__);

//---模組狀態資訊---//
$modversion['status_version']      = '2.51';
$modversion['release_date']        = '2022-03-31';
$modversion['module_website_url']  = 'https://github.com/tnjaile/';
$modversion['module_website_name'] = _MI_JILLQUERY_AUTHOR_WEB;
$modversion['module_status']       = 'release';
$modversion['author_website_url']  = 'https://github.com/tnjaile/';
$modversion['author_website_name'] = _MI_JILLQUERY_AUTHOR_WEB;
$modversion['min_php']             = '5.6';
$modversion['min_xoops']           = '2.5.8';

//---paypal資訊---//
$modversion['paypal']                  = array();
$modversion['paypal']['business']      = 'tnjaile@gmail.com';
$modversion['paypal']['item_name']     = 'Donation :' . _MI_JILLQUERY_AUTHOR;
$modversion['paypal']['amount']        = 0;
$modversion['paypal']['currency_code'] = 'USD';

//---安裝設定---//
$modversion['onInstall']   = "include/onInstall.php";
$modversion['onUpdate']    = "include/onUpdate.php";
$modversion['onUninstall'] = "include/onUninstall.php";

//---啟動後台管理界面選單---//
$modversion['system_menu'] = 1;

//---資料表架構---//
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][1]        = "jill_query";
$modversion['tables'][2]        = "jill_query_col";
$modversion['tables'][3]        = "jill_query_col_value";
$modversion['tables'][4]        = "jill_query_sn";
$modversion['tables'][5]        = "jill_query_tags";
//---管理介面設定---//
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = "admin/main.php";
$modversion['adminmenu']  = "admin/menu.php";

//---使用者主選單設定---//
$modversion['hasMain'] = 1;
//$i                     = 0;

//---樣板設定---//
$i                                          = 0;
$modversion['templates'][$i]['file']        = 'jill_query_adm_main.tpl';
$modversion['templates'][$i]['description'] = 'jill_query_adm_main.tpl for bootstrap3';

$i++;
$modversion['templates'][$i]['file']        = 'jill_query_adm_setcol.tpl';
$modversion['templates'][$i]['description'] = 'jill_query_adm_setcol.tpl for bootstrap3';

$i++;
$modversion['templates'][$i]['file']        = 'jill_query_adm_setsearch.tpl';
$modversion['templates'][$i]['description'] = 'jill_query_adm_setsearch.tpl for bootstrap3';

$i++;
$modversion['templates'][$i]['file']        = 'jill_query_adm_import.tpl';
$modversion['templates'][$i]['description'] = 'jill_query_adm_import.tpl for bootstrap3';

$i++;
$modversion['templates'][$i]['file']        = 'jill_query_adm_tag.tpl';
$modversion['templates'][$i]['description'] = 'jill_query_adm_tag.tpl for bootstrap3';

$i++;
$modversion['templates'][$i]['file']        = 'jill_query_index.tpl';
$modversion['templates'][$i]['description'] = 'jill_query_index.tpl';

$i++;
$modversion['templates'][$i]['file']        = 'jill_query_excel.tpl';
$modversion['templates'][$i]['description'] = 'jill_query_excel.tpl';

//---區塊設定---//
$i                                       = 0;
$modversion['blocks'][$i]['file']        = 'jill_query_show.php';
$modversion['blocks'][$i]['name']        = _MI_JILL_QUERY_SHOW_BLOCK_NAME;
$modversion['blocks'][$i]['description'] = _MI_JILL_QUERY_SHOW_BLOCK_DESC;
$modversion['blocks'][$i]['show_func']   = 'jill_query_show';
$modversion['blocks'][$i]['template']    = 'jill_query_show.tpl';
$modversion['blocks'][$i]['edit_func']   = 'jill_query_show_edit';
$modversion['blocks'][$i]['options']     = '';
$i++;
$modversion['blocks'][$i]['file']        = 'jill_query_public.php';
$modversion['blocks'][$i]['name']        = _MI_JILL_QUERY_PUBLIC_BLOCK_NAME;
$modversion['blocks'][$i]['description'] = _MI_JILL_QUERY_PUBLIC_BLOCK_DESC;
$modversion['blocks'][$i]['show_func']   = 'jill_query_public';
$modversion['blocks'][$i]['template']    = 'jill_query_public.tpl';
$modversion['blocks'][$i]['edit_func']   = 'jill_query_public_edit';
$modversion['blocks'][$i]['options']     = '|20';
