<?php
use Xmf\Request;
include "header.php";

$op     = Request::getString('op');
$name   = Request::getString('name');
$tag_sn = Request::getInt('value');
$qsn    = Request::getInt('pk');

if ($op == 'update_tag') {
    update_tag($name, $tag_sn, $qsn);
    // die($msg);
}
function update_tag($name, $tag_sn, $qsn)
{
    global $xoopsDB;

    $sql = "update " . $xoopsDB->prefix("jill_query") . " set `{$name}`='{$tag_sn}' where `qsn`='{$qsn}'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql, _FILE_, _LINE_);
    return $value;
}
