<?php

$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('dbspiaggie', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array(
    'classname' => 'Propel\\Runtime\\Connection\\DebugPDO',
    'dsn' => 'mysql:host=localhost;port=3306;dbname=dbspiaggie',
    'user' => 'root',
    'password' => 'root',
    'settings' =>
    array(
        'charset' => 'utf8mb4',
        'queries' =>
        array(
        ),
    ),
    'model_paths' =>
    array(
        0 => 'src',
        1 => 'vendor',
    ),
));
$manager->setName('dbspiaggie');
$serviceContainer->setConnectionManager('dbspiaggie', $manager);
$serviceContainer->setDefaultDatasource('dbspiaggie');
$serviceContainer->setLoggerConfiguration('defaultLogger', array (
  'type' => 'stream',
# 'path' => '/home/mud/Projects/sb/trunk/logs/sb_propel.log',
  'path' => '/var/www/html/htdocs/seatbeach/logs/sb_propel.log',
  'level' => 100,
));
#$serviceContainer->setLoggerConfiguration('defaultLogger',
#    array(
#    'type' => 'stream',
#    'path' => '../../logs/sb_propel.log',
#    'level' => 250,
