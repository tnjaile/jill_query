<?php
/**
 * Jill Query module
 *
 * @copyright  The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package    Jill Query
 * @since      2.5
 * @author     jill lee(tnjaile@gmail.com)
 * @version    $Id $
 **/
use Xmf\Request;
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
include "header.php";
include_once XOOPS_ROOT_PATH . "/header.php";

/*-----------功能函數區--------------*/
//轉址
function redirect_query($qsn, $k) {
	global $xoopsDB;

	if (empty($qsn) || empty($k)) {
		return;
	}
	$myts = \MyTextSanitizer::getInstance();
	$k = $myts->addSlashes($k);

	$sql = "select qcsn from `" . $xoopsDB->prefix("jill_query_col") . "`
            where `qsn` = '{$qsn}' && `qcsnSearch`='1'";
	$result = $xoopsDB->query($sql) or Utility::web_error($sql);
	list($qcsn) = $xoopsDB->fetchRow($result);

	$sql2 = "select ssn from `" . $xoopsDB->prefix("jill_query_col_value") . "`
    where `qcsn`='{$qcsn}' && `fillValue`='{$k}' ";
	$result2 = $xoopsDB->query($sql2) or Utility::web_error($sql2);
	list($ssn) = $xoopsDB->fetchRow($result2);
	// die($sql2);
	$sql3 = "select qcsn from `" . $xoopsDB->prefix("jill_query_col") . "`
            where `qsn` = '{$qsn}' && `isUrl`='1'";
	$result3 = $xoopsDB->query($sql3) or Utility::web_error($sql3);
	list($qcsn_url) = $xoopsDB->fetchRow($result3);

	$sql4 = "select fillValue from `" . $xoopsDB->prefix("jill_query_col_value") . "`
    where `qcsn`='{$qcsn_url}' && `ssn`='{$ssn}' ";
	$result4 = $xoopsDB->query($sql4) or Utility::web_error($sql4);
	// die($sql4);
	list($redirect) = $xoopsDB->fetchRow($result4);
	// die(var_dump($redirect));
	header('location:' . $redirect);
	exit;
}
/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$qsn = Request::getInt('qsn');
$k = Request::getString('k');
/*---判斷動作請貼在下方---*/

$query_arr = get_jill_query($qsn);
if ($query_arr['ispublic'] == '2') {
	redirect_query($qsn, $k);
} else {
	header("location:index.php");
	exit;
}

/*---判斷動作請貼在上方---*/

/*-----------秀出結果區--------------*/
$xoopsTpl->assign("toolbar", Utility::toolbar_bootstrap($interface_menu));
$xoopsTpl->assign("isAdmin", $isAdmin);
include_once XOOPS_ROOT_PATH . '/footer.php';
