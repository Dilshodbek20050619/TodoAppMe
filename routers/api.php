<?php

use App\Router;

require_once 'src/Router.php';
require 'src/Todo.php';

$router=new Router();
$todo=new \App\Todo();

$router->getRoute('/api/todos',function () use ($todo){
    apiResponse($todo->get(33));
});
$router->getRoute('/api/todos/{id}',function ($todoId)use ($todo){
    apiResponse($todo->getById($todoId));
});