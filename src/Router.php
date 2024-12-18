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
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->Rendor($route, $callback);
        }
    }

    public function putRoute($route, $callback): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $this->Rendor($route, $callback);
        }
    }

    public function delete($route, $callback): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            $this->Rendor($route, $callback);
        }
    }

    public function postRoute($route, $callback): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->Rendor($route, $callback);
        }
    }

    public function isApiCall(): bool
    {
        return mb_stripos($this->currentRoute, '/api') === 0;
    }

    public function isTelegram(): bool
    {
        return mb_stripos($this->currentRoute, '/telegram') === 0;
    }

    public function Rendor($route, $callback): void
    {
        $resourceValues = $this->getResource($route);
        if ($resourceValues) {
            $resourceRout = str_replace('{id}', $resourceValues, $route);
            if ($resourceRout == $this->currentRoute) {
                $callback($resourceValues);
                exit();
            }
        }
        if ($route == $this->currentRoute) {
            $callback($resourceValues);
            exit();
        }
    }
}