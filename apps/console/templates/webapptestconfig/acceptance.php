<?php
defined('YII_APP_BASE_PATH') or define('YII_APP_BASE_PATH', dirname(dirname(dirname(dirname(__DIR__)))));

defined('VENDOR_DIR') or define('VENDOR_DIR', YII_APP_BASE_PATH. '/vendor');
defined('TESTS_DIR') or define('TESTS_DIR', YII_APP_BASE_PATH . '/tests');
defined('APPS_DIR') or define('APPS_DIR', YII_APP_BASE_PATH . '/apps');
defined('ROOT_DIR') or define('ROOT_DIR', YII_APP_BASE_PATH);

/**
 * Application configuration for {appName} acceptance tests
 */
return yii\helpers\ArrayHelper::merge(
    require(APPS_DIR . '/common/config/main.php'),
    require(APPS_DIR . '/common/config/main-local.php'),
    require(APPS_DIR . '/{appName}/config/main.php'),
    require(APPS_DIR . '/{appName}/config/main-local.php'),
    require(dirname(__DIR__) . '/config.php'),
    require(dirname(__DIR__) . '/acceptance.php'),
    require(__DIR__ . '/config.php'),
    [
    ]
);
