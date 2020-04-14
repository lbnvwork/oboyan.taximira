<?php

/**
 * Front controller
 * PHP version 7.0
 */

//подкючение composer
require dirname(__DIR__).'/vendor/autoload.php';

//begin корневая дирректория
$dirName = dirname(__DIR__);
chdir($dirName);
define('ROOT_PATH', $dirName.'/');
//end корневая дирректория

/**
 * Вывод ошибок
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

//кодировка
header('Content-Type: text/html; charset=utf-8');

//begin подключение роутов
/** @var \Core\Router $router */
$router = new \Core\Router();

$router->add(
    '', [
        'controller' => 'Home',
        'action' => 'index'
    ]
);
$router->add(
    'politika', [
        'controller' => 'Politica',
        'action' => 'index',
        'method' => ['GET']
    ]
);
$router->add(
    'conditions', [
        'controller' => 'Conditions',
        'action' => 'index',
        'method' => ['GET']
    ]
);
//end подключение роутов

//запуск приложения
$router->dispatch($_SERVER['QUERY_STRING']);
