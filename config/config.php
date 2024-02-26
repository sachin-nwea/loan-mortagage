<?php
//Note: This file should be included first in every php page.
error_reporting(E_ALL^E_DEPRECATED^E_WARNING);
ini_set('display_errors', 'On');
define('BASE_PATH', dirname(__FILE__, 2));
define('CURRENT_PAGE', basename($_SERVER['REQUEST_URI']));

require_once BASE_PATH . '/lib/MysqliDb/MysqliDb.php';
require_once BASE_PATH . '/lib/helpers.php';
require_once BASE_PATH . '/lang/lang.php';
require_once BASE_PATH . '/lib/OrderingValues.php';
/*
|--------------------------------------------------------------------------
| DATABASE CONFIGURATION
|--------------------------------------------------------------------------
 */
//Local Config
if($_SERVER['HTTP_HOST'] == 'jewellery.local') {
    define("DB_HOST", "host.docker.internal");
    define("DB_USER", "root");
    define("DB_PASSWORD", base64_decode('cm9vdA=='));
} else {
    define("DB_HOST", "host.docker.internal");
    define("DB_USER", "root");
    define("DB_PASSWORD", base64_decode('cm9vdA=='));
}
const DB_NAME = "jewellery";
/**
 * Get instance of DB object
 */
function getDbInstance() {
	return new MysqliDb(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}