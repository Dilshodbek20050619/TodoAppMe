<?php
namespace App;
class Router
{
    public $currentRoute;

    public function __construct()
    {

        $this->currentRoute = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }


    public function resolveRoute($route, $callback, $method): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== $method) {
            return;
        }

        $pattern = preg_replace(pattern: /** @lang text */ '/\{([a-zA-Z_]+)\}/', replacement: '([^/]+)', subject: $route);
        $pattern = "~^" . $pattern . "$~";

        if (preg_match($pattern, $this->currentRoute, $matches)) {
            array_shift($matches);
            $callback(...$matches);
            exit();
        }
    }
    public function getResource($route)
    {
        $resourseIndex=mb_stripos($route,'{id}');
        if (!$resourseIndex) {
            return false;
        }
        $resourceValue =substr($this->currentRoute, $resourseIndex);
        if ($limit=mb_stripos($resourceValue,'/')) {
            return substr($resourceValue, 0, $limit);
        }
        return $resourceValue ? : false;
    }


    public function getRoute($route, $callback): void
    {
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            $resourseValue=$this->getResource($route);
            if ($resourseValue) {
                $resourseRoute = str_replace('{id}',$resourseValue, $route);
                if ($resourseRoute === $this->currentRoute) {
                    $callback($resourseValue);
                    exit();
                }
            }
            if ($route === $this->currentRoute) {
                $callback();
                exit();
            }
        }
    }


    public function postRoute($route, $callback): void
    {
//        $this->resolveRoute($route, $callback, 'POST');
    }

    public function post($route, $callback)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $resourceId =  $this->getResource($route);
            $route = str_replace('{id}', $resourceId, $route);
            if ($route==$this->currentRoute){
                $callback($resourceId);
                exit();
            }
        }
    }

    public function deleteRoute($route, $callback): void
    {
        $this->resolveRoute($route, $callback, 'DELETE');
    }

}