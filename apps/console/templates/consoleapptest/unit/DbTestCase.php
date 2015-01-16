<?php

namespace tests\codeception\{appName}\unit;

/**
 * @inheritdoc
 */
class DbTestCase extends \yii\codeception\DbTestCase
{
    public $appConfig = '@tests/codeception/config/{appName}/config.php';
}
