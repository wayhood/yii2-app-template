<?php
$_SERVER['SCRIPT_FILENAME'] = YII_TEST_{APPNAME}_ENTRY_FILE;
$_SERVER['SCRIPT_NAME'] = YII_{APPNAME}_TEST_ENTRY_URL;

/**
 * Application configuration for {appName} functional tests
 */
return yii\helpers\ArrayHelper::merge(
    require(APPS_DIR . '/common/config/main.php'),
    require(APPS_DIR . '/common/config/main-local.php'),
    require(APPS_DIR . '/{appName}/config/main.php'),
    require(APPS_DIR . '/{appName}/config/main-local.php'),
    require(dirname(__DIR__) . '/config.php'),
    require(dirname(__DIR__) . '/functional.php'),
    require(__DIR__ . '/config.php'),
    [
    ]
);
