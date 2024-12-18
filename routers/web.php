<?php

use App\Controller;
use App\Router;

$router = new Router();
$controller = new Controller();
$router->getRoute('/', [$controller, 'home']);

$router->postRoute('/logout', [$controller, 'logout']);

$router->getRoute('/register', [$controller, 'register']);
$router->postRoute('/register', [$controller, 'storeUser']);

$router->getRoute('/login', [$controller, 'login']);
$router->postRoute('/login', [$controller, 'storeLogin']);

$router->getRoute('/todos', [$controller, 'showTodos']);
$router->postRoute('/todos', [$controller, 'storeTodo']);

$router->getRoute('/todos/{id}/delete', function ($id) use ($controller) {
    $controller->deleteTodo($id);
    dd(3);
});
$router->getRoute('/todos/{id}/edit', function ($id) use ($controller) {
    $controller->updateTodoForm($id);
});
$router->postRoute('/todos/{id}/edit', function ($id) use ($controller) {
    $controller->updateTodoData($id);
});