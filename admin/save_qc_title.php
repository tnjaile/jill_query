<?php
use Xmf\Request;
include "header.php";
$value = Request::getString('value');
$id    = Request::getString('id');

list($col, $qcsn) = explode(':', $id);
$sql              = "update " . $xoopsDB->prefix("jill_query_col") . " set $qc_title='{$value}' where qcsn='{$qcsn}'";
$xoopsDB->queryF($sql);

echo $value;
