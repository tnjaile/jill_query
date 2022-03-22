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
xoops_loadLanguage('main', 'tadtools');

define('_MD_JILLQUERY_USER', 'download the member-email file');
define('_MD_JILLQUERY_KEYWORD', 'input the keyword,next');
define('_MD_JILLQUERY_QCTITLESEARCH', 'select query column,first');
define('_MD_JILLQUERY_BINDEMAIL', 'query by member-email');
define('_MD_JILLQUERY_LOGINREQUIRED', 'login enquiry');
define('_MD_JILLQUERY_PUBLIC', 'View all public information');
define('_MD_JILLQUERY_PUBLICERROR', 'This event is not publicly queried');
define('_MD_JILLQUERY_PUBLICQUERY', 'The current query event is:');
define('_MD_JILLQUERY_PREFIX_TAG', 'Tag');
define('_MD_JILLQUERY_ALL', 'All');
define('_MD_JILLQUERY_CLOSED', 'This event is closed');

//excel.php
define('_MD_JILLQUERY_SAMPLE', 'Please download the <i class="fa fa-file-excel-o"></i> template file first');
define('_MD_JILLQUERY_EMPTYQSN', 'No such event number');
define('_MD_JILLQUERY_EMPTYVALUE', 'Incomplete fields are filled in');
define('_MD_JILLQUERY_EMPTY_SEARCH', 'Search field is not set');
define('_MD_JILLQUERY_NOFILE', 'No file selected');
define('_MD_JILLQUERY_NODATA', 'No data');
define('_MD_JILLQUERY_NOCOL', 'No field');
define('_MD_JILLQUERY_ILLEGAL', 'No permission');
define('_MD_JILLQUERY_ROW', 'Column');
define('_MD_JILLQUERY_QCSN', 'Field number');
define('_MD_JILLQUERY_QRSORT', 'Data sorting field');
define('_MD_JILLQUERY_FILL_VALUE', 'Content');
define('_MD_CONTINUE_NO', 'Import after clearing old data');
define('_MD_CONTINUE', 'Import connection data number');
//index.php
define('_MD_JILLQUERY_DATAMANAGEMENT', 'Import data');
define('_MD_JILLQUERY_STOP', 'End query');
define('_MD_JILLQUERY_SEARCH', 'Query now');
define('_MD_JILLQUERY_BACKSEARCH', 'Re-query');
define('_MD_JILLQUERY_NOTOPEN', 'Not yet open');
define('_MD_NOFORM', 'No query information yet');
define('_MD_JILLQUERY_PERIOD', 'Registration period');
define('_MD_JILLQUERY_SMNAME1', 'Check homepage');
define('_MD_JILLQUERY_RESULT', 'Query results');
define('_MD_REQUIRED', '*This column must be filled in before you can make a query');
define('_MD_OPTIONAL', '*This column is optional');
define('_MD_JILLQUERY_SETCOL', 'Set import field');
define('_MD_JILLQUERY_SETSEARCH', 'Set search operator');
define("_MD_JILLQUERY_TITLE", "Import a total of %s data <small>(you can click the data to edit and modify)</small>");
define("_MD_JILLQUERY_TOTAL", "(Total %s data)");
define('_MD_JILLQUERY_STEP', 'Step');
define('_MD_JILLQUERY_STEP2', 'Import an Excel file, the first line must be the field name');
define('_MD_JILLQUERY_PASSWDERROR', 'Password input error');
define('_MD_JILLQUERY_PASSWD', 'Enter the query password');
