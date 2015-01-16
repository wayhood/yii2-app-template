<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

defined('YII_APP_BASE_PATH') or define('YII_APP_BASE_PATH', dirname(dirname(dirname(__DIR__))));

defined('VENDOR_DIR') or define('VENDOR_DIR', YII_APP_BASE_PATH .'/vendor');
defined('TESTS_DIR') or define('TESTS_DIR', YII_APP_BASE_PATH .'/tests');
defined('APPS_DIR') or define('APPS_DIR', YII_APP_BASE_PATH .'/apps');
defined('ROOT_DIR') or define('ROOT_DIR', YII_APP_BASE_PATH);

defined('YII_{APPNAME}_TEST_ENTRY_URL') or define('YII_{APPNAME}_TEST_ENTRY_URL', parse_url(\Codeception\Configuration::config()['config']['test_entry_url'], PHP_URL_PATH));
defined('YII_TEST_{APPNAME}_ENTRY_FILE') or define('YII_TEST_{APPNAME}_ENTRY_FILE', APPS_DIR . '/{appName}/web/index-test.php');

require_once(VENDOR_DIR . '/autoload.php');
require_once(VENDOR_DIR . '/yiisoft/yii2/Yii.php');
require_once(APPS_DIR . '/common/config/bootstrap.php');
require_once(APPS_DIR . '/{appName}/config/bootstrap.php');

// set correct script paths

// the entry script file path for functional and acceptance tests
$_SERVER['SCRIPT_FILENAME'] = YII_TEST_{APPNAME}_ENTRY_FILE;
$_SERVER['SCRIPT_NAME'] = YII_{APPNAME}_TEST_ENTRY_URL;
$_SERVER['SERVER_NAME'] =  parse_url(\Codeception\Configuration::config()['config']['test_entry_url'], PHP_URL_HOST);
$_SERVER['SERVER_PORT'] =  parse_url(\Codeception\Configuration::config()['config']['test_entry_url'], PHP_URL_PORT) ?: '80';

Yii::setAlias('@tests', dirname(dirname(__DIR__)));
