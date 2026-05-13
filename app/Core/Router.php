<?php

namespace App\Core;

class Router {
    private static $routes = [];

    public static function get($uri, $callback) {
        self::$routes['GET'][$uri] = $callback;
    }

    public static function post($uri, $callback) {
        self::$routes['POST'][$uri] = $callback;
    }

    public static function dispatch($uri, $method) {
        $uri = strtok($uri, '?'); // Eliminar query string
        $uri = rtrim($uri, '/');
        if ($uri === '') $uri = '/';

        if (isset(self::$routes[$method][$uri])) {
            $callback = self::$routes[$method][$uri];
            
            if (is_array($callback)) {
                $controller = new $callback[0]();
                $method = $callback[1];
                return $controller->$method();
            }
            
            return call_user_func($callback);
        }

        // Manejo básico de 404
        http_response_code(404);
        echo "404 - Página no encontrada";
        exit();
    }
}
