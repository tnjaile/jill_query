<?php
include "../../../mainfile.php";
include "../function.php";
$qcsn = $_POST['qcsn'];
$name = $_POST['name'];
// die("qcsn==" . $qcsn . "name==" . $name);
echo change_enable($qcsn, $name);
//改變啟用狀態
function change_enable($qcsn = "", $name = "")
{
    global $xoopsDB;
    $colArr = get_jill_query_col($qcsn);

    if ($name == "qcsnSearch") {
        $new_pic                = $colArr['qcsnSearch'] == 1 ? XOOPS_URL . "/modules/jill_query/images/no.gif" : XOOPS_URL . "/modules/jill_query/images/yes.gif";
        $value                  = $colArr['qcsnSearch'] == 1 ? 0 : 1;
        $search_operator        = jill_query_col_search_operator($colArr['qsn']);
        $update_search_operator = ($value == 1) ? ",`search_operator` = '{$search_operator}' " : ",`search_operator` = 'or'";
    } elseif ($name == "isShow") {
        $new_pic                = $colArr['isShow'] == 1 ? XOOPS_URL . "/modules/jill_query/images/no.gif" : XOOPS_URL . "/modules/jill_query/images/yes.gif";
        $value                  = $colArr['isShow'] == 1 ? 0 : 1;
        $update_search_operator = "";
    } else {
        if ($colArr['qcsnSearch'] == 1) {
            $new_pic = $colArr['isLike'] == 1 ? XOOPS_URL . "/modules/jill_query/images/no.gif" : XOOPS_URL . "/modules/jill_query/images/yes.gif";
            $value   = $colArr['isLike'] == 1 ? 0 : 1;
        }
        $update_search_operator = "";

    }

    $sql = "update " . $xoopsDB->prefix("jill_query_col") . " set `$name`='{$value}' {$update_search_operator} where qcsn='{$qcsn}'  ";
    $xoopsDB->queryF($sql) or web_error($sql);
    return $new_pic;
}
