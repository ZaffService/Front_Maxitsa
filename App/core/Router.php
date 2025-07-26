<?php

namespace App\Core;

class Router
{
    public static function resolve(array $routes, array $middlewares)
    {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $uri = $uri ?: '/';  // Si l'URI est vide, utilisez '/'
        
        if (array_key_exists($uri, $routes)) {
            $route = $routes[$uri];
            
            // Vérification et exécution des middlewares
            if (isset($route['middleware'])) {
                foreach ((array)$route['middleware'] as $middleware) {
                    if (isset($middlewares[$middleware])) {
                        $middlewareClass = $middlewares[$middleware];
                        $middlewareInstance = new $middlewareClass();
                        $middlewareInstance->handle();
                    }
                }
            }
            
            // Exécution du contrôleur
            $controller = $route['controller'];
            $action = $route['action'];
            
            if (class_exists($controller)) {
                $controllerInstance = new $controller();
                if (method_exists($controllerInstance, $action)) {
                    $controllerInstance->$action();
                    return;
                }
            }
        }
        
        // Page non trouvée
        http_response_code(404);
        require_once __DIR__ . '/../../templates/errors/404.php';
    }
}