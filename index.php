<?php

require_once "config/database.php";
require_once "autoloader.php";

use controllers\DictionaryController;

define('BASE_URL', '/Dictionary');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = trim(str_replace(BASE_URL, '', $uri), '/');
$segments = explode('/', $path);

$authRoutes = ['login', 'register', 'logout'];
if (in_array($segments[0], $authRoutes)) {
    $controllerClass = 'controllers\\AuthController';
    $method = $segments[0];
} else {
    $controllerName = !empty($segments[0]) ? ucfirst($segments[0]) . 'Controller' : 'DictionaryController';
    $controllerClass = "controllers\\$controllerName";
    $method = $segments[1] ?? 'index';
}

if (class_exists($controllerClass)) {
    $controller = new $controllerClass($pdo);
    if (method_exists($controller, $method)) {
        call_user_func([$controller, $method]);
        exit;
    }
}

$defaultController = new DictionaryController($pdo);
$defaultController->index();
exit;
