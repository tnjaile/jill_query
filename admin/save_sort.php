<?php
include "../../../mainfile.php";
require dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';

$sort = 1;
foreach ($_POST['tr'] as $qcsn) {
    $sql = "update " . $xoopsDB->prefix("jill_query_col") . " set `qcSort`='{$sort}' where `qcsn`='{$qcsn}'";
    $xoopsDB->queryF($sql) or die(_MD_JILLQUERY_SORT_FAIL . " (" . date("Y-m-d H:i:s") . ")" . $sql);
    $sort++;
}

echo _MD_JILLQUERY_SORTED . " (" . date("Y-m-d H:i:s") . ")";
