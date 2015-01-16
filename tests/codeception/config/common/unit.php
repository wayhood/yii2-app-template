<?php
/**
 * Application config for common unit tests
 */
return yii\helpers\ArrayHelper::merge(
    require(APPS_DIR . '/common/config/main.php'),
    require(APPS_DIR . '/common/config/main-local.php'),
    require(dirname(__DIR__) . '/config.php'),
    require(dirname(__DIR__) . '/unit.php'),
    [
        'id' => 'app-common',
        'basePath' => dirname(__DIR__),
    ]
);
