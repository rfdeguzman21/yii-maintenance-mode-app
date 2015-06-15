<?php
if (file_exists('_mtce.json')) { // maintenance mode checker
    $mtce = json_decode(file_get_contents('_mtce.json'));
    if ($mtce->status === true) {
        require('_mtce.php');
        exit();
    }
}


// change the following paths if necessary
$yii = '/var/lib/yii/framework/yii.php';
$config = dirname(__FILE__) . '/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
