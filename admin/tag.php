<?php
use Xmf\Request;
use XoopsModules\Tadtools\MColorPicker;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\Utility;

$isAdmin                      = true;
$xoopsOption['template_main'] = 'jill_query_adm_tag.tpl';
include_once "header.php";
include_once "../function.php";

/*-----------function區--------------*/
//jill_query_tagss編輯表單
function list_jill_query_tags($def_tag_sn = '')
{
    global $xoopsDB, $xoopsTpl;

    $sql              = 'SELECT * FROM ' . $xoopsDB->prefix('jill_query_tags') . '';
    $result           = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    $i                = 0;
    $tags_used_amount = tags_used_amount();
    $tagarr           = [];
    while (list($tag_sn, $tag, $font_color, $color, $enable) = $xoopsDB->fetchRow($result)) {
        $tag_amount = (empty($tags_used_amount[$tag_sn])) ? 0 : (int) $tags_used_amount[$tag_sn];

        $tagarr[$i]['tag_sn']     = $tag_sn;
        $tagarr[$i]['prefix_tag'] = mk_tag($tag_sn, 'all');
        $tagarr[$i]['enable']     = $enable;
        $tagarr[$i]['tag_amount'] = $tag_amount;
        $tagarr[$i]['tag']        = $tag;
        $tagarr[$i]['font_color'] = $font_color;
        $tagarr[$i]['color']      = $color;
        $tagarr[$i]['enable_txt'] = ('1' == $enable) ? _YES : _NO;
        $tagarr[$i]['mode']       = ($def_tag_sn == $tag_sn) ? 'edit' : 'show';
        $tagarr[$i]['checked']    = ($def_tag_sn == $tag_sn) ? 1 : '';
        $tagarr[$i]['amount']     = sprintf(_MA_JILLQUERY_TAG_AMOUNT, $tag_amount);
        $i++;
    }

    $xoopsTpl->assign('tag_sn', $def_tag_sn);
    $xoopsTpl->assign('tagarr', $tagarr);
    $xoopsTpl->assign('tag', $tag);
    $xoopsTpl->assign('font_color', $font_color);
    $xoopsTpl->assign('color', $color);
    require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
    $token = new \XoopsFormHiddenToken();
    $xoopsTpl->assign('XOOPS_TOKEN', $token->render());
    $MColorPicker = new MColorPicker('.color');
    $MColorPicker->render();

    $SweetAlert = new SweetAlert();
    $SweetAlert->render('delete_tag', 'tag.php?op=del_tag&tag_sn=', 'tag_sn');
}

function insert_jill_query_tags()
{
    global $xoopsDB;

    //安全判斷
    if (!$GLOBALS['xoopsSecurity']->check()) {
        $error = implode('<br>', $GLOBALS['xoopsSecurity']->getErrors());
        redirect_header('index.php', 3, $error);
    }

    $sql = 'insert into ' . $xoopsDB->prefix('jill_query_tags') . "  (`tag` , `font_color`, `color`  , `enable`) values('{$_POST['tag']}', '{$_POST['font_color']}', '{$_POST['color']}', '{$_POST['enable']}') ";
    // die($sql);
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
}

function update_jill_query_tags($tag_sn)
{
    global $xoopsDB;
    $sql = 'update ' . $xoopsDB->prefix('jill_query_tags') . "  set  tag = '{$_POST['tag']}',font_color = '{$_POST['font_color']}',color = '{$_POST['color']}',enable = '{$_POST['enable']}' where tag_sn='{$tag_sn}'";

    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
}

function jill_query_tags_stat($enable, $tag_sn)
{
    global $xoopsDB;

    $sql = 'update ' . $xoopsDB->prefix('jill_query_tags') . "  set enable = '{$enable}' where tag_sn='{$tag_sn}'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
}

function del_tag($tag_sn = '')
{
    global $xoopsDB;

    $sql = 'delete from ' . $xoopsDB->prefix('jill_query_tags') . " where tag_sn='{$tag_sn}'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
}

function tags_used_amount()
{
    global $xoopsDB, $xoopsTpl;

    $sql    = 'SELECT tag_sn,count(tag_sn) FROM ' . $xoopsDB->prefix('jill_query') . ' GROUP BY tag_sn ';
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    $main   = [];
    while (list($tag_sn, $count) = $xoopsDB->fetchRow($result)) {
        $main[$tag_sn] = $count;
    }

    return $main;
}
//前置字串
function mk_tag($tag_sn, $mode = '1')
{
    global $xoopsUser, $xoopsDB;

    if (empty($tag_sn)) {
        return;
    }

    $and_enable = ('all' === $mode) ? '' : "and enable='1'";

    $sql                            = 'select font_color,color,tag from ' . $xoopsDB->prefix('jill_query_tags') . " where `tag_sn`='$tag_sn' {$and_enable}";
    $result                         = $xoopsDB->query($sql);
    list($font_color, $color, $tag) = $xoopsDB->fetchRow($result);

    $prefix_tag = "<a class='badge' style='background-color:$color;font-weight:normal;color:$font_color;text-shadow:none;' href='" . XOOPS_URL . "/modules/jill_query/index.php?tag_sn=$tag_sn'>$tag</a>";

    return $prefix_tag;
}
/*-----------執行動作判斷區----------*/
$op     = Request::getString('op');
$tag_sn = Request::getInt('tag_sn');

switch ($op) {
    //新增資料
    case 'insert_jill_query_tags':
        $tag_sn = insert_jill_query_tags();
        header('location: ' . $_SERVER['PHP_SELF']);
        exit;

    //更新資料
    case 'update_jill_query_tags':
        update_jill_query_tags($tag_sn);
        header('location: ' . $_SERVER['PHP_SELF']);
        exit;

    //關閉資料
    case 'stat':
        jill_query_tags_stat($_GET['enable'], $tag_sn);
        header('location: ' . $_SERVER['PHP_SELF']);
        exit;

    //刪除資料
    case 'del_tag':
        del_tag($tag_sn);
        header('location: ' . $_SERVER['PHP_SELF']);
        exit;

    default:
        list_jill_query_tags($tag_sn);
        break;
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign("isAdmin", true);
require_once __DIR__ . '/footer.php';
