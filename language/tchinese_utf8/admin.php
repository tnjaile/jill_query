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
xoops_loadLanguage('admin_common', 'tadtools');

define('_MA_JILLQUERY_READ_GROUP', '可讀取群組');
define('_MA_JILLQUERY_ISPUBLIC', '公開');
define('_MA_JILLQUERY_ISPUBLIC_DESC', '是否公開');
define('_MA_JILLQUERY_ISLIKE', '啟用關鍵字查詢');
//import.php
define('_MA_JILLQUERY_IMPORT_TITLE', '匯入Excel 檔並直接建立查詢');
define('_MA_JILLQUERY_IMPORT_NOTE1', '匯入時，會以檔名作為專案預設名稱。');
define('_MA_JILLQUERY_IMPORT_NOTE2', 'Excel 第一行自動視為欄位名稱，故請填寫完整中文。');
define('_MA_JILLQUERY_IMPORT_NOTE3', '第一行欄位名稱前若加上「*」代表設定為「搜尋欄位」。');
define('_MA_JILLQUERY_IMPORT_NOTE4', '匯入時，底下資料也會一併匯入，故不需要的資料請移除。');
define('_MA_JILLQUERY_IMPORT_NOTE5', '匯入後，請記得設定欲顯示欄位及搜尋條件設定。');
define('_MA_JILLQUERY_IMPORT_NOTE6', '資料數越多，匯入時間越久，請耐心等候。');
define('_MA_JILLQUERY_IMPORT_NOTE7', '範例檔：<a href="http://120.115.2.90/uploads/全臺灣國民小學通訊資料.xlsx">全臺灣國民小學通訊資料.xlsx</a>');

//setsearch.php
define('_MA_JILLQUERY_SETCOL_STEP1', '請先點選【設定搜尋運算符】的方式');
define('_MA_JILLQUERY_SETCOL_STEP2', '(前台查詢頁面【示意圖】)');
define('_MA_JILLQUERY_SEARCH', '查詢');
define('_MA_EMPTYCOL', '*左方欄位尚未設定查詢方式');
define('_FILL_ALL_FIELDS', '*需填寫所有欄位值方可進行查詢');
define('_FILL_ANY_FIELDS', '*填寫任一欄位值即可進行查詢');
define('_MA_JILLQUERY__OPERATOR_AND', 'AND');
define('_MA_JILLQUERY__OPERATOR_OR', 'OR');
define('_MA_JILLQUERY__MAIN', '回資料管理');
define('_MA_JILLQUERY_SMNAME1', '切換查詢主頁');
//setcol.php
define('_MA_JILLQUERY_QCSN', '欄位編號');
define('_MA_JILLQUERY_QC_TITLE', '欄位名稱');
define('_MA_JILLQUERY_QCSNSEARCH', '以此欄位搜尋');
define('_MA_JILLQUERY_SEARCH_OPERATOR', '搜尋運算符');
define('_MA_JILLQUERY_ISSHOW', '顯示欄位');
define('_MA_JILLQUERY_QCSORT', '排序欄位');
define('_MA_JILLQUERY_ADDCOL', '新增匯入欄位');

//jill_query-list
define('_MA_JILLQUERY_EMPTYQSN', '無此事件編號');
define('_MA_JILLQUERY_SETCOL', '設定匯入欄位');
define('_MA_JILLQUERY_SETSEARCH_NON', '僅有一個搜尋欄，無須設定搜尋運算符');
define('_MA_JILLQUERY_SETSEARCH', '設定搜尋運算符');
define('_MA_JILLQUERY_DATE', '開放時間');
define('_MA_JILLQUERY_ADD', '新增事件');
define('_MA_JILLQUERY_QSN', '編號');
define('_MA_JILLQUERY_TITLE', '名稱');
define('_MA_JILLQUERY_DIRECTIONS', '說明');
define('_MA_JILLQUERY_EDITOREMAIL', '承辦人Email');
define('_MA_JILLQUERY_EDITOREMAIL_INFO', '承辦人Email，請用;隔開，注意不要有空格');
define('_MA_JILLQUERY_ISENABLE', '是否啟用');
define('_MA_JILLQUERY_COUNTER', '瀏覽人數');
define('_MA_JILLQUERY_UID', '開設者');
define('_MA_JILLQUERY_AMOUNT', '資料數');
define('_MA_JILLQUERY_COPY', '複製查詢');
define('_MA_JILLQUERY_COPYSUCCESS', '複製成功，請修改標題');
define('_MA_JILLQUERY_PASSWD', '設定查詢密碼');
define('_MA_JILLQUERY_EXPORT', '匯出EXCEL');
define('_MD_JILLQUERY_SORT_FAIL', '更新失敗');
define('_MD_JILLQUERY_SORTED', '更新成功');
