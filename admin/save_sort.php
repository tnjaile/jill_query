<?php
include "../../../mainfile.php";
include XOOPS_ROOT_PATH . "/modules/tadtools/tad_function.php";

$sort = 1;
foreach ($_POST['tr'] as $qcsn) {
    $sql = "update " . $xoopsDB->prefix("jill_query_col") . " set `qcSort`='{$sort}' where `qcsn`='{$qcsn}'";
    $xoopsDB->queryF($sql) or die(_TAD_SORT_FAIL . " (" . date("Y-m-d H:i:s") . ")" . $sql);
    $sort++;
}

echo _TAD_SORTED . " (" . date("Y-m-d H:i:s") . ")";
