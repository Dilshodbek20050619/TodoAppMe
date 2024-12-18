<?php

use App\Router;

$router = new Router();


if($router->isApiCall()){
    require 'routers/api.php';
    exit();
}elseif ($router->isTelegramCall()){
    require 'routers/telegram.php';
    exit();
}
if($router->isTelegram()){
    require 'routers/telegram.php';
}
require 'routers/web.php';