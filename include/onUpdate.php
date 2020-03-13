<?php
/**
 * Jill Query module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package    Jill Query
 * @since      2.5
 * @author     jill lee(tnjaile@gmail.com)
 * @version    $Id $
 **/

use XoopsModules\Jill_query\Update;
if (!class_exists('XoopsModules\Jill_query\Update')) {
    include dirname(__DIR__) . '/preloads/autoloader.php';
}
function xoops_module_update_jill_query($module, $old_version)
{
    if (Update::chk_chk1()) {
        Update::go_update1();
    }
    if (Update::chk_chk2()) {
        Update::go_update2();
    }
    if (Update::chk_chk3()) {
        Update::go_update3();
    }
    if (Update::chk_chk4()) {
        Update::go_update4();
    }
    if (Update::chk_chk5()) {
        Update::go_update5();
    }
    Update::del_interface();
    return true;
}
