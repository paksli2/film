<?php


//  Общие настройки

ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

//  Подключение файлов системы

define('ROOT', dirname(__FILE__));
require_once(ROOT.'/config/Autoload.php');
require_once(ROOT.'/components/Router.php');

//  Вызор Router

$router = new Router();
$router->run();