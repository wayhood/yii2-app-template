<?php

namespace tests\codeception\{appName}\unit;

/**
 * @inheritdoc
 */
class TestCase extends \yii\codeception\TestCase
{
    public $appConfig = '@tests/codeception/config/{appName}/config.php';
}
