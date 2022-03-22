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

define('_MA_JILLQUERY_IMPORT_NOTE8', 'If you add "!" before the field name in the first line, it means it is set to "search field by member-email".After importing, please remember to 【modules/jill_query/admin/main.php】 then update the column of public for query by member-email.');
define('_MA_JILLQUERY_READ_GROUP', 'Readable group');
define('_MA_JILLQUERY_ISPUBLIC', 'Public');
define('_MA_JILLQUERY_ISPUBLIC_DESC', 'Is it public?');
define('_MA_JILLQUERY_ISLIKE', 'Enable keyword query');
//import.php
define('_MA_JILLQUERY_IMPORT_TITLE', 'Import an Excel file and directly create a query');
define('_MA_JILLQUERY_IMPORT_NOTE1', 'When importing, the file name will be used as the default project name.');
define('_MA_JILLQUERY_IMPORT_NOTE2', 'The first row of Excel is automatically regarded as the field name, so please fill in the complete Chinese.');
define('_MA_JILLQUERY_IMPORT_NOTE3', 'If you add "*" before the field name in the first line, it means it is set to "search field".');
define('_MA_JILLQUERY_IMPORT_NOTE4', 'When importing, the following data will also be imported, so please remove unnecessary data.');
define('_MA_JILLQUERY_IMPORT_NOTE5', 'After importing, please remember to set the fields to be displayed and search criteria settings.');
define('_MA_JILLQUERY_IMPORT_NOTE6', 'The more data, the longer the import time, please be patient.');
define('_MA_JILLQUERY_IMPORT_NOTE7', 'Sample file: <a href="http://120.115.2.90/uploads/Taiwan National Elementary School Communication Information.xlsx">Taiwan National Elementary School Communication Information.xlsx</a>');

//setsearch.php
define('_MA_JILLQUERY_SETCOL_STEP1', 'Please first click [Set the search operator] method');
define('_MA_JILLQUERY_SETCOL_STEP2', '(Foreground query page [Sketch])');
define('_MA_JILLQUERY_SEARCH', 'Query');
define('_MA_EMPTYCOL', '*The query method has not been set in the left column');
define('_FILL_ALL_FIELDS', '*All field values need to be filled in before querying');
define('_FILL_ANY_FIELDS', '*Fill in any field value to query it');
define('_MA_JILLQUERY__OPERATOR_AND', 'AND');
define('_MA_JILLQUERY__OPERATOR_OR', 'OR');
define('_MA_JILLQUERY__MAIN', 'Back to data management');
define('_MA_JILLQUERY_SMNAME1', 'Switch query homepage');
//setcol.php
define('_MA_JILLQUERY_QCSN', 'Field number');
define('_MA_JILLQUERY_QC_TITLE', 'Field name');
define('_MA_JILLQUERY_QCSNSEARCH', 'Search in this field');
define('_MA_JILLQUERY_SEARCH_OPERATOR', 'Search operator');
define('_MA_JILLQUERY_ISSHOW', 'Display column');
define('_MA_JILLQUERY_QCSORT', 'Sort column');
define('_MA_JILLQUERY_ADDCOL', 'Add import field');

//jill_query-list
define('_MA_JILLQUERY_EMPTYQSN', 'No such event number');
define('_MA_JILLQUERY_SETCOL', 'Set import field');
define('_MA_JILLQUERY_SETSEARCH_NON', 'There is only one search bar, no search operator is required');
define('_MA_JILLQUERY_SETSEARCH', 'Set search operator');
define('_MA_JILLQUERY_DATE', 'Opening hours');
define('_MA_JILLQUERY_ADD', 'Add event');
define('_MA_JILLQUERY_QSN', 'Number');
define('_MA_JILLQUERY_TITLE', 'Name');
define('_MA_JILLQUERY_DIRECTIONS', 'Description');
define('_MA_JILLQUERY_EDITOREMAIL', 'Conductor Email');
define('_MA_JILLQUERY_EDITOREMAIL_INFO', 'Email of the undertaker, please use; separate, be careful not to have spaces');
define('_MA_JILLQUERY_ISENABLE', 'Is it enabled?');
define('_MA_JILLQUERY_COUNTER', 'Number of viewers');
define('_MA_JILLQUERY_UID', 'Opener');
define('_MA_JILLQUERY_AMOUNT', 'Number of data');
define('_MA_JILLQUERY_COPY', 'Copy query');
define('_MA_JILLQUERY_COPYSUCCESS', 'The copy was successful, please modify the title');
define('_MA_JILLQUERY_PASSWD', 'Set query password');
define('_MA_JILLQUERY_EXPORT', 'Export EXCEL');
define('_MD_JILLQUERY_SORT_FAIL', 'Update failed');
define('_MD_JILLQUERY_SORTED', 'Update successfully');

//tag.php
define('_MA_JILLQUERY_TAG_SET', 'No tag');
define('_MA_JILLQUERY_TAG_TITLE', 'Tag');
define('_MA_JILLQUERY_TAG_FONTCOLOR', 'Text color');
define('_MA_JILLQUERY_TAG_COLOR', 'Background color');
define('_MA_JILLQUERY_TAG_ENABLE', 'Whether to enable');
define('_MA_JILLQUERY_TAG_DEMO', 'Example');
define('_MA_JILLQUERY_TAG_FUNC', 'Function');
define('_MA_JILLQUERY_TAG_NEW', 'New Tag');
define('_MA_JILLQUERY_TAG_ABLE', 'Enable');
define('_MA_JILLQUERY_TAG_UNABLE', 'Close');
define('_MA_JILLQUERY_TAG_AMOUNT', 'There are %s queries using this tag');
define('_MA_JILLQUERY_NO_PERMISSION', 'When there is no read permission');
