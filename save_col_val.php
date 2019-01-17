<?php
include "header.php";
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$value            = system_CleanVars($_REQUEST, 'value', '', 'string');
$id               = system_CleanVars($_REQUEST, 'id', '', 'string');
$qsn               = system_CleanVars($_REQUEST, 'qsn', '', 'int');
if (!get_undertaker($qsn)) {
    die(_MD_JILLQUERY_ILLEGAL);
}

// die(var_dump($_REQUEST));

list($ssn, $qcsn) = explode('-', $id);
$ssn              = intval($ssn);
$qcsn             = intval($qcsn);
$sql              = "update " . $xoopsDB->prefix("jill_query_col_value") . " set `fillValue`='{$value}' where ssn='{$ssn}' and qcsn='{$qcsn}'";
$xoopsDB->queryF($sql);
echo $value;
