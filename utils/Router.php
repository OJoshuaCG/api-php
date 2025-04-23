<?php
class Router {
    private static $routes = [];

    public static function get($path, $controllerMethod) {
        self::addRoute('GET', $path, $controllerMethod);
    }

    public static function post($path, $controllerMethod) {
        self::addRoute('POST', $path, $controllerMethod);
    }

    public static function put($path, $controllerMethod) {
        self::addRoute('PUT', $path, $controllerMethod);
    }

    public static function delete($path, $controllerMethod) {
        self::addRoute('DELETE', $path, $controllerMethod);
    }

    private static function addRoute($method, $path, $controllerMethod) {
        self::$routes[] = [
            'method' => $method,
            'path' => $path,
            'controllerMethod' => $controllerMethod,
        ];
    }

    public static function dispatch($uri, $requestMethod) {
        foreach (self::$routes as $route) {
            if ($route['method'] === $requestMethod && self::matchPath($route['path'], $uri)) {
                list($controllerName, $methodName) = explode('@', $route['controllerMethod']);
                require_once './controllers/' . $controllerName . '.php';
                $controller = new $controllerName();
                $params = self::getParams($route['path'], $uri);
                call_user_func_array([$controller, $methodName], $params);
                return;
            }
        }
        Response::json(404, ["message" => "Recurso no encontrado"]);
    }

    private static function matchPath($routePath, $uri) {
        $routePath = explode('/', $routePath);
        $uri = explode('/', $uri);
        if (count($routePath) !== count($uri)) {
            return false;
        }
        foreach ($routePath as $i => $segment) {
            if (preg_match('/^{(.+)}$/', $segment, $matches)) {
                continue;
            }
            if ($segment !== $uri[$i]) {
                return false;
            }
        }
        return true;
    }

    private static function getParams($routePath, $uri) {
        $routePath = explode('/', $routePath);
        $uri = explode('/', $uri);
        $params = [];
        foreach ($routePath as $i => $segment) {
            if (preg_match('/^{(.+)}$/', $segment, $matches)) {
                $params[] = $uri[$i];
            }
        }
        return $params;
    }
}