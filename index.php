<?php
/**
 * User: Erdal Gunyar
 * Date: 28/01/2016
 * Time: 11:31
 */

/* Configuration & initialisation */
require_once 'app/config.php';
require_once 'app/init.php';
require_once 'app/libs/functions.php';
/* @var $_SMARTY Smarty */
/* @var $_DATA array */
global $_SMARTY, $_DATA;

/* Authentication */
if (AUTHENTICATION_ENABLED) {
    verifyAuth();
}

/* Actions */
if (isset($_REQUEST['action'])) {
    $action_path = 'actions/'.$_REQUEST['action'].'.php';
    if (file_exists(ROOT_DIR.$action_path)) {
        include_once "$action_path";

        // Clearing cache
        $_SMARTY->setCaching(Smarty::CACHING_LIFETIME_SAVED);
        $_SMARTY->clearCache('layout.tpl');
        $_SMARTY->setCaching(Smarty::CACHING_OFF);

        // Calling action
        call_user_func('action_'.$_REQUEST['action']);
    }

}

/* Page and controllers */
$_DATA['page'] = $_REQUEST['page'];
include 'controllers/'.$_REQUEST['page'].'.php';

/* View */
header('Content-Type: text/html; charset=utf-8');
foreach ($_DATA as $k => $v) {
    $_SMARTY->assign($k, $v);
    $_SMARTY->assign('rootUrl', ROOT_URL);
}
$_SMARTY->display('layout.tpl');

