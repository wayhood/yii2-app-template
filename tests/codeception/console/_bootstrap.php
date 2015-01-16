<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

defined('YII_APP_BASE_PATH') or define('YII_APP_BASE_PATH', dirname(dirname(dirname(__DIR__))));

defined('VENDOR_DIR') or define('VENDOR_DIR', YII_APP_BASE_PATH .'/vendor');
defined('TESTS_DIR') or define('TESTS_DIR', YII_APP_BASE_PATH .'/tests');
defined('APPS_DIR') or define('APPS_DIR', YII_APP_BASE_PATH .'/apps');
defined('ROOT_DIR') or define('ROOT_DIR', YII_APP_BASE_PATH);

require_once(VENDOR_DIR . '/autoload.php');
require_once(VENDOR_DIR . '/yiisoft/yii2/Yii.php');
require_once(APPS_DIR . '/common/config/bootstrap.php');
require_once(APPS_DIR . '/console/config/bootstrap.php');

// set correct script paths
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['SERVER_PORT'] = '80';

Yii::setAlias('@tests', dirname(dirname(__DIR__)));
