<?php
// comment out the following two lines when deployed to production
$isProdHost = ($_SERVER['HTTP_HOST'] == 'volniy.by');
defined('YII_DEBUG') or define('YII_DEBUG', !$isProdHost);
defined('YII_ENV') or define('YII_ENV', $isProdHost ? 'prod' : 'dev');

require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/app/config/web.php');
(new yii\web\Application($config))->run();
