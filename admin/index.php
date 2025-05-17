<?php

require_once __DIR__ . '/../autoloader.php';
require_once __DIR__ . '/../config/database.php';

$uri = $_SERVER['REQUEST_URI'];
$path = parse_url($uri, PHP_URL_PATH);
$segments = explode('/', trim($path, '/'));

$baseIndex = array_search('Dictionary', $segments);
$adminIndex = array_search('admin', $segments);

if ($adminIndex !== $baseIndex + 1) {
    http_response_code(404);
    echo "Некоректний шлях до адмінки";
    exit;
}

$controller = $segments[$adminIndex + 1] ?? 'admin';
$action     = $segments[$adminIndex + 2] ?? 'index';
$id         = $segments[$adminIndex + 3] ?? null;

if ($controller === 'admin' && ($segments[$adminIndex + 2] ?? null) === 'admin') {
    $action = 'index';
    $id = $segments[$adminIndex + 3] ?? null;
}

$controllerClass = 'admin\\controllers\\' . ucfirst($controller) . 'Controller';

if (class_exists($controllerClass)) {
    $instance = new $controllerClass($pdo);
    if (method_exists($instance, $action)) {
        $id ? $instance->$action((int)$id) : $instance->$action();
    } else {
        http_response_code(404);
        echo "Метод '$action' не знайдено в $controllerClass";
    }
} else {
    http_response_code(404);
    echo "Контролер '$controllerClass' не знайдено";
}
