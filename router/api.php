<?php

use App\Router;

require 'src/Router.php';
require 'src/Todo.php';

$router=new Router();
$todo=new \App\Todo();

$router->get('/api/todos',function () use ($todo){
    apiResponse($todo->getAllTodos(2));
});
$router->get('/api/todos/{id}',function ($todoId)use ($todo){
    apiResponse($todo->getTodo($todoId));
});