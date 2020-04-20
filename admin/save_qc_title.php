<?php
include "header.php";
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');

$value = system_CleanVars($_REQUEST, 'value', '', 'string');
$id    = system_CleanVars($_REQUEST, 'id', '', 'string');

list($col, $qcsn) = explode(':', $id);
$sql              = "update " . $xoopsDB->prefix("jill_query_col") . " set $qc_title='{$value}' where qcsn='{$qcsn}'";
$xoopsDB->queryF($sql);

echo $value;
