<?php

use App\Router;

require_once 'src/Router.php';
require 'src/Todo.php';

$router = new Router();
$todo = new \App\Todo();

$router->getRoute('/api/todos/{id}', function ($todoId) use ($todo) {
    apiResponse($todo->getById($todoId));
});
$router->postRoute('/api/todos', function () use ($todo) {
    $todo->store($_POST['title'], $_POST['due_date'], $_POST['status'], 4);
    apiResponse([
        'ok' => true,
        'message' => 'Todo created successfully'
    ]);
});
$router->getRoute('/api/todos', function () use ($todo) {
    apiResponse($todo->get(4));
});
$router->putRoute('/api/todos/{id}', function ($todoId) use ($todo) {
    $todo->update($todoId, $_POST['title'], $_POST['due_date'], $_POST['status']);
    apiResponse([
        'ok' => true,
        'message' => 'Todo update successfully'
    ]);
});
$router->delete('/api/todos/{id}', function ($todoId) use ($todo) {
    $todo->delete($todoId);
    apiResponse([
        'ok' => true,
        'message' => 'Todo delete successfully'
    ]);
});