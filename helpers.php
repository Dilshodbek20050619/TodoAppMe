<?php

use JetBrains\PhpStorm\NoReturn;

function view($page, $data = []): void
{
    extract($data);
    require 'view/' . $page . '.php';
}

function redirect($page): void
{
    header('Location:' . $page);
    exit;
}

#[NoReturn] function apiResponse($data): void
{

    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

//