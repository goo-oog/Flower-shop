<?php
declare(strict_types=1);

require_once 'vendor/autoload.php';

use Flowershop\Controllers\MainPageController;
use Flowershop\Controllers\CheckoutController;
use Flowershop\Controllers\NotFoundController;

session_start();
setcookie(session_name(), session_id(), time() + 300);

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->get('/', [MainPageController::class, 'index']);
    $r->post('/', [MainPageController::class, 'index']);
    $r->post('/checkout', [CheckoutController::class, 'index']);
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
if ($pos = (strpos($uri, '?') !== false)) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        call_user_func([NotFoundController::class, 'index']);
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        call_user_func([NotFoundController::class, 'index']);
        $allowedMethods = $routeInfo[1];
        break;
    case FastRoute\Dispatcher::FOUND:
        call_user_func($routeInfo[1]);
        break;
}