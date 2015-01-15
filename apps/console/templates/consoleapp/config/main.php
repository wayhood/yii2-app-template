<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-{appName}',
    'basePath' => dirname(__DIR__),
    'runtimePath' => ROOT_DIR .'/runtimes/{appName}',
    'bootstrap' => ['log'],
    'controllerNamespace' => '{appName}\controllers',
    'enableCoreCommands' => false,
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
];
