<?php
/**
 * Rikiki MVC v1.0
 *
 * User: Erdal Gunyar
 * Date: 28/01/2016
 * Time: 11:48
 */

/* Path settings */
define('ROOT_DIR', getcwd().'/');

/* Composer autoload */
require (ROOT_DIR.'app/vendor/autoload.php');

/* DB */
Propel::init(ROOT_DIR.'db/build/conf/orm-conf.php');

/* Global variables */
global $_DATA, $_SMARTY;
$_DATA = [];

/* Smarty settings */
$_SMARTY = new Smarty();
$_SMARTY->setTemplateDir(ROOT_DIR.'tpl');
$_SMARTY->setCompileDir(ROOT_DIR.'app/cache/templates');
$_SMARTY->setCacheDir(ROOT_DIR.'app/cache/full-page');
$_SMARTY->setConfigDir(ROOT_DIR.'config/');
$caching = CACHING_ENABLED?Smarty::CACHING_LIFETIME_CURRENT:Smarty::CACHING_OFF;
$_SMARTY->setCaching($caching);
$_SMARTY->setCacheLifetime(-1); // Never expires
$_SMARTY->setCompileCheck(ENVIRONMENT == 'dev');

/* Session */
session_start();
if ($_SESSION['error']) {
    $_DATA['error'] = $_SESSION['error'];
    $_SESSION['error'] = false;
    unset($_SESSION['error']);
}

