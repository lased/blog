<?
require_once dirname(__DIR__) . '/config/init.php';
require_once CONFIG . '/httpHeaders.php';

new Framework\App([
    'log' => ROOT . '/temp/exceptions.log',
    'db' => require_once CONFIG . '/db.php',
    'path' => APP
]);
