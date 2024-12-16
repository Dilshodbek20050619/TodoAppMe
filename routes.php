<?php

use App\Router;

$router = new Router();

if($router->isApiCall()){
    require 'routers/api.php';
}
require 'routers/web.php';