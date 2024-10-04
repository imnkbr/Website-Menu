<?php

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;
use Src\Controllers\MenuController;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Src/Controllers/MenuController.php';

$dispatcher = simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/admin/menu', [MenuController::class, 'getMenu']);
    $r->addRoute('POST', '/admin/menu', [MenuController::class, 'createMenu']);
    $r->addRoute('GET', '/menu', [MenuController::class, 'getMenu']);
});

// Fetch method and URI from server
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo json_encode(['message' => 'Not Found']);
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo json_encode(['message' => 'Method Not Allowed']);
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controller, $method] = $handler;
        (new $controller)->$method($vars);
        break;
}
