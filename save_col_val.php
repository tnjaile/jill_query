<?php
include "header.php";
use Xmf\Request;
$value = Request::getString('value');
$id = Request::getString('id');
$qsn = Request::getInt('qsn');
if (!get_undertaker($qsn)) {
	die(_MD_JILLQUERY_ILLEGAL);
}

// die(var_dump($_REQUEST));

list($ssn, $qcsn) = explode('-', $id);
$ssn = intval($ssn);
$qcsn = intval($qcsn);
$sql = "update " . $xoopsDB->prefix("jill_query_col_value") . " set `fillValue`='{$value}' where ssn='{$ssn}' and qcsn='{$qcsn}'";
$xoopsDB->queryF($sql);
echo $value;
