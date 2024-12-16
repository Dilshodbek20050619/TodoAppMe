<?php

namespace App;
class Router
{
    public $currentRoute;

    public function __construct()
    {
        $this->currentRoute = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
    public function getResource($route): false|string
    {
        $resourceIndex = mb_stripos($route, '{id}');
        if (!$resourceIndex) {
            return false;
        }
        $resourceValue = substr($this->currentRoute, $resourceIndex);

        if ($limit = mb_stripos($resourceValue, '/')) {
            return substr($resourceValue, 0, $limit);
        }
        return $resourceValue ? $resourceValue : false;
    }

    public function getRoute($route, $callback): void
    {
        var_dump(123);
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $resourceValues = $this->getResource($route);
            if ($resourceValues) {
                $callback($resourceValues);
                exit();
            }
            if ($route == $this->currentRoute) {
                $callback($resourceValues);
                exit();
            }
        }
    }

    public function postRoute($route, $callback): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $resourceValues = $this->getResource($route);
            if ($resourceValues) {
                $callback($resourceValues);
                exit();
            }
            if ($route == $this->currentRoute) {
                $callback();
                exit();
            }
        }
    }
    public function isApiCall(): bool
    {
        return mb_stripos($this->currentRoute,'/api') === 0;
    }
}